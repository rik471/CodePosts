<?php
namespace  CodePress\CodePosts\Tests\Models;

use CodePress\CodePosts\Models\Post;
use CodePress\CodePosts\Tests\AbstractTestCase;
use Illuminate\Validation\Validator;

use Mockery as m;

class PostTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->migrate();
    }
    public function test_inject_validator_in_post_model()
    {
        $post = new Post();
        $validator = m::mock(Validator::class);
        $post->setValidator($validator);
        $this->assertEquals($post->getValidator(), $validator);
    }
    public function test_should_check_if_it_is_valid_when_it_is()
    {
        $post = new Post();
        $post->title = 'Post Test';
        $post->content = 'Content Test';
        $validator = m::mock(Validator::class);
        $validator->shouldReceive('setRules')->with([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);
        $validator->shouldReceive('setData')->with([
            'title' => 'Post Test',
            'content' => 'Content Test',
        ]);
        $validator->shouldReceive('fails')->andReturn(false);
        $post->setValidator($validator);
        $this->assertTrue($post->isValid());
    }
    public function test_should_check_if_it_is_invalid_when_it_is()
    {
        $post = new Post();
        $post->title = 'Post Test';
        $post->content = 'Content Test';
        $validator = m::mock(Validator::class);
        $messageBag = m::mock('Illuminate\Support\MessageBag');
        $validator->shouldReceive('setRules')->with([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);
        $validator->shouldReceive('setData')->with([
            'title' => 'Post Test',
            'content' => 'Content Test',
        ]);
        $validator->shouldReceive('fails')->andReturn(true);
        $validator->shouldReceive('errors')->andReturn($messageBag);
        $post->setValidator($validator);
        $this->assertFalse($post->isValid());
        $this->assertEquals($messageBag, $post->errors);
    }
    public function test_check_if_a_post_can_be_persisted()
    {
        $post = Post::create(['title' => 'Post Test', "content" => "Content Test"]);
        $this-> assertEquals('Post Test', $post->title);
        $this->assertEquals('Content Test', $post->content);

        $post = Post::all()->first();
        $this->assertEquals('Post Test', $post->title);
    }

    public function test_can_validate_post()
    {
        $post = new Post();
        $post->title = 'Post Test';
        $post->content = 'Content Test';

        $factory = $this->app->make('Illuminate\Validation\Factory');
        $validator = $factory->make([], []);


        $post->setValidator($validator);
        $this->assertTrue($post->isValid());
        $post->title = null;
        $this->assertFalse($post->isValid());
    }

    public function test_can_sluggable()
    {
        $post = Post::create(['title' => 'Post Test', 'content' => 'Content Test']);
        $this->assertEquals($post->slug, "post-test");
        $post = Post::create(['title' => 'Post Test', 'content' => 'Content Test']);
        $this->assertEquals($post->slug, "post-test-1");

        $post = Post::findBySlug("post-test-1");
        $this->assertInstanceOf(Post::class, $post);
    }

    public function test_can_add_comment()
    {
        $post = Post::create(['title' => 'Post Test', 'content' => 'Content Test']);
        $post->comments()->create(['content' => 'Comentario 1 do meu post']);
        $post->comments()->create(['content' => 'Comentario 2 do meu post']);

        $comments = Post::find(1)->comments;

        $this->assertCount(2, $comments);
        $this->assertEquals('Comentario 1 do meu post', $comments[0]->content);
        $this->assertEquals('Comentario 2 do meu post', $comments[1]->content);
    }

}