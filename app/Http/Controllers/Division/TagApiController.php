<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Division;


use App\Http\Controllers\Controller;
use App\Http\Requests\Division\TagRequest;
use App\Services\Division\TagApiService;

class TagApiController extends Controller
{

    private $tagService;

    public function __construct(TagApiService $tagService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->tagService = $tagService;
    }


    public function read(TagRequest $request)
    {
        $process = $this->tagService->get($request);
        return $this->sendResponse($process);
    }


    public function all(TagRequest $request)
    {
        $process = $this->tagService->index($request);
        return $this->sendResponse($process);
    }

    public function delete(TagRequest $request)
    {
        $process = $this->tagService->delete($request->id);
        return $this->sendResponse($process);
    }

    public function create(TagRequest $request)
    {
        $process = $this->tagService->createTag($request);
        return $this->sendResponse($process);
    }
    public function edit(TagRequest $request)
    {
        $process = $this->tagService->editTag($request);
        return $this->sendResponse($process);
    }
}
