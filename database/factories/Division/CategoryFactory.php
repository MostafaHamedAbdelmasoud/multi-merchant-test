<?php

namespace Database\Factories\Division;

use App\Models\Division\Category;
use App\Models\Store\Store;
use App\Repositories\AppRepository;
use App\Repositories\DBHelpers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $h = new DBHelpers();

        return [
            'name_ar' => $this->faker->name(),
            'name_en' => $this->faker->name(),
            'store_id' => $h->random_or_create(Store::class)->id
        ];
    }
}
