<?php

namespace App\Http\Requests;

use App\Models\Order;
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
            "reference" => ['string', 'same:reference'],
            "status" => ["boolean"],
            "date" => ["required"],
            "price" => ["required"]
        ];


    }

    protected function prepareForValidation()
    {
        $latestOrder = Order::latest('id')->first();

        if($latestOrder == null){
            $this->merge([
                'reference' => "REF1",
            ]);
        }else{
            $increment = (int)filter_var($latestOrder->reference, FILTER_SANITIZE_NUMBER_INT) + 1;
            $this->merge([
                'reference' => "REF".strval($increment),
            ]);
        }
    }
}
