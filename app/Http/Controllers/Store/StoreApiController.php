<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Store;


use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreRequest;
use App\Services\Store\StoreApiService;
use Illuminate\Support\Facades\Auth;

class StoreApiController extends Controller
{

    private $brandService;

    public function __construct(StoreApiService $brandService)
    {
        $this->middleware(['auth:api', 'check.role:1,2'])
            ->only(['update', 'create', 'delete']);
        $this->brandService = $brandService;
    }


    public function read(StoreRequest $request)
    {
        $process = $this->brandService->get($request);
        return $this->sendResponse($process);
    }


    public function all(StoreRequest $request)
    {
        $process = $this->brandService->index($request);
        return $this->sendResponse($process);
    }


    public function delete(StoreRequest $request)
    {

        $store = Auth::user()->stores()->where('id',$request->id)->first();


        return $this->sendResponse($store
            ->delete());
    }

    public function create(StoreRequest $request)
    {
        $process = $this->brandService->createStore($request);
        return $this->sendResponse($process);
    }

    public function edit(StoreRequest $request)
    {
        $process = $this->brandService->editStore($request);
        return $this->sendResponse($process);
    }
}
