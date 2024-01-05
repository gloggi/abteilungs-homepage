<?php

namespace App\Http\Controllers;

use App\Mail\WebForm;
use App\Traits\TransformTrait;
use Illuminate\Http\Request;
use App\Models\Form;
use Illuminate\Support\Facades\Mail;


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
                    $matchedFields[$field['label']] = $value;
                    break;
                }
            }
        }

        Mail::to($form->email)->send(new WebForm($form->subject,$matchedFields));

        return response()->json(["message"=>"Sent!"], 201);
    }

   
}
