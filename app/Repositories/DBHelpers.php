<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 10/11/20
 * Time: 01:41 م
 */

namespace App\Repositories;


class DBHelpers
{
    /**
     * @param $model
     * @param null $count
     * @param array $attributes
     */
    public function random_or_create($model, $count = null, $attributes = [])
    {
        $instance = new $model;

        if (! $instance->count()) {
            return $model::factory()->count($count)->create($attributes);
        }

        if (count($attributes)) {
            foreach ($attributes as $key => $value) {
                $instance = $instance->where($key, $value);
            }
        }

        return $instance->get()->random();
    }


}
