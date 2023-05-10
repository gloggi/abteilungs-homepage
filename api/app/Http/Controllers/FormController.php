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
            'name' => 'required|string|max:255',
            'fields' => 'required|array|min:1',
            'fields.*.type' => 'required|string|in:textField,textareaField,selectField',
            'fields.*.options' => 'nullable|array|min:1',
            'fields.*.label' => 'required|string|max:255',
        ]);

        $form = Form::create([
            'name' => $validatedData['name'],
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
            'name' => 'required|string|max:255',
            'fields' => 'required|array|min:1',
            'fields.*.id' => '',
            'fields.*.type' => 'required|string|in:textField,textareaField,selectField',
            'fields.*.options' => 'nullable|array|min:1',
            'fields.*.label' => 'required|string|max:255',
        ]);

        $form = Form::find($id);
        $form->name = $validatedData['name'];
        $form->save();

        $this->createFieldsFromValidatedData($form, $validatedData);

        $currentFields = $form->getAllFields();
        foreach ($currentFields as $currentField) {
            $found = false;
            foreach ($validatedData['fields'] as $fieldData) {
                if (!isset($fieldData['id']) || $currentField->id == $fieldData['id']) {
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
        return response()->json([
            
            'id' => $form->id,
            'name' => $form->name,
            'fields' => $form->getAllFields(),
    ], 200);

    }

    public function destroy($id)
    {
        $form = Form::find($id);
        $form->delete();
        return response()->json('Form removed successfully');
    }
    private function createFieldsFromValidatedData(Form $form, $validatedData){
        foreach ($validatedData['fields'] as $fieldData) {
            switch ($fieldData['type']) {
                case 'textField':
                    TextField::updateOrCreate(
                        ['id' => $fieldData['id'] ?? null],
                        [
                            'label' => $fieldData['label'],
                            'form_id' => $form->id
                        ]
                    );
                    break;
                case 'textareaField':
                    TextareaField::updateOrCreate(
                        ['id' => $fieldData['id'] ?? null],
                        [
                            'label' => $fieldData['label'],
                            'form_id' => $form->id
                        ]
                    );
                    break;
                case 'selectField':
                    $selectField = SelectField::updateOrCreate(
                        ['id' => $fieldData['id'] ?? null],
                        [
                            'label' => $fieldData['label'],
                            'form_id' => $form->id
                        ]
                    );
                    if(isset($fieldData['options'])){
                    foreach($fieldData['options'] as $option){
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
        }
    }

}