<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generează sitemap-ul aplicației și notifică motoarele de căutare';

    protected array $searchEngines = [
        'Google' => 'https://www.google.com/webmasters/tools/ping',
        'Bing' => 'https://www.bing.com/webmaster/ping.aspx'
    ];

    public function handle()
    {
        $this->info('Începe generarea sitemap-ului...');

        $sitemap = Sitemap::create();

        // Adaugă pagina principală
        $sitemap->add(
            Url::create(config('app.url'))
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        // Adaugă pagina principală blog
        $sitemap->add(
            Url::create(route('blog.index'))
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        // Adaugă categoriile blog
        Category::all()->each(function (Category $category) use ($sitemap) {
            $sitemap->add(
                Url::create(route('blog.category', $category->slug))
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate($category->updated_at)
            );
        });

        // Adaugă articolele publicate
        Post::published()->get()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(
                Url::create(route('blog.post', $post->slug))
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setLastModificationDate($post->updated_at)
                    ->addImage($post->featured_image_url, $post->title)
            );
        });

        // Lista de rute publice care trebuie excluse
        $excludedPaths = [
            '/dashboard',
            '/members',
            '/groups',
            '/fee-types',
            '/attendance',
            '/payments',
            '/events',
            '/reports',
            '/admin',
            '/login',
            '/register',
            '/password',
        ];

        // Adaugă celelalte pagini publice
        collect(config('app.public_routes', []))
            ->reject(function ($route) use ($excludedPaths) {
                return collect($excludedPaths)->some(fn($path) => str_contains($route, $path));
            })
            ->each(function ($route) use ($sitemap) {
                $sitemap->add(
                    Url::create($route)
                        ->setPriority(0.5)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                );
            });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap-ul a fost generat cu succes la: ' . public_path('sitemap.xml'));

        // Notifică motoarele de căutare
        $this->pingSearchEngines();
    }

    protected function pingSearchEngines(): void
    {
        $sitemapUrl = url('sitemap.xml');

        foreach ($this->searchEngines as $engine => $pingUrl) {
            try {
                $response = Http::get($pingUrl, [
                    'sitemap' => $sitemapUrl,
                    'url' => config('app.url')
                ]);

                if ($response->successful()) {
                    $this->info("✓ {$engine} a fost notificat cu succes despre noul sitemap.");
                } else {
                    $this->warn("✗ Nu s-a putut notifica {$engine}. Status: " . $response->status());
                }
            } catch (\Exception $e) {
                $this->error("✗ Eroare la notificarea {$engine}: " . $e->getMessage());
            }

            sleep(2); // mărim puțin pauza între ping-uri
        }
    }
}
