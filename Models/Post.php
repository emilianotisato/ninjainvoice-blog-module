<?php

namespace Modules\Blog\Models;

use App\Models\EntityModel;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends EntityModel
{
    use PresentableTrait;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $presenter = 'Modules\Post\Presenters\PostPresenter';

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','slug', 'body', 'image', 'active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'posts_tags');
    }

    /**
     * @param Array of tags ids
     * @return array
     * Give this tags to a post
     */
    public function syncTags ($arrayOfTagsIds)
    {
        return $this->tags()->sync($arrayOfTagsIds);
    }

    /**
     * Scopes
     */

    public function scopeActives($query)
    {
        return $query->where('active', 1)->orderBy('created_at', 'desc');
    }

    public function scopeWithTagSlug($query, $tagSlug)
    {
        return $query->whereHas('tags', function($q) use ($tagSlug){
            $q->where('slug', $tagSlug);
        });
    }

    public function getEntityType()
    {
        return 'blog';
    }

}
