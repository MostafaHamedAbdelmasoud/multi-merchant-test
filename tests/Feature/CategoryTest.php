<?php

namespace Tests\Feature;

use App\Models\Division\Category;
use App\Models\Store\Store;
use App\Models\User\User;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;


class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_categories()
    {
        $this->withoutExceptionHandling();

        $this->actingAsAdmin();

        $merchant = User::factory()->create(['type' => 2]);
        $store = Store::factory()->create(['merchant_id' => $merchant->id]);

        Category::factory()->create([
            'name_ar' => 'CategoryTestName',
            'name_en' => 'CategoryTestName',
            'store_id' => $store->id,
        ]);

//        $response = $this->get(route('category.all'));
        $response = $this->get('api/category/all');

        $response->assertSuccessful();

        $response->assertSee('CategoryTestName');
    }

    /** @test */
    public function it_can_display_category_details()
    {
        $this->withoutExceptionHandling();

        $this->actingAsAdmin();

        $category = Category::factory()->create();

        $response = $this->get('api/category/get?id=' . $category->id);

        $response->assertSuccessful();

        $response->assertSee(e($category->name_en));
    }


    /** @test */
    public function it_can_create_a_new_category()
    {
        $this->withoutExceptionHandling();

        $this->actingAsAdmin();

        $this->assertEquals(0, Category::count());

        $store = Store::factory()->create([
            'name_en' => 'facebook',
        ]);


        $response = $this->post(
            'api/category/create',
            [
                'name_en' => 'categoryName',
                'name_ar' => 'categoryName',
                'store_id' => $store->id,
            ]
        );

        $response->assertStatus(200);

        $this->assertEquals(1, Category::count());
    }

    /** @test */
    public function it_can_display_category_create_form()
    {
        $this->actingAsAdmin();

        $response = $this->get('api/category/all');

        $response->assertSuccessful();

    }


    /** @test */
    public function it_can_display_category_edit_form()
    {
        $this->actingAsAdmin();


        $category = Category::factory()->create([
            'name_en' => 'CategoryTestName',
        ]);

        $response = $this->get('api/category/get?id=' . $category->id);

        $response->assertSuccessful();

    }


    /** @test */
    public function it_can_update_category()
    {
        $this->withoutExceptionHandling();

        $this->actingAsAdmin();

        $this->assertEquals(0, Category::count());

        $category = Category::factory()->create([
            'name_en' => 'CategoryTestName',
        ]);

        $response = $this->post(
            'api/category/edit?id=' . $category->id,
            [
                'name_en' => 'CategoryName2',
            ]
        );

        $category->refresh();

        $response->assertStatus(200);

        $this->assertEquals($category->name_en, 'CategoryName2');
    }
//
    /** @test */
    public function it_can_delete_category()
    {
        $this->withoutExceptionHandling();

        $this->actingAsAdmin();


        $category = Category::factory()->create([
            'name_en' => 'CategoryTestName',
        ]);

        $this->assertEquals(Category::count(), 1);

        $response = $this->delete('api/category/delete?id='. $category->id);

        $response->assertStatus(200);

        $this->assertEquals(Category::count(), 0);
    }
}
