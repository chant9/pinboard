<?php

namespace App\Console\Commands;

use App\Models\Article;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckPinboardUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-pinboard-urls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-check the pinboard articles to confirm if the link is still available.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating articles');

        // Get the 10 least recently updated articles.
        $articles = Article::orderBy('updated_at')->limit(10)->get();

        $articlesUpdated = 0;
        foreach ($articles as $article) {
            $available = $article->available;

            // Confirm if the article link is still available.
            try {
                $link = Http::get($article->url);
                $article->available = $link->successful();
            } catch (Exception) {
                $article->available = false;
            }
            $article->touch();
            $article->save();

            if (!!$available !== $article->available) {
                $articlesUpdated++;
            }
        }
        if (!$articles->count()) {
            $this->info("No articles found to update");
        }
        else {
            $this->info("Updated {$articlesUpdated} of 10 checked articles");
        }

        $this->info('Complete.');
    }
}
