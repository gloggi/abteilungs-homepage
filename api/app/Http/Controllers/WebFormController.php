<?php

namespace App\Http\Controllers;

use App\Mail\AutoResponse;
use App\Mail\WebForm;
use App\Models\Form;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebFormController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:forms,id',
            'fields' => 'present|array',
            'fields.*.uuid' => 'required|uuid',
            'fields.*.value' => 'nullable',
        ]);

        $form = Form::findOrFail($validated['id']);

        $submittedValues = collect($validated['fields'])
            ->mapWithKeys(fn ($field) => [strtolower($field['uuid']) => $field['value'] ?? null]);
        $matchedFields = [];
        foreach ($form->getAllFields() as $field) {
            $value = $submittedValues->get(strtolower($field->uuid));
            if (! is_scalar($value) || trim((string) $value) === '') {
                continue;
            }

            $formattedValue = $this->formatValue($field, (string) $value);
            if ($formattedValue === null) {
                continue;
            }

            $matchedFields[] = [
                'label' => $field->label,
                'value' => $formattedValue,
            ];
        }

        $setting = Setting::with(['divisionLogo', 'websiteIcon', 'notFoundPage'])->find(1);

        Mail::to($form->email)->send(new WebForm($form, $matchedFields, $setting));

        $autoresponseEmail = $this->autoresponseEmail($form, $submittedValues->all());
        if ($autoresponseEmail) {
            Mail::to($autoresponseEmail)->send(new AutoResponse(
                $form->autoresponse_subject,
                $form->autoresponse_message,
                $setting
            ));
        }

        return response()->json(['message' => 'Sent!'], 201);
    }

    private function formatValue($field, string $value): ?string
    {
        if ($field->type === 'selectField') {
            $option = $field->optionFields->first(
                fn ($option) => strtolower($option->uuid) === strtolower($value)
            );

            return $option ? e($option->name) : null;
        }

        if ($field->type === 'textareaField') {
            return nl2br(e($value));
        }

        switch ($field->input_type) {
            case 'date':
                try {
                    return e(Carbon::parse($value)->format('d.m.Y'));
                } catch (\Throwable) {
                    return e($value);
                }
            case 'email':
                $escaped = e($value);

                return filter_var($value, FILTER_VALIDATE_EMAIL)
                    ? "<a href='mailto:{$escaped}'>{$escaped}</a>"
                    : $escaped;
            default:
                return e($value);
        }
    }

    private function autoresponseEmail(Form $form, array $submittedValues): ?string
    {
        if (! $form->enable_autoresponse || ! $form->autoresponse_email_field_uuid) {
            return null;
        }

        $field = $form->autoresponseField;
        if (! $field || (int) $field->form_id !== (int) $form->id) {
            return null;
        }

        $email = $submittedValues[strtolower($field->uuid)] ?? null;

        return is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;
    }
}
