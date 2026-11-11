<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_jersey_collection_page_shows_all_eleven_listings(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('2026–27 Jersey Collection')
            ->assertSee('Spain')
            ->assertSee('Croatia')
            ->assertSee('DR Congo')
            ->assertSee('Manchester City')
            ->assertSee('Inter Milan')
            ->assertSee('Juventus')
            ->assertSee('Manchester United')
            ->assertSee('Chelsea')
            ->assertSee('Netherlands')
            ->assertSee('Portugal')
            ->assertSee('Register')
            ->assertSee('Log in');

        $this->assertSame(11, substr_count($response->getContent(), 'data-jersey-card'));
    }

    public function test_jersey_photos_are_available_from_the_public_assets_directory(): void
    {
        foreach ([
            'spain.jpg',
            'croatia.jpg',
            'dr-congo.jpg',
            'manchester-city.jpg',
            'inter-milan.jpg',
            'juventus.jpg',
            'manchester-united.jpg',
            'chelsea.jpg',
            'netherlands.jpg',
            'portugal.jpg',
        ] as $image) {
            $this->assertFileExists(public_path('images/jerseys/' . $image));
        }
    }
}
