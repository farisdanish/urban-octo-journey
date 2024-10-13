<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            // Profile details
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'min:7', 'max:15'],
            'email' => ['required', 'email', 'max:255'],

            // Shipping address validation
            'shipping.address1' => ['required', 'string', 'max:255'],
            'shipping.address2' => ['nullable', 'string', 'max:255'],
            'shipping.city' => ['required', 'string', 'max:255'],
            'shipping.state_id' => ['required', 'exists:states,id'], // Validate state ID
            'shipping.zipcode' => ['required', 'string', 'max:10'],

            // Billing address validation
            'billing.address1' => ['required', 'string', 'max:255'],
            'billing.address2' => ['nullable', 'string', 'max:255'],
            'billing.city' => ['required', 'string', 'max:255'],
            'billing.state_id' => ['required', 'exists:states,id'], // Validate state ID
            'billing.zipcode' => ['required', 'string', 'max:10'],
        ];
    }

    /**
     * Custom attribute names for error messages.
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'billing.address1' => 'billing address 1',
            'billing.address2' => 'billing address 2',
            'billing.city' => 'billing city',
            'billing.state_id' => 'billing state',
            'billing.zipcode' => 'billing zip code',
            
            'shipping.address1' => 'shipping address 1',
            'shipping.address2' => 'shipping address 2',
            'shipping.city' => 'shipping city',
            'shipping.state_id' => 'shipping state',
            'shipping.zipcode' => 'shipping zip code',
        ];
    }
}