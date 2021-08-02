<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Division;


use App\Http\Controllers\Controller;
use App\Http\Requests\Division\CategoryRequest;
use App\Services\Division\CategoryApiService;

class CategoryApiController extends Controller
{

    private $categoryService;

    public function __construct(CategoryApiService $categoryService)
    {
        $this->middleware(['auth:api','check.role:1,2'])
            ->only(['delete','create','edit']);
        $this->categoryService = $categoryService;
    }


    public function read(CategoryRequest $request)
    {
        $process = $this->categoryService->get($request);
        return $this->sendResponse($process);
    }


    public function all(CategoryRequest $request)
    {
        $process = $this->categoryService->index($request);
        return $this->sendResponse($process);
    }

    public function delete(CategoryRequest $request)
    {
        $process = $this->categoryService->delete($request->id);
        return $this->sendResponse($process);
    }
    public function create(CategoryRequest $request)
    {
        $process = $this->categoryService->createCategory($request);
        return $this->sendResponse($process);
    }
    public function edit(CategoryRequest $request)
    {
        $process = $this->categoryService->editCategory($request);
        return $this->sendResponse($process);
    }
}
