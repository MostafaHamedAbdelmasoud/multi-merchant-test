<?php

namespace App\Http\Requests\Review;

use App\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReviewRequest extends FormRequest
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
            case 'create':
                return $this->createValidation();
            case 'update':
                return $this->updateValidation();
            case 'delete':
            case 'get':
                return $this->idValidation();
            case 'all':
                return $this->allValidation();
            default:
                return [];
        }
    }

    public function messages()
    {
        return [
//            'order_id.in' => 'You Already had made a review on this order',
            'order_id.in' => 'can not rate this order',
        ];
    }

    public function createValidation()
    {


        return [
            'star' => 'required|numeric|between:0,5.00',
            'name' => 'string',
            'email' => 'string',
            'title' => 'string',
            'comment' => 'string',
        ];
    }

    public function updateValidation()
    {
        return [
            'id' => 'required|exists:reviews,id',
            'star' => 'numeric|between:0,5.00',
            'name' => 'string',
            'email' => 'string',
            'title' => 'string',
            'comment' => 'string',
        ];
    }

    public function idValidation()
    {
        return
            [
                'id' => 'required|exists:reviews,id',
            ];
    }

    public function allValidation()
    {
        $product_ids = implode(',', Product::pluck('id')->toArray());
        return
            [
                'product_id' => "required|in:$product_ids",
            ];
    }
}
