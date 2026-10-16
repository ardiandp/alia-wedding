<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = User::factory()->superAdmin()->create();
    }

    public function test_demo_seeder_creates_categories_with_articles(): void
    {
        $this->assertGreaterThan(0, Category::count());

        $category = Category::where('slug', 'dekorasi')->first();
        $this->assertNotNull($category);
        $this->assertGreaterThan(0, $category->articles()->count());
    }

    public function test_admin_category_pages_render(): void
    {
        $this->actingAs($this->admin);

        $this->get(route('admin.categories.index'))->assertOk();
        $this->get(route('admin.categories.create'))->assertOk();

        $category = Category::first();
        $this->get(route('admin.categories.edit', $category))->assertOk();
    }

    public function test_admin_can_create_a_category(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Dekorasi Baru',
            'description' => 'Kategori baru untuk dekorasi.',
            'sort_order' => 5,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Dekorasi Baru',
            'slug' => 'dekorasi-baru',
            'sort_order' => 5,
        ]);
    }

    public function test_slug_is_unique_on_collision(): void
    {
        $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Dekorasi',
        ]);

        $this->assertDatabaseHas('categories', ['slug' => 'dekorasi-2']);
    }

    public function test_admin_can_update_a_category(): void
    {
        $category = Category::first();

        $this->actingAs($this->admin)
            ->put(route('admin.categories.update', $category), [
                'name' => 'Dekorasi Baru Diperbarui',
                'description' => 'Deskripsi baru.',
                'sort_order' => 9,
            ])
            ->assertRedirect();

        $category->refresh();
        $this->assertSame('Dekorasi Baru Diperbarui', $category->name);
        $this->assertSame('dekorasi-baru-diperbarui', $category->slug);
        $this->assertSame(9, $category->sort_order);
    }

    public function test_deleting_category_detaches_articles_without_deleting_them(): void
    {
        $category = Category::whereHas('articles')->first();
        $articleId = $category->articles()->first()->id;

        $this->actingAs($this->admin)
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $this->assertDatabaseMissing('article_category', ['category_id' => $category->id]);
        $this->assertDatabaseHas('articles', ['id' => $articleId]);
    }

    public function test_staff_cannot_manage_categories(): void
    {
        $staff = User::factory()->staff()->create();
        $category = Category::first();

        $this->actingAs($staff)->get(route('admin.categories.index'))->assertForbidden();
        $this->actingAs($staff)->post(route('admin.categories.store'), ['name' => 'X'])->assertForbidden();
        $this->actingAs($staff)->delete(route('admin.categories.destroy', $category))->assertForbidden();
    }

    public function test_article_can_be_saved_with_multiple_categories(): void
    {
        $cats = Category::take(2)->pluck('id')->all();

        $this->actingAs($this->admin)
            ->post(route('admin.articles.store'), [
                'title' => 'Artikel Multi Kategori',
                'body' => 'Isi artikel.',
                'status' => 'published',
                'categories' => $cats,
            ])
            ->assertRedirect(route('admin.articles.index'));

        $article = Article::where('slug', 'artikel-multi-kategori')->first();
        $this->assertNotNull($article);
        $this->assertEqualsCanonicalizing($cats, $article->categories->pluck('id')->all());
    }

    public function test_updating_article_replaces_categories(): void
    {
        $article = Article::whereHas('categories')->first();
        $currentIds = Category::take(2)->pluck('id')->all();
        $article->categories()->sync($currentIds);

        $newCategory = Category::whereNotIn('id', $currentIds)->first();
        $this->assertNotNull($newCategory);

        $this->actingAs($this->admin)
            ->put(route('admin.articles.update', $article), [
                'title' => $article->title,
                'body' => 'Isi diperbarui.',
                'status' => 'published',
                'categories' => [$newCategory->id],
            ])
            ->assertRedirect();

        $this->assertEquals([$newCategory->id], $article->fresh()->categories->pluck('id')->all());
    }

    public function test_article_rejects_unknown_category(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.articles.store'), [
                'title' => 'Artikel Invalid',
                'body' => 'Isi.',
                'status' => 'published',
                'categories' => [999999],
            ])
            ->assertSessionHasErrors('categories.0');

        $this->assertDatabaseMissing('articles', ['slug' => 'artikel-invalid']);
    }

    public function test_public_category_archive_lists_matching_articles(): void
    {
        $category = Category::whereHas('articles')->first();
        $article = $category->articles()->first();

        $this->get(route('articles.category', $category))
            ->assertOk()
            ->assertSee($category->name)
            ->assertSee($article->title);
    }

    public function test_public_article_index_filters_by_category_query(): void
    {
        $category = Category::whereHas('articles')->first();

        $this->get(route('articles.index', ['category' => $category->slug]))
            ->assertOk()
            ->assertSee($category->name);
    }

    public function test_article_show_displays_linked_categories(): void
    {
        $article = Article::where('status', 'published')->whereHas('categories')->first();
        $category = $article->categories->first();

        $this->get(route('articles.show', $article))
            ->assertOk()
            ->assertSee($category->name)
            ->assertSee(route('articles.category', $category));
    }

    public function test_sitemap_includes_category_archives(): void
    {
        $category = Category::whereHas('articles')->first();

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee(route('articles.category', $category));
    }
}
