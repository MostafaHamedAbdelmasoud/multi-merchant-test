<?php

namespace App\Services\Division;

use App\Models\Division\Category;
use App\Models\Division\Tag;
use App\Repositories\AppRepository;

class TagApiService extends AppRepository
{
    private $customTagShippingPriceApiService;

    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $this->filter($request);

        $this->setRelations([
            'category'
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
            'category',
        ]);
        return $this->find($request->id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createTag($request)
    {
        return $this->model->create($request->only([
            'name_ar', 'name_en',
            'category_id'
        ]));
    }


    /**
     * @param $request
     * @return mixed
     */
    public function editTag($request)
    {
        $tag = $this->find($request->id);

        return $tag->update($request->only([
            'name_ar', 'name_en',
            'category_id'
        ]));
    }


    public function filter($request)
    {
        $conditions = [];

        if ($request->category_id) {
            $conditions[] = ['category_id', $request->category_id];
        }

        $this->setConditions($conditions);
    }
}
