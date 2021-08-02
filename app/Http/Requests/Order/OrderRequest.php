<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class OrderRequest extends FormRequest
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
            case 'status':
                return $this->updateStatusRules();
            case 'grand-total':
                return $this->grandTotal();
            case 'checkout':
                return $this->checkout();
            case 'order-details':
                return $this->orderDetails();
            case 'search':
                return $this->search();
            case 'delete':
                return $this->orderIdRules();
            case 'update-status':
                return $this->updateStatusValidation();
            case 'update-payment':
                return $this->updatePaymentValidation();
            case 'recalculate':
            case 'update':
                return $this->recalculateValidation();
            case 'filter':
                return $this->filter();
            default:
                return [];
        }
    }

    private function orderIdRules()
    {
        return [
            'order_id' => 'required|exists:orders,id'
        ];
    }

    private function updateStatusRules()
    {
        return [
            'status' => 'required|in:1,2,3,4,5',
            'id' => 'required|exists:orders,id',
        ];
    }

    private function grandTotal()
    {
        return [
            'payment_type_id' => 'exists:payment_methods,code',
            'code' => 'exists:coupons,code',
            'address_id' => 'required|exists:addresses,id',
        ];
    }

    private function checkout()
    {
        return [
//            'token' => 'required|exists:users,hash_token',
            'address_id' => 'required|exists:addresses,id',
            'code' => 'nullable|exists:coupons,code',
            'payment_type_id' => 'required|exists:payment_types,id',
//            'Amount' => 'required',
//            'Currency' => 'required',
//            'MerchantReference' => 'required',
//            'NetworkReference' => 'required',
//            'PaidThrough' => 'required',
//            'PayerAccount' => 'required',
//            'PayerName' => 'required',
//            'SecureHash' => 'required',
//            'SystemReference' => 'required',
//            'TxnDate' => 'required',
        ];
    }

    private function orderDetails()
    {
        return [
            'order_id' => 'required|exists:orders,id',
        ];
    }

    private function search()
    {
        return [
            'status' => 'in:1,2,3,4,5',
            'key' => 'min:1',
        ];
    }


    private function updateStatusValidation()
    {
        return [
            'status' => 'required|between:1,13',
            'id' => 'required|exists:orders,id',
        ];
    }

    private function updatePaymentValidation()
    {
        return [
            'payment_type_id' => 'required|exists:payment_types,id',
            'id' => 'required|exists:orders,id',
        ];
    }

    private function recalculateValidation()
    {
        return [
            'id' => 'required|exists:orders,id',
            'address_id' => 'required|exists:addresses,id',
            'order_status_id' => 'required|exists:order_statuses,id',
            'coupon_id' => 'nullable|exists:coupons,id',
            'payment_type_id' => 'required|exists:payment_types,id',

            'order_items' => 'required|array',
            'order_items.*.variant_id' => 'required|exists:variants,id',
            'order_items.*.quantity' => 'required|numeric|min:1',

        ];
    }


    private function filter()
    {
        return [
            'from' => 'date_format:Y-m-d|date',
            'to' => 'date_format:Y-m-d|date',
            'slot_id' => 'exists:slots,id',
            'status' => 'between:1,13',
            'waiting_orders' => 'boolean',
        ];
    }
}
