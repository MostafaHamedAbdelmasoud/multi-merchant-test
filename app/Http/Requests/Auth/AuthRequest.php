<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            case 'register':
                return $this->registerRules();
            case 'login':
                return $this->loginRules();
            case 'change-password':
                return $this->changePasswordRules();
            case 'forget-password':
                return $this->forgetPassword();
            case 'reset-password':
                return $this->resetPassword();
            case 'check-code':
                return $this->checkCode();
            default:
                return [];
        }
    }

    private function registerRules()
    {
//        var_dump($this);
        return [
            'name' => 'required',
            'phone' => 'required|digits:11|unique:users,phone',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ];
    }

    private function loginRules()
    {
        return [
            'email' => 'required|exists:users,email',
            'password' => 'required|min:8',
        ];
    }

    public function changePasswordRules()
    {
        return [
            'old_password' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
        ];
    }


    private function forgetPassword()
    {
        return [
            'email' => 'required|exists:users,email',
        ];
    }

    private function resetPassword()
    {
        return [
            'email' => 'required|exists:users,email',
            'password' => 'required|min:8|max:22|confirmed',
//            'code' => 'required|exists:password_resets,token',
        ];
    }


    private function checkCode()
    {
        return [
            'email' => 'required|min:11|exists:users,email',
            'code' => 'required|exists:password_resets,token',
        ];
    }
}
