<?php
namespace CodePress\CodePosts\Models;

use CodePress\CodeCategory\Models\Category;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Validator;
use CodePress\CodePosts\Models\Comment;



class Post extends Model implements SluggableInterface
{
    const STATE_PUBLISHED = 1;
    const STATE_DRAFT = 2;
    use SluggableTrait;

    protected $table = "codepress_posts";


    protected $fillable = ['title',
        'content',
        'slug'
    ];


    protected $sluggable = [
        'build_from' => 'title',
        'save_to' => 'slug',
        'unique' => true
    ];

    protected $validator;

    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function isValid()
    {
        $validator = $this->validator;
        $validator->setRules([
            'title' => 'required|max:255',
            'content' =>'required'
        ]);
        $validator->setData($this->getAttributes());
        if($validator->fails()){
            $this->errors = $validator->errors();
            return false;
        }
        return true;
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable', 'codepress_categorizables');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable', 'codepress_taggables');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}