<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ComicRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a guest cannot access the comic creation page.
     */
    public function test_guest_cannot_access_create_comic_page(): void
    {
        $response = $this->get('/comics/create');

        $response->assertRedirect('/login');
    }

    /**
     * Test that a regular user gets a 403 forbidden error when trying to access the comic creation page.
     */
    public function test_regular_user_cannot_access_create_comic_page(): void
    {
        // Create a regular user
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get('/comics/create');

        $response->assertStatus(403);
    }

    /**
     * Test that an admin user can access the comic creation page.
     */
    public function test_admin_user_can_access_create_comic_page(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get('/comics/create');

        $response->assertStatus(200);
    }
}
