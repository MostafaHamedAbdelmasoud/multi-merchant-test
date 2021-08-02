<?php

namespace App\Http\Requests\Other;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            case 'delete':
                return $this->idValidation();
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
            'first_name' => 'required|min:1',
            'last_name' => 'required|min:1',
            'email' => 'required_without:phone_number|min:1',
            'phone_number' => 'required_without:email|max:11|min:1',
            'message' => 'required|min:2'
        ];
    }


    private function idValidation()
    {
        return [
            'id' => 'nullable|exists:contacts,id'
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
