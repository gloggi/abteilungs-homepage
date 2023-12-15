<?php
namespace App\Http\Controllers;

use App\Models\OptionField;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\TextField;
use App\Models\TextareaField;
use App\Models\SelectField;

class FormController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $forms = Form::paginate($perPage, ['*'], 'page', $page);
        $data = $forms->items();
        $meta = [
            'current_page' => $forms->currentPage(),
            'from' => $forms->firstItem(),
            'last_page' => $forms->lastPage(),
            'path' => $forms->path(),
            'per_page' => $forms->perPage(),
            'to' => $forms->lastItem(),
            'total' => $forms->total(),
        ];
        return response()->json([
            'data' => $data,
            'meta' => $meta
        ]);
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'fields' => 'nullable|array',
            'fields.*.type' => 'required|string|in:textField,textareaField,selectField',
            'fields.*.input_type' => 'nullable',
            'fields.*.required' => 'nullable',
            'fields.*.sort' => 'nullable',
            'fields.*.option_fields' => 'nullable|array|min:1',
            'fields.*.label' => 'nullable|string|max:255',
        ]);

        $form = Form::create([
            isset($validatedData['name']) ? $validatedData['name'] : null,
        ]);

        $this->createFieldsFromValidatedData($form, $validatedData);

        return response()->json([
                'id' => $form->id,
                'name' => $form->name,
                'fields' => $form->getAllFields(),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'fields' => 'nullable|array',
            'email' => 'nullable',
            'subject' => 'nullable',
            'fields.*.input_type' => 'nullable',
            'fields.*.id' => '',
            'fields.*.sort' => 'nullable',
            'fields.*.required' => 'nullable',
            'fields.*.type' => 'required|string|in:textField,textareaField,selectField',
            'fields.*.option_fields' => 'nullable|array|min:1',
            'fields.*.label' => 'nullable|string|max:255',
        ]);
        
        $form = Form::find($id);
        $form->name = $validatedData['name'];
        $form->email = $validatedData['email'];
        $form->subject = $validatedData['subject'];
        $form->save();

        $this->createFieldsFromValidatedData($form, $validatedData);

        $currentFields = $form->getAllFields();
        foreach ($currentFields as $currentField) {
            $found = false;
            foreach ($validatedData['fields'] as $fieldData) {
                if(!isset($fieldData['id']) || ($currentField->id == $fieldData['id'] && $currentField->type == $fieldData['type'])) {
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
        return response()->json(array_merge($form->toArray(),[
            'fields' => $form->getAllFields(),
    ]), 200);

    }

    public function destroy($id)
    {
        $form = Form::find($id);
        $form->delete();
        return response()->json('Form removed successfully');
    }
    private function createFieldsFromValidatedData(Form $form, $validatedData){
        if( !isset($validatedData['fields'])) {
            return;
        }
        $validatedData['fields'] = collect($validatedData['fields'])->sortBy('sort')->values()->all();
        $sort_counter =0;
        foreach ($validatedData['fields'] as $fieldData) {
            switch ($fieldData['type']) {
                case 'textField':
                    TextField::updateOrCreate(
                        ['id' => $fieldData['id'] ?? null],
                        [
                            'label' => $fieldData['label']??'',
                            'form_id' => $form->id,
                            'required' => $fieldData['required']??false,
                            'input_type' => $fieldData['input_type'],
                            'sort' =>  $sort_counter
                        ]
                    );
                    break;
                case 'textareaField':
                    TextareaField::updateOrCreate(
                        ['id' => $fieldData['id'] ?? null],
                        [
                            'label' => $fieldData['label']??'',
                            'form_id' => $form->id,
                            'required' => $fieldData['required']??false,
                            'sort' =>  $sort_counter
                        ]
                    );
                    break;
                case 'selectField':
                    $selectField = SelectField::updateOrCreate(
                        ['id' => $fieldData['id'] ?? null],
                        [
                            'label' => $fieldData['label']??'',
                            'form_id' => $form->id,
                            'required' => $fieldData['required']??false,
                            'sort' =>  $sort_counter
                        ]
                    );
                    if(isset($fieldData['option_fields'])){
                        
                       
                    foreach($fieldData['option_fields'] as $option){
                       
                        OptionField::updateOrCreate(
                            ['id' => $option['id'] ?? null],
                            [
                                'name' => $option['name'],
                                'select_field_id' => $selectField->id
                            ]);

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