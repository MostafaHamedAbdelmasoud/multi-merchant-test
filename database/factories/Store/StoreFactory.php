<?php

namespace Database\Factories\Store;

use App\Models\Store\Store;
use App\Models\User\User;
use App\Repositories\DBHelpers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

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
            'merchant_id' => $h->random_or_create(User::class,['type'=>3])->id,
            'rate' => $this->faker->randomFloat(2,0,5),
            'description_en' => $this->faker->text(200),
            'description_ar' => $this->faker->text(200),
            'meta_description_en' => $this->faker->text(200),
            'meta_description_ar' => $this->faker->text(200),
            'keywords' => $this->faker->paragraph(2),
        ];
    }
}
