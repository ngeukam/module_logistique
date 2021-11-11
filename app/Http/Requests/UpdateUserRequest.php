<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        // User::$rules['password'] = 'required';
         User::$rules['email'] = 'required|string|email|max:255';
         User::$rules['phone'] = 'required|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|min:15';
        return User::$rules;
    }
}