<?php
namespace CodePress\CodePosts\Models;

use CodePress\CodeCategory\Models\Category;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Validator;

class Post extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $table = "codepress_posts";

    protected $fillable = [
        'title',
        'content',
        'slug'
    ];

    protected $sluggable = [
        'build_from' => 'title',
        'save_to' => 'slug',
        'unique' => true
    ];

    protected $validator;

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


    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }


    public function getValidator()
    {
        return $this->validator;
    }


    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable', 'codepress_categorizables');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}