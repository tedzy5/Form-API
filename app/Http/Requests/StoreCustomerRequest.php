<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
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
        return [
            'first_name' => 'required|alpha_dash|min:3|max:15',
            'last_name' => 'required|alpha_dash|min:2|max:20',
            'email' => ['required', 'email'],
            'phone' => ['numeric', 'nullable'],
            'category' => 'required|numeric',
        ];
    }
}
