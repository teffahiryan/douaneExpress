<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        return [
            "reference" => ['string'],
            "status" => ["boolean"],
            "date" => ["required"],
        ];


    }

    protected function prepareForValidation()
    {
        $this->merge([
            'reference' => "REF".strval(random_int(0, 20000000)),
        ]);
    }
}
