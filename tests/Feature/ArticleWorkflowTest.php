<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use App\Models\Journalist;
use Spatie\Permission\Models\Role;

class ArticleWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected $journalist;
    protected $editor;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up roles
        Role::create(['name' => 'jurnalist']);
        Role::create(['name' => 'editor']);

        // Create users with roles
        $this->journalist = User::factory()->create()->assignRole('jurnalist');
        $this->editor = User::factory()->create()->assignRole('editor');

        // Link users to journalist profiles
        Journalist::factory()->create(['user_id' => $this->journalist->id]);
        Journalist::factory()->create(['user_id' => $this->editor->id]);

        // Create articles for the journalist
        Article::factory()->count(5)->create(['journalist_id' => $this->journalist->id]);
    }

    public function test_journalist_can_create_article()
    {
        $this->actingAs($this->journalist);

        $articleData = [
            'title' => 'Test Article',
            'content' => 'This is a test article content.'
        ];

        $response = $this->post('/articles', $articleData);

        // Obține ultimul articol creat pentru a verifica redirecționarea
        $createdArticle = Article::latest('id')->first();

        // Verifică redirecționarea către articolul creat
        $response->assertRedirect(route('articles.show', $createdArticle));

        // Verifică dacă articolul a fost creat în baza de date
        $this->assertDatabaseHas('articles', ['title' => 'Test Article']);
    }

    public function test_journalist_can_edit_their_own_article()
    {
        $this->actingAs($this->journalist);

        $article = Article::factory()->create(['journalist_id' => $this->journalist->id]);
        $updatedData = [
            'title' => 'Updated Title',
            'content' => 'Updated content for the article.' // Adăugăm conținutul actualizat
        ];
        $response = $this->patch("/articles/{$article->id}", $updatedData);
        $response->assertRedirect("/articles/{$article->id}");
        $this->assertDatabaseHas('articles', [
            'title' => 'Updated Title', // Titlul actualizat
            'content' => 'Updated content for the article.', // Conținutul actualizat
            'id' => $article->id // Verificăm folosind ID-ul articolului
        ]);
    }

    public function test_editor_can_edit_any_article()
    {
        $this->actingAs($this->editor);

        $article = Article::factory()->create();
        $updatedData = [
            'title' => 'Editor Updated Title',
            'content' => 'Updated content for the article.'
        ];

        $response = $this->patch("/articles/{$article->id}", $updatedData);

        $response->assertRedirect("/articles/{$article->id}");
        $this->assertDatabaseHas('articles', [
            'title' => 'Editor Updated Title',
            'content' => 'Updated content for the article.',
            'id' => $article->id
        ]);
    }

    public function test_journalist_can_delete_their_own_article()
    {
        $this->actingAs($this->journalist);
        $article = Article::factory()->create(['journalist_id' => $this->journalist->id]);
        $initialCount = Article::count();

        $response = $this->delete("/articles/{$article->id}");

        $response->assertRedirect("/articles");
        $this->assertCount($initialCount - 1, Article::all());
    }

    public function test_editor_can_delete_any_article()
    {
        $this->actingAs($this->editor);
        $article = Article::factory()->create();
        $initialCount = Article::count();

        $response = $this->delete("/articles/{$article->id}");

        $response->assertRedirect("/articles");
        $this->assertCount($initialCount - 1, Article::all());
    }

    public function test_users_can_view_article_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/articles');

        $response->assertOk();
        $response->assertViewHas('articles', Article::all());
    }
}
