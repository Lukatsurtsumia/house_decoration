<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_renders_every_section(): void
    {
        $response = $this->get('/');

        $response->assertOk();

        foreach (['home', 'services', 'calculator', 'area', 'contact', 'map'] as $id) {
            $response->assertSee('id="'.$id.'"', false);
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
            'სანათის წერტილი', '12 ₾', '/ ცალი',
            'მილი ან ვენტილაცია', '10 ₾', '/ ცალი',
            'დამატებითი კუთხე', '4 ₾', '/ ცალი',
            'ჩრდილოვანი პროფილი', '22 ₾', '/ მ',
            'ფარდის ნიშა', '110 ₾', '/ მ',
        ]);
    }

    public function test_page_does_not_offer_wall_work(): void
    {
        $response = $this->get('/');

        $response->assertDontSee('კედლები');
        $response->assertDontSee('data-calc-wall', false);
    }

    public function test_hero_shows_the_cheapest_finish_price(): void
    {
        $this->get('/')->assertSee('21 ₾-დან');
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
