<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_renders_every_section(): void
    {
        $response = $this->get('/');

        $response->assertOk();

        foreach (['home', 'services', 'projects', 'calculator', 'area', 'contact', 'map'] as $id) {
            $response->assertSee('id="'.$id.'"', false);
        }
    }

    public function test_projects_show_their_titles_and_cover_photos(): void
    {
        $response = $this->get('/');

        foreach (config('homepage.projects.items') as $project) {
            $response->assertSee($project['title']);
            $response->assertSee('images/projects/'.$project['photos'][0].'.webp', false);
        }
    }

    public function test_cards_and_projects_only_use_listed_photos(): void
    {
        $photos = config('homepage.photos');

        foreach (config('homepage.projects.items') as $project) {
            foreach ($project['photos'] as $name) {
                $this->assertArrayHasKey($name, $photos);
            }
        }

        foreach (config('homepage.services.items') as $service) {
            $this->assertArrayHasKey($service['photo'], $photos);
        }
    }

    public function test_every_photo_file_exists_at_its_listed_size(): void
    {
        foreach (config('homepage.photos') as $name => $photo) {
            $path = public_path("images/projects/{$name}.webp");

            $this->assertFileExists($path);
            $this->assertSame([$photo['width'], $photo['height']], array_slice(getimagesize($path), 0, 2), $name);

            if ($photo['width'] > 600) {
                $this->assertSame(600, getimagesize(public_path("images/projects/{$name}-sm.webp"))[0], $name);
            }
        }
    }

    public function test_service_cards_list_their_prices_from_config(): void
    {
        $response = $this->get('/');

        $response->assertSeeInOrder([
            'მქრქალი', '21 ₾', '/ მ²',
            'სატინი', '23 ₾', '/ მ²',
            'პრიალა', '25 ₾', '/ მ²',
            'ერთი ჭერის მინიმუმი', '180 ₾',
            'დამაგრება კაფელზე', '+3 ₾', '/ მ',
            'დამაგრება კერამო-გრანიტზე', '+6 ₾', '/ მ',
            'სანათის წერტილი', '12 ₾', '/ ცალი',
            'მილი ან ვენტილაცია', '10 ₾', '/ ცალი',
            'დამატებითი კუთხე', '4 ₾', '/ ცალი',
            'ჩრდილოვანი პროფილი', '22 ₾', '/ მ',
            'ფარდის ნიშა', '110 ₾', '/ მ',
        ]);
    }

    public function test_calculator_offers_the_wall_types(): void
    {
        $response = $this->get('/');

        $response->assertSee('კედლები');
        $response->assertSeeInOrder([
            'value="plaster" data-calc-wall', 'ბათქაში / ბეტონი', 'ფასში შედის',
            'value="tile" data-calc-wall', 'კაფელი', '+3 ₾',
            'value="porcelain" data-calc-wall', 'კერამო-გრანიტი', '+6 ₾',
        ], false);
    }

    public function test_hero_shows_the_cheapest_finish_price(): void
    {
        $this->get('/')->assertSee('21 ₾-დან');
    }

    public function test_page_calls_the_product_gasachimi_cheri(): void
    {
        $response = $this->get('/');

        $response->assertSee('გასაჭიმი ჭერები თბილისში');
        $response->assertDontSee('გაჭიმული');
    }

    public function test_service_cards_carry_calculator_presets(): void
    {
        $response = $this->get('/');

        $response->assertSee('data-calc-preset', false);
        $response->assertSee('data-calculator-config', false);
    }

    public function test_changing_a_price_in_config_updates_the_page(): void
    {
        config()->set('homepage.pricing.finishes.matte.price', 19);

        $response = $this->get('/');

        $response->assertSee('19 ₾-დან');
        $response->assertSeeInOrder(['მქრქალი', '19 ₾', '/ მ²']);
    }
}
