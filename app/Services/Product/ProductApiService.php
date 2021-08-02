<?php

namespace App\Services\Product;

use App\Models\Division\Tag;
use App\Models\Product\Product;
use App\Repositories\AppRepository;
use App\Traits\HelperFunctions;

class ProductApiService extends AppRepository
{

    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $this->filter($request);

        $this->setColumns([
            'sku',
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'slug',
            'stock',
            'price',
            'tag_id',
        ]);

        $this->setSortOrder('asc');
        $this->setSortBy('sku');
        $this->setRelations([
            'tag:id,name_en,name_ar,category_id',
        ]);

        return $this->paginate();
    }


    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        $this->setRelations([
            'variants' => function ($variant) {
                $variant->with(['color', 'dimension', 'images']);
            },
            'tag',
        ]);
        if ($request->slug) {
            $product = $this->findByColumn('slug', $request->slug);
        } else {
            $product = $this->find($request->id);
        }

        foreach ($product->variants as $variant) {
            if ($variant->dimension) {
                $variant['dimension_value'] = $variant->dimension->dimension;
            }

        }
        return $product;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createProduct($request)
    {
        $request['slug'] = HelperFunctions::makeSlug($request->name_en) . '-' . HelperFunctions::makeSlug($request->sku);
        $product = Product::create($request->only([
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'slug',
            'stock',
            'price',
            'sku',
            'tag_id',
        ]));

        return $product;
    }

    public function priceRange()
    {
        return [
            'min_price' => Product::min('price_after_discount'),
            'max_price' => Product::max('price_after_discount'),
        ];
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateProduct($request)
    {
//        dd($request->all());
        $product = $this->find($request->id);
        $product->update($request->only([
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'slug',
            'stock',
            'price',
            'sku',
            'price_after_discount',
            'collection_id',
            'tag_id',
            'material_id',
            'color_id',
        ]));

        return $product;
    }

    public function updateImagesOfVariants($variant, $variantModel)
    {
        $hasNewFiles = 0;
        if (count($variant['images'])) {
            foreach ($variant['images'] as $img) {
                if (!is_array($img) && is_file($img) && !$hasNewFiles) {
                    $variantModel->images()->delete();
                    $hasNewFiles = 1;
                }
                if (is_array($img)) {
                    continue;
                }
                $variantModel->images()->firstOrcreate([
                    'image' => $img,
                ]);
//                $variantModel->images->delete();
            }
        }
    }

    public function filter($request)
    {
        $conditions = [];
        $orConditions = [];

        if ($request->name) {
            $conditions[] = ['name_ar', 'like', '%' . $request->name . '%'];
            $orConditions[] = ['name_en', 'like', '%' . $request->name . '%'];
        }

        if ($request->id) {
            $conditions[] = ['id', $request->id];
        }

        $this->setConditions($conditions);
        $this->setOrConditions($orConditions);
    }

    public function createDimension($variant, $key = 'dimension')
    {

        $dimension = Dimension::firstOrCreate([
            'dimension' => $variant[$key],
        ]);
        $variant['dimension_id'] = $dimension->id;

        return $variant;
    }

}
