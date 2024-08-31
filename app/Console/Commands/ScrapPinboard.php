<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Spiders\PinboardSpider;
use Illuminate\Console\Command;
use RoachPHP\Roach;
use RoachPHP\ItemPipeline\ItemInterface;

class ScrapPinboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrap-pinboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap pinboard articles and save them into the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scraping articles');

        /**
         * @var ItemInterface[] Get articles as an array.
         */
        $spiderArticles = Roach::collectSpider(PinboardSpider::class);

        $articlesCreated = 0;
        $articlesSkipped = 0;
        foreach ($spiderArticles as $spiderArticle) {
            // Confirm the article is unique by it's URL.
            $article = Article::where('url', $spiderArticle->get('url'))->count();
            if ($article) {
                $articlesSkipped++;
                continue;
            }

            // New article, create it with it's tags.
            $article = Article::create($spiderArticle->all());
            $article->setTags($spiderArticle->get('tags'));
            $articlesCreated++;
        }
        $this->info("Created {$articlesCreated} articles");
        $this->info("Skipped {$articlesSkipped} articles");
        $this->info('Complete.');
    }
}
