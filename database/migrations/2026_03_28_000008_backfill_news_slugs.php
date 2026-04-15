<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $newsItems = DB::table('news')->get(['id', 'title', 'slug']);

        foreach ($newsItems as $item) {
            if (!empty($item->slug)) {
                continue;
            }

            $base = Str::slug($item->title ?: 'news');
            $slug = $base ?: 'news';
            $counter = 1;

            while (DB::table('news')->where('slug', $slug)->exists()) {
                $slug = $base . '-' . $counter;
                $counter++;
            }

            DB::table('news')->where('id', $item->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        // No rollback for generated slugs
    }
};
