<?php

namespace Tests\Feature;

use Tests\TestCase;

class PageControllerTest extends TestCase
{
    public function test_privacy_method_returns_view(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.privacy');
    }

    public function test_terms_method_returns_view(): void
    {
        $response = $this->get(route('page.terms'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.terms');
    }

    public function test_dmca_method_returns_view(): void
    {
        $response = $this->get(route('page.dmca'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.dmca');
    }

    public function test_disclaimer_method_returns_view(): void
    {
        $response = $this->get(route('page.disclaimer'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.disclaimer');
    }

    public function test_contact_method_returns_view(): void
    {
        $response = $this->get(route('page.contact'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.contact');
    }

    public function test_all_page_routes_are_accessible_without_authentication(): void
    {
        $routes = [
            'page.privacy',
            'page.terms',
            'page.dmca',
            'page.disclaimer',
            'page.contact',
        ];

        foreach ($routes as $route) {
            $response = $this->get(route($route));
            $response->assertStatus(200);
        }
    }

    public function test_all_page_routes_are_named_correctly(): void
    {
        $this->assertTrue(route('page.privacy') === url('/privacy'));
        $this->assertTrue(route('page.terms') === url('/terms'));
        $this->assertTrue(route('page.dmca') === url('/dmca'));
        $this->assertTrue(route('page.disclaimer') === url('/disclaimer'));
        $this->assertTrue(route('page.contact') === url('/contact'));
    }
}
