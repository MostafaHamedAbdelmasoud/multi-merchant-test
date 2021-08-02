<?php

namespace App\Services\Division;

use App\Models\Division\Category;
use App\Repositories\AppRepository;


Class CategoryApiService extends AppRepository
{

    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $this->setColumns(['id', 'name_ar', 'name_en','store_id']);
        $this->setRelations([
            'tags' => function($tag){
                $tag->select('id','category_id','name_ar','name_en');
            },
            'store:id,name_ar,name_en'
        ]);
        if ($request->is_paginate == 1) {
            return $this->paginate();
        }
        return $this->all();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        $this->setRelations([
            'tags' => function ($tag) {
                $tag->select('id', 'name_ar', 'name_en', 'category_id');
            },
        ]);
        return $this->find($request->id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createCategory($request)
    {
        $category = $this->model->create($request->only([
            'name_ar', 'name_en','store_id'
        ]));
        return $category;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editCategory($request)
    {
        $category = $this->find($request->id);
        $result = $category->update($request->only([
            'name_ar', 'name_en','store_id'
        ]));
        return $result;
    }


}
