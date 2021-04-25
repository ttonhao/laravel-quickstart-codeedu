<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Category::class, 1)->create();

        $categories = Category::all();

        $this->assertCount(1, $categories);
    }

    public function testColumns()
    {
        factory(Category::class, 1)->create();

        $categories = Category::all();
        $categoryColumns = [
            'id', 'name', 'description', 'created_at', 'updated_at', 'deleted_at', 'is_active'
        ];
        $categoryKeys = array_keys($categories->first()->getAttributes());

        $this->assertEqualsCanonicalizing($categoryColumns, $categoryKeys);
    }

    public function testCreateOnlyName()
    {
        $categoryName = 'test 1';

        $category = Category::create([
            'name' => $categoryName
        ]);
        $category->refresh();

        $this->assertEquals($categoryName, $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);
    }

    public function testCreateNameNull()
    {
        $categoryName = null;
        $error = false;

        try {
            Category::create([
                'name' => $categoryName
            ]);
        } catch (\Throwable $th) {
            $error = true;
        }

        $this->assertTrue($error);
    }

    public function testCreateSetDescriptionNull()
    {
        $categoryName = 'test 1';

        $category = Category::create([
            'name' => $categoryName,
            'description' => null
        ]);
        $category->refresh();

        $this->assertEquals($categoryName, $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);
    }

    public function testCreateSetDescriptionValue()
    {
        $categoryName = 'test 1';
        $categoryDescription = 'Description Value';
        $category = Category::create([
            'name' => $categoryName,
            'description' => $categoryDescription
        ]);
        $category->refresh();

        $this->assertEquals($categoryName, $category->name);
        $this->assertEquals($categoryDescription, $category->description);
        $this->assertTrue($category->is_active);
    }

    public function testCreateSetIsActiveFalse()
    {
        $categoryName = 'test 1';
        $categoryIsActive = false;
        $category = Category::create([
            'name' => $categoryName,
            'is_active' => $categoryIsActive
        ]);

        $this->assertEquals($categoryName, $category->name);
        $this->assertNull($category->description);
        $this->assertFalse($category->is_active);
    }

    public function testUpdate()
    {
        //** @var Category $category */
        $category = factory(Category::class)->create([
            'description' => 'test_description'
        ]);

        $data = [
            'name' => 'test_name_updated',
            'description' => 'test_description_updated',
            'is_active' => true
        ];
        $category->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }
    }
}
