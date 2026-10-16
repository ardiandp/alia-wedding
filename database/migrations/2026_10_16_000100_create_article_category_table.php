<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->unique(['article_id', 'category_id']);
        });

        $this->migrateExistingCategories();

        if (Schema::hasColumn('articles', 'category')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('articles', 'category')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->string('category')->nullable()->after('slug');
            });
        }

        Schema::dropIfExists('article_category');
    }

    /**
     * Copy the legacy single-string category into rows + pivot links.
     */
    private function migrateExistingCategories(): void
    {
        if (! Schema::hasColumn('articles', 'category')) {
            return;
        }

        $names = DB::table('articles')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        $map = [];
        $order = 0;

        foreach ($names as $name) {
            $slug = Str::slug($name) ?: 'kategori';
            $candidate = $slug;
            $suffix = 2;

            while (DB::table('categories')->where('slug', $candidate)->exists()) {
                $candidate = $slug.'-'.$suffix;
                $suffix++;
            }

            $map[$name] = DB::table('categories')->insertGetId([
                'name' => $name,
                'slug' => $candidate,
                'sort_order' => $order++,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if ($map === []) {
            return;
        }

        DB::table('articles')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('id', 'category')
            ->orderBy('id')
            ->chunk(200, function ($articles) use ($map) {
                $rows = [];

                foreach ($articles as $article) {
                    if (! isset($map[$article->category])) {
                        continue;
                    }

                    $rows[] = [
                        'article_id' => $article->id,
                        'category_id' => $map[$article->category],
                    ];
                }

                if ($rows !== []) {
                    DB::table('article_category')->insert($rows);
                }
            });
    }
};
