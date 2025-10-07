<?php

namespace Tests\Feature;

use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    public function test_privacy_page_is_accessible(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertStatus(200);
        $response->assertSee('Privacy Policy');
    }

    public function test_privacy_page_contains_expected_sections(): void
    {
        $response = $this->get(route('page.privacy'));

        $response->assertSee('Privacy Policy');
        $response->assertSee('Information We Collect');
        $response->assertSee('How We Use Your Information');
        $response->assertSee('Cookies');
        $response->assertSee('Contact Us');
    }

    public function test_terms_page_is_accessible(): void
    {
        $response = $this->get(route('page.terms'));

        $response->assertStatus(200);
        $response->assertSee('Terms of Service');
    }

    public function test_terms_page_contains_expected_sections(): void
    {
        $response = $this->get(route('page.terms'));

        $response->assertSee('Terms of Service');
        $response->assertSee('Agreement to Terms');
        $response->assertSee('Use License');
        $response->assertSee('Disclaimer');
        $response->assertSee('Limitations');
    }

    public function test_dmca_page_is_accessible(): void
    {
        $response = $this->get(route('page.dmca'));

        $response->assertStatus(200);
        $response->assertSee('DMCA');
    }

    public function test_dmca_page_contains_required_information(): void
    {
        $response = $this->get(route('page.dmca'));

        $response->assertSee('DMCA Takedown Policy');
        $response->assertSee('Filing a DMCA Takedown Notice');
        $response->assertSee('How to Submit a Notice');
        $response->assertSee('Counter-Notification');
        $response->assertSee('Repeat Infringers');
    }

    public function test_disclaimer_page_is_accessible(): void
    {
        $response = $this->get(route('page.disclaimer'));

        $response->assertStatus(200);
        $response->assertSee('Affiliate Disclaimer');
    }

    public function test_disclaimer_page_contains_affiliate_information(): void
    {
        $response = $this->get(route('page.disclaimer'));

        $response->assertSee('Affiliate Disclaimer');
        $response->assertSee('affiliate marketing');
        $response->assertSee('commission');
        $response->assertSee('No Additional Cost');
    }

    public function test_contact_page_is_accessible(): void
    {
        $response = $this->get(route('page.contact'));

        $response->assertStatus(200);
        $response->assertSee('Contact Us');
    }

    public function test_contact_page_contains_form_fields(): void
    {
        $response = $this->get(route('page.contact'));

        $response->assertSee('Your Name');
        $response->assertSee('Email Address');
        $response->assertSee('Subject');
        $response->assertSee('Message');
    }

    public function test_all_legal_pages_use_public_layout(): void
    {
        $pages = [
            'page.privacy',
            'page.terms',
            'page.dmca',
            'page.disclaimer',
            'page.contact',
        ];

        foreach ($pages as $pageName) {
            $response = $this->get(route($pageName));

            // Check for theme elements that should be in public layout
            $response->assertSee('x-theme-styles', false);
            $response->assertSee('x-public-footer', false);
        }
    }

    public function test_legal_pages_contain_theme_name(): void
    {
        config(['theme.current' => 'default']);
        config(['theme.themes.default.name' => 'Test Site Name']);

        $pages = [
            'page.privacy',
            'page.terms',
            'page.dmca',
            'page.disclaimer',
            'page.contact',
        ];

        foreach ($pages as $pageName) {
            $response = $this->get(route($pageName));
            $response->assertSee('Test Site Name');
        }
    }

    public function test_legal_pages_have_correct_page_titles(): void
    {
        $pageTitles = [
            'page.privacy' => 'Privacy Policy',
            'page.terms' => 'Terms of Service',
            'page.dmca' => 'DMCA Takedown',
            'page.disclaimer' => 'Affiliate Disclaimer',
            'page.contact' => 'Contact Us',
        ];

        foreach ($pageTitles as $route => $title) {
            $response = $this->get(route($route));
            $response->assertSeeInOrder(['<title>', $title], false);
        }
    }

    public function test_legal_pages_contain_links_to_each_other(): void
    {
        $response = $this->get(route('page.privacy'));

        // Privacy page should link to contact
        $response->assertSee(route('page.contact'), false);
    }

    public function test_footer_appears_on_legal_pages(): void
    {
        $response = $this->get(route('page.privacy'));

        // Check for footer content
        $response->assertSee('Legal', false);
        $response->assertSee('Connect', false);
    }
}
