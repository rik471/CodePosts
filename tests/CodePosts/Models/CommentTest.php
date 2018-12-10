<?php

namespace  CodePress\CodePosts\Tests\Models;


use CodePress\CodePosts\Models\Post;
use CodePress\CodePosts\Models\Comment;
use CodePress\CodePosts\Tests\AbstractTestCase;
use Illuminate\Validation\Validator;

use Mockery as m;

class CommentTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->migrate();
    }
    public function test_inject_validator_in_post_model()
    {
        $comment =  new Comment();
        $validator = m::mock(Validator::class);
        $comment->setValidator($validator);
        $this->assertEquals($comment->getValidator(), $validator);
    }

    public function test_should_check_if_it_is_valid_when_it_is()
    {
        $comment = new Comment();
        $comment->content = "Conteudo do comentario";
        
        $validator = m::mock(Validator::class);
        $validator->shouldReceive('setRules')->with([
            'content' => 'required'
        ]);
        $validator->shouldReceive('setData')->with([
            'content' => "Conteudo do comentario"
        ]);
        $validator->shouldReceive('fails')->andReturn(false);
        $comment->setValidator($validator);
        $this->assertTrue($comment->isValid());
    }

    public function test_should_check_if_it_is_invalid_when_it_is()
    {
        $comment = new Comment();
        $comment->content = '';

        $messageBag = m::mock('Illuminate\Support\MessageBag');

        $validator = m::mock(Validator::class);
        $validator->shouldReceive('setRules')->with([
            'content' => 'required'
        ]);
        $validator->shouldReceive('setData')->with(['content' => '']);
        $validator->shouldReceive('fails')->andReturn(true);
        $validator->shouldReceive('errors')->andReturn($messageBag);

        $comment->setValidator($validator);
        $this->assertFalse($comment->isValid());
        $this->assertEquals($messageBag, $comment->errors);
    }

    public function test_check_if_a_comment_can_be_persisted()
    {
        $post = Post::create(['title' => 'Titulo do post', 'content' => 'Conteudo do post']);
        $comment = Comment::create(['content' => 'Conteudo do comentario', 'post_id' => $post->id]);
        $this-> assertEquals('Conteudo do comentario', $comment->content);

        $comment = Comment::all()->first();
        $this->assertEquals('Conteudo do comentario', $comment->content);
        $post = Comment::find(1)->post;
        $this->assertEquals('Titulo do post', $post->title);
    }

    public function test_can_validate_comment()
    {
        $comment = new Comment();
        $comment->content = "Conteudo do comentario";

        $factory = $this->app->make('Illuminate\Validation\Factory');
        $validator = $factory->make([], []);

        $comment->setValidator($validator);

        $this->assertTrue($comment->isValid());
        $comment->content = null;
        $this->assertFalse($comment->isValid());
    }


}