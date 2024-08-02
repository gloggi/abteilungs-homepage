<?php

namespace App\Http\Controllers;

use App\Mail\AutoResponse;
use App\Mail\WebForm;
use App\Models\Form;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class WebFormController extends Controller
{
    public function store(Request $request)
    {
        $form = Form::find($request->id);
        $fields = $form->getAllFields();
        $filledForm = $request->all();

        $matchedFields = [];
        foreach ($filledForm as $key => $value) {
            foreach ($fields as $field) {
                if (isset($field['uuid']) && str_replace('_', '', $key) === str_replace('-', '', $field['uuid'])) {
                    if ($field['input_type'] == 'date') {
                        $matchedFields[$field['label']] = Carbon::parse($value)->format('d.m.Y');
                    } elseif ($field['input_type'] == 'email') {
                        $matchedFields[$field['label']] = "<a href='mailto:$value'>$value</a>";
                    } else {
                        $matchedFields[$field['label']] = $value;
                    }

                    break;
                }
            }
        }
        $setting = Setting::with(['divisionLogo', 'websiteIcon', 'notFoundPage'])->find(1);

        Mail::to($form->email)->send(new WebForm($form, $matchedFields, $setting));
        if ($form->enable_autoresponse && $form->autoresponse_email_field_id) {
            $autoresponseEmail = $filledForm[Str::snake(str_replace('-', '', $form->autoresponseField->label))];
            $autoresponseMessage = $form->autoresponse_message;
            $autoresponseSubject = $form->autoresponse_subject;

            Mail::to($autoresponseEmail)->send(new AutoResponse($autoresponseSubject, $autoresponseMessage, $setting));
        }

        return response()->json(['message' => 'Sent!'], 201);
    }
}
