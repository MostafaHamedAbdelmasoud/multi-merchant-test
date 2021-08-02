<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\FavouriteRequest;
use App\Services\Auth\FavouriteApiService;

class FavouriteApiController extends Controller
{
    private $favouriteApiService;

    public function __construct(FavouriteApiService $favouriteApiService)
    {
        $this->middleware('auth:api');
        $this->middleware('check.role:1,2')
            ->only(['delete', 'read' ,'all' , 'delete']);
//        $this->middleware('check.role:1')
//            ->only('delete');
        $this->favouriteApiService = $favouriteApiService;
    }

    public function create(FavouriteRequest $request)
    {
        $process = $this->favouriteApiService->createFavourite($request);
        return $this->sendResponse($process);
    }



    public function read(FavouriteRequest $request)
    {
        $process = $this->favouriteApiService->get($request);
        return $this->sendResponse($process);
    }

    public function all(FavouriteRequest $request)
    {
        $process = $this->favouriteApiService->index($request);
        return $this->sendResponse($process);
    }

    public function delete(FavouriteRequest $request)
    {
        $process = $this->favouriteApiService->delete($request->id);
        if (!$process) {
            return $this->sendError('sorry, something wrong');
        }
        return $this->sendResponse($process);
    }
}
