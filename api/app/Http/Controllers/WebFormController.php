<?php

namespace App\Http\Controllers;

use App\Mail\WebForm;
use App\Models\Form;
use App\Traits\TransformTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;


class WebFormController extends Controller
{

    use TransformTrait;


    public function store(Request $request)
    {
        $form = Form::find($request->id);
        $fields = $form->getAllFields();
        $filledForm = $request->all();

        $matchedFields = [];
        foreach ($filledForm as $key => $value) {
            foreach ($fields as $field) {
                if (isset($field['label']) && $key === $this->toSnakeCase($field['label'])) {
                    if ($field['input_type'] == 'date') {
                        $matchedFields[$field['label']] = Carbon::parse($value)->format('d.m.Y');
                    } else if ($field['input_type'] == 'email') {
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

        return response()->json(["message" => "Sent!"], 201);
    }


}
