<?php

namespace Tests\Unit;

use App\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @test
     */
    public function create_success()
    {
        Category::create([
            'name' => 'Hight Tech',
            'slug' => 'hight-tech',
        ]);

        $this->assertCount(1, Category::all());
    }
    /**
     *
     * @test
     */
    public function updated_success()
    {
        $category = Category::create([
            'name' => 'Hight Tech',
            'slug' => 'hight-tech',
        ]);
        $this->assertCount(1, Category::all());

        $newTile = 'livre';

        $category->update([
            'name' => $newTile
        ]);
        $this->assertEquals($newTile, $category->name);
        $this->assertCount(1, Category::all());

    }

    /**
     * @test
     */
    public function deleted_success()
    {
        $category = Category::create([
            'name' => 'Hight Tech',
            'slug' => 'hight-tech',
        ]);
        $this->assertCount(1, Category::all());

        $category->delete();
        $this->assertCount(0, Category::all());
    }
}
