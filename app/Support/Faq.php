<?php

namespace App\Support;

/**
 * The FAQ from config('homepage.faq') with every {path} in an answer replaced by that price
 * from config('homepage.pricing'), so the page, Google's data and llms.txt quote current prices.
 */
class Faq
{
    /**
     * @param  array<string, mixed>  $content  config('homepage')
     * @return array<int, array{question: string, answer: string}>
     */
    public static function items(array $content): array
    {
        return array_map(fn (array $item) => [
            'question' => $item['question'],
            'answer' => preg_replace_callback(
                '/\{([a-z_.]+)\}/',
                fn (array $match) => (string) data_get($content['pricing'], $match[1].'.price', $match[0]),
                $item['answer'],
            ),
        ], $content['faq']['items']);
    }
}
