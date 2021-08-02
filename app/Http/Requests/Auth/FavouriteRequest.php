<?php

namespace App\Http\Requests\Auth;

use App\Models\Order\Operator;
use App\Models\Order\Order;
use App\Models\User\User;
use App\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FavouriteRequest extends FormRequest
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
//            case 'all':
//                return $this->allValidation();
            default:
                return [];
        }
    }


    public function createValidation()
    {

        return [
            'product_id' => 'exists:products,id',
        ];
    }

    public function updateValidation()
    {
        return [
            'id' => 'required|exists:favourites,id',
            'product_id' => 'exists:products,id',
        ];
    }

    public function idValidation()
    {
        return
            [
                'id' => 'required|exists:favourites,id',
            ];
    }

//    public function allValidation()
//    {
//        $user_ids = implode(',', User::pluck('id')->toArray());
//        return
//            [
//                'user_id' => "in:$user_ids",
//            ];
//    }
}
