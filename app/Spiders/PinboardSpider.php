<?php

namespace App\Spiders;

use Exception;
use Generator;
use Illuminate\Support\Facades\Http;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use Symfony\Component\DomCrawler\Crawler;

class PinboardSpider extends BasicSpider
{
    /**
     * URL to scrap.
     *
     * @var string[]
     */
    public array $startUrls = [
        'https://pinboard.in/u:alasdairw?per_page=120'
    ];

    /**
     * Parses the response and returns a generator of items.
     */
    public function parse(Response $response): Generator
    {
        // Scrap the page and loop the articles, parsing them into arrays.
        $items = $response
            ->filter('div#main_column div#bookmarks div.bookmark')
            ->each(fn(Crawler $node) => [
                'url' => $node->filter('a.bookmark_title')->link()->getUri(),
                'title' => $node->filter('a.bookmark_title')->text(),
                'description' => $node->filter('div.description')->text(),
                'tags' => $node->filter('a.tag')->each(fn(Crawler $node) => $node->text()),
            ]);

        foreach ($items as $item) {
            // Skip any articles that don't have the required tags.
            if (!array_intersect(config('app.tags'), $item['tags'])) {
                continue;
            }

            // Confirm if the article link is still available.
            try {
                $link = Http::get($item['url']);
                $item['available'] = $link->successful();
            } catch (Exception) {
                $item['available'] = false;
            }
            yield $this->item($item);
        }
    }
}