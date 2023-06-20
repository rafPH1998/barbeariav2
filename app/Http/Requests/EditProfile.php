<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $authUser = auth()->user()->id;

        return [
            'name' =>  [
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('users')->ignore($authUser),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($authUser),
            ],
            'password' => 'nullable|min:4|max:20'
        ];
    }
}
