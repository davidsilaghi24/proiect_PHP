<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Journalist;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crearea rolurilor necesare pentru test.
        Role::create(['name' => 'jurnalist']);
        // Adaugă aici alte roluri necesare dacă testele o cer.
    }

    public function test_journalist_profile_page_is_displayed(): void
    {
        $user = User::factory()->create()->assignRole('jurnalist');
        $journalist = Journalist::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/profile');

        $response->assertOk();
        $response->assertViewIs('profile.edit');
    }

    public function test_journalist_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create()->assignRole('jurnalist');
        $journalist = Journalist::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->patch('/profile', [
                            'name' => 'Test Journalist',
                            'email' => 'journalist@example.com',
                         ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/profile');

        $user->refresh();
        $this->assertSame('Test Journalist', $user->name);
        $this->assertSame('journalist@example.com', $user->email);
    }

    public function test_journalist_can_delete_their_account(): void
    {
        $user = User::factory()->create()->assignRole('jurnalist');
        $journalist = Journalist::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->delete('/profile', ['password' => 'password']);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull(Journalist::find($journalist->id));
    }

    public function test_correct_password_must_be_provided_to_delete_journalist_account(): void
    {
        $user = User::factory()->create()->assignRole('jurnalist');
        $journalist = Journalist::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->from('/profile')
                         ->delete('/profile', ['password' => 'wrong-password']);

        $response->assertSessionHasErrorsIn('userDeletion', 'password');
        $response->assertRedirect('/profile');

        $this->assertNotNull(Journalist::find($journalist->id));
    }

    public function test_journalist_can_view_their_articles(): void
    {
        $user = User::factory()->create()->assignRole('jurnalist');
        $journalist = Journalist::factory()->create(['user_id' => $user->id]);
        $article = Article::factory()->create(['journalist_id' => $journalist->id]);

        $response = $this->actingAs($user)->get("/journalist/{$journalist->id}/articles");

        $response->assertOk();
        $response->assertSee($article->title);
    }

    public function test_journalist_can_edit_their_article(): void
    {
        $user = User::factory()->create()->assignRole('jurnalist');
        $journalist = Journalist::factory()->create(['user_id' => $user->id]);
        $article = Article::factory()->create(['journalist_id' => $journalist->id]);

        $response = $this->actingAs($user)
                         ->get("/journalist/articles/{$article->id}/edit");

        $response->assertOk();
        $response->assertViewIs('articles.edit');
        $response->assertSee($article->title);
    }
}
