<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required',
        ];
        if (empty($this->input('u'))) {
            $rules['email'] = [
                'required',
                'email',
                'unique:users,email,' . $this->input('u'),
                'password' => 'required',
            ];
        } else {
            $rules['email'] = [
                'email',
            ];
        }
        return $rules;
    }
}
