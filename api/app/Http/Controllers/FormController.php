<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Models\Form;
use App\Models\OptionField;
use App\Models\SelectField;
use App\Models\TextareaField;
use App\Models\TextField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FormController extends Controller
{
    private const FIELD_MODELS = [TextField::class, TextareaField::class, SelectField::class];

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 1000);
        $user = Auth::user();
        $query = Form::query();
        if ($request->has('search')) {
            $searchResults = Form::search($request->input('search'))->get();
            $query = $query->whereIn('id', $searchResults->pluck('id'));
        }
        if ($request->has('dashboard') && ! $user->hasRole('admin')) {
            $groupIds = $user->groups->pluck('id');
            $query->whereIn('group_id', $groupIds);
        }

        $forms = $query->paginate($perPage);

        return response()->json($forms);
    }

    public function store(StoreFormRequest $request)
    {

        $validatedData = $request->validated();
        $user = Auth::user();
        if (! $user->hasRole('admin') && ! isset($validatedData['group_id'])) {
            $groups = $user->groups->pluck('id');
            $validatedData['group_id'] = $groups->first();
        }

        $form = Form::create($validatedData);

        $this->createFieldsFromValidatedData($form, $validatedData);
        $this->ensureValidAutoresponseField($form);

        return response()->json([
            'id' => $form->id,
            'name' => $form->name,
            'fields' => $form->getAllFields(),
        ], 201);
    }

    public function update(UpdateFormRequest $request, $id)
    {
        $form = Form::find($id);
        if (! $form) {
            return response()->json(['message' => 'Form not found'], 404);
        }
        $validatedData = $request->validated();
        $user = Auth::user();
        if (! $user->hasRole('admin')) {
            $groups = $user->groups->pluck('id');
            $groupId = isset($validatedData['group_id']) ? $validatedData['group_id'] : null;
            if (! $groupId || ! $groups->contains($groupId)) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $form->update($validatedData);

        $currentFields = collect($form->getAllFields());
        $validatedFields = collect($validatedData['fields']);

        $currentFieldKeys = $currentFields->map(function ($field) {
            return ['id' => $field->id, 'type' => $field->type];
        });

        $validatedFieldKeys = $validatedFields->map(function ($field) {
            return ['id' => $field['id'] ?? null, 'type' => $field['type']];
        });

        $idsToDelete = $currentFieldKeys->filter(function ($currentKey) use ($validatedFieldKeys) {
            return ! $validatedFieldKeys->contains(function ($validatedKey) use ($currentKey) {
                return $validatedKey['id'] === $currentKey['id'] && $validatedKey['type'] === $currentKey['type'];
            });
        });

        foreach ($currentFields as $field) {
            if ($idsToDelete->contains(['id' => $field->id, 'type' => $field->type])) {
                $field->delete();
                unset($field);
            }
        }

        $this->createFieldsFromValidatedData($form, $validatedData);

        $form = Form::find($id);
        $this->ensureValidAutoresponseField($form);

        return response()->json([

            'id' => $form->id,
            'name' => $form->name,
            'fields' => $form->getAllFields(),
        ], 200);
    }

    public function show($id)
    {
        $form = Form::find($id);

        return response()->json(array_merge($form->toArray(), [
            'fields' => $form->getAllFields(),
        ]), 200);

    }

    public function destroy($id)
    {
        $form = Form::find($id);

        if (! $form) {
            return response()->json(['message' => 'Form not found'], 404);
        }
        $user = Auth::user();
        if (! $user->hasRole('admin')) {
            $groups = $user->groups->pluck('id');
            $groupId = $form->group_id;
            if (! $groups->contains($groupId)) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $form->delete();

        return response()->json(null, 204);
    }

    private function createFieldsFromValidatedData(Form $form, $validatedData)
    {
        if (! isset($validatedData['fields'])) {
            return;
        }
        $validatedData['fields'] = collect($validatedData['fields'])->sortBy('sort')->values()->all();
        $sort_counter = 0;
        foreach ($validatedData['fields'] as $fieldData) {
            $attributes = [
                'label' => $fieldData['label'] ?? '',
                'required' => $fieldData['required'] ?? false,
                'sort' => $sort_counter,
            ];

            switch ($fieldData['type']) {
                case 'textField':
                    $this->upsertField(TextField::class, $form, $fieldData, array_merge($attributes, [
                        'input_type' => $fieldData['input_type'],
                    ]));
                    break;
                case 'textareaField':
                    $this->upsertField(TextareaField::class, $form, $fieldData, $attributes);
                    break;
                case 'selectField':
                    $selectField = $this->upsertField(SelectField::class, $form, $fieldData, $attributes);
                    $this->syncOptionFields($selectField, $fieldData['option_fields'] ?? []);
                    break;
                default:
                    throw new \InvalidArgumentException("Unsupported field type: {$fieldData['type']}");
            }
            $sort_counter++;
        }
    }

    private function upsertField(string $modelClass, Form $form, array $fieldData, array $attributes): Model
    {
        $field = isset($fieldData['id'])
            ? $modelClass::where('form_id', $form->id)->find($fieldData['id'])
            : null;

        if (! $field && isset($fieldData['uuid'])) {
            $field = $modelClass::where('form_id', $form->id)->where('uuid', $fieldData['uuid'])->first();
        }

        if ($field) {
            $field->update($attributes);

            return $field;
        }

        return $modelClass::create(array_merge($attributes, [
            'form_id' => $form->id,
            'uuid' => $this->availableUuid($fieldData['uuid'] ?? null, self::FIELD_MODELS),
        ]));
    }

    private function syncOptionFields(SelectField $selectField, array $options): void
    {
        $keptIds = [];

        foreach ($options as $optionData) {
            $attributes = ['name' => $optionData['name'] ?? null];

            $option = isset($optionData['id'])
                ? $selectField->optionFields()->find($optionData['id'])
                : null;

            if (! $option && isset($optionData['uuid'])) {
                $option = $selectField->optionFields()->where('uuid', $optionData['uuid'])->first();
            }

            if ($option) {
                $option->update($attributes);
                $keptIds[] = $option->id;

                continue;
            }

            $created = $selectField->optionFields()->create(array_merge($attributes, [
                'uuid' => $this->availableUuid($optionData['uuid'] ?? null, [OptionField::class]),
            ]));
            $keptIds[] = $created->id;
        }

        $selectField->optionFields()->whereNotIn('id', $keptIds)->delete();
    }

    /**
     * Returns the uuid proposed by the dashboard if it is valid and not yet
     * used, otherwise null (the model then generates a fresh one).
     *
     * Accepting the client uuid lets the dashboard reference a field (e.g. as
     * autoresponse e-mail field) before it has been saved for the first time.
     */
    private function availableUuid(?string $candidate, array $modelClasses): ?string
    {
        if (! is_string($candidate) || ! Str::isUuid($candidate)) {
            return null;
        }

        $candidate = strtolower($candidate);

        foreach ($modelClasses as $modelClass) {
            if ($modelClass::where('uuid', $candidate)->exists()) {
                return null;
            }
        }

        return $candidate;
    }

    /**
     * The autoresponse field must be an e-mail text field of this form.
     */
    private function ensureValidAutoresponseField(Form $form): void
    {
        if (! $form->autoresponse_email_field_uuid) {
            return;
        }

        $isValid = $form->textFields()
            ->where('uuid', $form->autoresponse_email_field_uuid)
            ->where('input_type', 'email')
            ->exists();

        if (! $isValid) {
            $form->update(['autoresponse_email_field_uuid' => null]);
        }
    }
}
