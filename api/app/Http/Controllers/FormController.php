<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Models\Form;
use App\Models\OptionField;
use App\Models\SelectField;
use App\Models\TextareaField;
use App\Models\TextField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 1000);
        $user = Auth::user();
        $query = Form::query();
        if ($request->has('dashboard') && !$user->hasRole('admin')) {
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
        if(!$user->hasRole('admin')&&!isset($validatedData['group_id'])){
            $groups = $user->groups->pluck('id');
            $validatedData['group_id'] = $groups->first();
        }

        $form = Form::create($validatedData);

        $this->createFieldsFromValidatedData($form, $validatedData);

        return response()->json([
            'id' => $form->id,
            'name' => $form->name,
            'fields' => $form->getAllFields(),
        ], 201);
    }

    public function update(UpdateFormRequest $request, $id)
    {
        $form = Form::find($id);
        if (!$form) {
            return response()->json(['message' => 'Form not found'], 404);
        }
        $validatedData = $request->validated();
        $user = Auth::user();
        if(!$user->hasRole('admin')){
            $groups = $user->groups->pluck('id');
            $groupId = isset($validatedData['group_id']) ? $validatedData['group_id'] : null;
            if(!$groupId||!$groups->contains($groupId)){
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $form->update($validatedData);

        $this->createFieldsFromValidatedData($form, $validatedData);

        $currentFields = $form->getAllFields();
        foreach ($currentFields as $currentField) {
            $found = false;
            foreach ($validatedData['fields'] as $fieldData) {
                if (!isset($fieldData['id']) || ($currentField->id == $fieldData['id'] && $currentField->type == $fieldData['type'])) {
                    $found = true;

                    break;
                }
            }
            if (!$found) {
                $currentField->delete();
            }
        }
        $form = Form::find($id);

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

        if (!$form) {
            return response()->json(['message' => 'Form not found'], 404);
        }
        $user = Auth::user();
        if(!$user->hasRole('admin')){
            $groups = $user->groups->pluck('id');
            $groupId = $form->group_id;
            if(!$groups->contains($groupId)){
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $form->delete();

        return response()->json(null, 204);
    }

    private function createFieldsFromValidatedData(Form $form, $validatedData)
    {
        if (!isset($validatedData['fields'])) {
            return;
        }
        $validatedData['fields'] = collect($validatedData['fields'])->sortBy('sort')->values()->all();
        $sort_counter = 0;
        foreach ($validatedData['fields'] as $fieldData) {
            switch ($fieldData['type']) {
                case 'textField':
                    TextField::updateOrCreate(
                        ['id' => $fieldData['id'] ?? null],
                        [
                            'label' => $fieldData['label'] ?? '',
                            'form_id' => $form->id,
                            'required' => $fieldData['required'] ?? false,
                            'input_type' => $fieldData['input_type'],
                            'sort' => $sort_counter
                        ]
                    );
                    break;
                case 'textareaField':
                    TextareaField::updateOrCreate(
                        ['id' => $fieldData['id'] ?? null],
                        [
                            'label' => $fieldData['label'] ?? '',
                            'form_id' => $form->id,
                            'required' => $fieldData['required'] ?? false,
                            'sort' => $sort_counter
                        ]
                    );
                    break;
                case 'selectField':
                    $selectField = SelectField::updateOrCreate(
                        ['id' => $fieldData['id'] ?? null],
                        [
                            'label' => $fieldData['label'] ?? '',
                            'form_id' => $form->id,
                            'required' => $fieldData['required'] ?? false,
                            'sort' => $sort_counter
                        ]
                    );
                    if (isset($fieldData['option_fields'])) {


                        foreach ($fieldData['option_fields'] as $option) {

                            OptionField::updateOrCreate(
                                ['id' => $option['id'] ?? null],
                                [
                                    'name' => $option['name'],
                                    'select_field_id' => $selectField->id
                                ]
                            );

                        }
                    }
                    break;
                default:
                    throw new \InvalidArgumentException("Unsupported field type: {$fieldData['type']}");
            }
            $sort_counter++;
        }
    }

}
