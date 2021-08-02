<?php

namespace App\Http\Requests\Division;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            'name_en' => 'required|min:2',
            'name_ar' => 'required|min:2',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    private function updateValidation()
    {
        return [
            'id' => 'required|exists:tags,id',
            'name_en' => 'min:2',
            'name_ar' => 'min:2',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    private function idValidation()
    {
        return [
            'id' => 'required|exists:tags,id'
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
