<?php

namespace Tests\Feature;

use Tests\TestCase;

class RedirectOldHostsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('app.url', 'https://plafondi.com');
        config()->set('app.redirect_hosts', ['www.plafondi.com', 'plafond.arte-company.com']);
    }

    public function test_an_old_address_sends_visitors_to_the_same_page_on_the_new_one(): void
    {
        $this->get('https://plafond.arte-company.com/?utm_source=card#calculator')
            ->assertStatus(301)
            ->assertRedirect('https://plafondi.com/?utm_source=card');

        $this->get('https://www.plafondi.com/up')
            ->assertStatus(301)
            ->assertRedirect('https://plafondi.com/up');
    }

    public function test_a_form_post_to_an_old_address_stays_a_post(): void
    {
        $this->post('https://plafond.arte-company.com/estimate.pdf')
            ->assertStatus(308)
            ->assertRedirect('https://plafondi.com/estimate.pdf');
    }

    public function test_other_addresses_are_served_normally(): void
    {
        $this->get('https://plafondi.com/')->assertOk();
        $this->get('http://localhost/up')->assertOk();
    }

    public function test_nothing_is_redirected_when_no_old_addresses_are_set(): void
    {
        config()->set('app.redirect_hosts', []);

        $this->get('https://plafond.arte-company.com/')->assertOk();
    }
}
