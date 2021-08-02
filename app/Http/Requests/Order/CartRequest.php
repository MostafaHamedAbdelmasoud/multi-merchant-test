<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;


class CartRequest extends FormRequest
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
        $k = count($this->segments());
        $endPoint = $this->segment($k);
        switch ($endPoint) {
            case 'add-to-cart':
                return $this->addToCartValidation();
            case 'update':
                return $this->updateValidation();
            case 'delete':
                return $this->idValidation();
            default:
                return [];
        }
    }

    private function addToCartValidation()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'min:1',
        ];
    }

    private function updateValidation()
    {
        return [
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|min:1',
        ];
    }

    private function idValidation()
    {
        return [
            'id' => 'required|integer|exists:carts,id'
        ];
    }

}
