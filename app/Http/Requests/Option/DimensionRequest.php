<?php

namespace App\Http\Requests\Option;

use Illuminate\Foundation\Http\FormRequest;

class DimensionRequest extends FormRequest
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
            case 'edit':
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
            'dimension' => 'required|min:2|unique:dimensions,dimension',
        ];
    }

    private function updateValidation()
    {
        return [
            'id' => 'required|exists:dimensions,id',
            'dimension' => 'required|min:2|unique:dimensions,dimension,' . $this->id,
//            'dimension' => ['required', \Illuminate\Validation\Rule::unique('dimensions')->ignore($this->id)],
        ];
    }

    private function idValidation()
    {
        return [
            'id' => 'required|exists:dimensions,id'
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
