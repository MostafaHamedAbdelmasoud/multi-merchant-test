<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CustomTagShippingPriceRequest extends FormRequest
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

    private function createValidation()
    {
        return [
            'tag_id' => 'required|exists:tags,id',
            'cost_outside_cairo' => 'required',
            'cost_inside_cairo' => 'required',
        ];
    }

    private function updateValidation()
    {
        return [
            'id' => 'required|exists:custom_tag_shipping_prices,id',
            'tag_id' => 'required|exists:tags,id',
            'cost_outside_cairo' => 'required',
            'cost_inside_cairo' => 'required',
        ];
    }

    private function idValidation()
    {
        return [
            'id' => 'required|exists:custom_tag_shipping_prices,id'
        ];
    }

    private function allValidation()
    {
        return [
            'is_paginate' => 'in:0,1',
            'is_banned' => 'in:0,1',
        ];
    }

}
