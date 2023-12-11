<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use App\Models\Journalist;
use Spatie\Permission\Models\Role;

class JournalistWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected $journalistUser;
    protected $journalist;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up roles
        Role::create(['name' => 'jurnalist']);
        Role::create(['name' => 'editor']);

        // Create a user and assign 'jurnalist' role
        $this->journalistUser = User::factory()->create()->assignRole('jurnalist');

        // Create a journalist profile for the user
        $this->journalist = Journalist::factory()->create(['user_id' => $this->journalistUser->id]);

        // Create articles for the journalist
        Article::factory()->count(5)->create(['journalist_id' => $this->journalist->id]);
    }

    public function test_journalist_can_view_their_profile()
    {
        $this->actingAs($this->journalistUser);

        $response = $this->get(route('journalist.profile', $this->journalist->id));

        $response->assertOk();
        $response->assertViewHas('journalist', $this->journalist);
    }

    public function test_journalist_can_update_their_profile()
    {
        $this->actingAs($this->journalistUser);

        $response = $this->patch("/journalist/{$this->journalist->id}/profile", [
            'name' => 'Updated Name',
            'biography' => 'Updated biography.',
            'email' => 'updatedemail@example.com'
        ]);

        $response->assertRedirect("/journalist/{$this->journalist->id}/profile");
        $this->assertDatabaseHas('journalists', [
            'id' => $this->journalist->id,
            'name' => 'Updated Name',
            'biography' => 'Updated biography.'
        ]);
    }

    public function test_journalist_can_view_their_articles()
    {
        $this->actingAs($this->journalistUser);

        $response = $this->get("/journalist/{$this->journalist->id}/articles");

        $response->assertOk();
        $response->assertViewHas('articles', $this->journalist->articles);
    }

    public function test_journalist_can_edit_their_article()
    {
        $this->actingAs($this->journalistUser);

        $article = Article::where('journalist_id', $this->journalist->id)->first();
        $updatedData = [
            'title' => 'Updated Article Title',
            'content' => 'Updated article content.'
        ];

        $response = $this->patch("/articles/{$article->id}", $updatedData);

        $response->assertRedirect("/articles/{$article->id}");
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Updated Article Title'
        ]);
    }
}
