<?php

namespace App\Http\Requests;

use App\Models\EmployeeDependent;
use App\Rules\AlphaSpaces;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeDependentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('employee_dependent_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required','string', new AlphaSpaces,'max:50',
            ],
            'cnic' => [
                'string','nullable','max:15'
            ],
            'cell_no' => [
                'string','nullable', 'max:12'
            ],
            'marriage_date' => [
                'date','nullable'
            ],
            'marriage_place' => [
                'string','nullable','max:50',new AlphaSpaces
            ],
            'address' => [
                'required','string','regex:/^[a-zA-Z0-9,\.#\/\- ]*$/','max:100',
            ],
            'nationality' => [
                'nullable','required_if:relation,Wife,Husband','string',new AlphaSpaces,'max:50',
            ],
            'religion' => [
                'nullable','required_if:relation,Wife,Husband','string',Rule::in(array_keys(EmployeeDependent::RELGION_SELECT)), 
            ],
            'cast' => [
                'nullable','string', new AlphaSpaces,'max:20',
            ],
            'gender' => [
                'string','required_if:relation,Son,Daughter','nullable',
                function ($attribute, $value, $fail) {
                    $relation = request('relation');
                    if (($relation === 'Son' && $value !== 'M') || ($relation === 'Daughter' && $value !== 'F')) {
                        $fail("The $attribute must match the relation. For $relation, gender must be " . ($relation === 'Son' ? 'Male' : 'Female') . ".");
                    }
                },
            ],
            'profession' => [
                'string','nullable','max:50',new AlphaSpaces
            ],
            'relation' => [
                'required','string',Rule::in(array_keys(EmployeeDependent::RELATION_SELECT))
            ],
            'date_of_birth' => [
                'date','nullable'
            ],
        ];
    }

    public function messages():array{

        return [
            'cast.regex' => ':attribute can only have alphabets and space',
            'address.regex' => ':attribute can only have alphabets, . , # @ and space characters.',
            'address.max' => ':attribute cannot be greater than 110 characters.',
            'nationality.max' => ':attribute cannot be greater than 50 characters.',
            'nationality.regex' => ':attribute can only have alphabets and spaces.',
            'profession.regex' => ':attribute can only have alphabets and spaces.',
        ];
    }
}
