<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generează sitemap-ul aplicației';

    public function handle()
    {
        $this->info('Începe generarea sitemap-ului...');

        SitemapGenerator::create(config('app.url'))
            ->hasCrawled(function (Url $url) {
                // Exclude rutele care necesită autentificare
                if (str_contains($url->url, '/dashboard') ||
                    str_contains($url->url, '/members') ||
                    str_contains($url->url, '/groups') ||
                    str_contains($url->url, '/fee-types') ||
                    str_contains($url->url, '/attendance') ||
                    str_contains($url->url, '/payments') ||
                    str_contains($url->url, '/events') ||
                    str_contains($url->url, '/reports')) {
                    return;
                }

                // Personalizează prioritatea și frecvența pentru pagina principală
                if ($url->url === config('app.url')) {
                    $url->setPriority(1.0)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY);
                }

                // Setări implicite pentru celelalte pagini
                return $url->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY);
            })
            ->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap-ul a fost generat cu succes la: ' . public_path('sitemap.xml'));
    }
}