<?php

namespace App\Console\Commands;

use App\Support\ImageOptimizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateWebpVariants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:generate-webp {directories?* : Public directories to scan} {--overwrite : Rebuild existing WebP files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate WebP variants for JPG and PNG files in the public directory';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $directories = $this->argument('directories');
        $directories = empty($directories) ? ['images', 'uploads'] : $directories;

        $created = 0;
        $skipped = 0;

        foreach ($directories as $directory) {
            $absoluteDirectory = public_path(trim($directory, '/'));

            if (! File::isDirectory($absoluteDirectory)) {
                $this->warn("Directory not found: public/{$directory}");
                continue;
            }

            foreach (File::allFiles($absoluteDirectory) as $file) {
                if (! preg_match('/\.(jpe?g|png)$/i', $file->getFilename())) {
                    continue;
                }

                $result = ImageOptimizer::createWebpVariant($file->getPathname(), (bool) $this->option('overwrite'));

                if ($result) {
                    $created++;
                    continue;
                }

                $skipped++;
            }
        }

        $this->info("WebP generation complete. Created/updated: {$created}, skipped: {$skipped}");

        return self::SUCCESS;
    }
}
