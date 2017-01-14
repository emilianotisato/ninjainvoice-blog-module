<?php

namespace Modules\Blog\Repositories;

use DB;
use Modules\Blog\Models\Blog;
use App\Ninja\Repositories\BaseRepository;
//use App\Events\BlogWasCreated;
//use App\Events\BlogWasUpdated;

class BlogRepository extends BaseRepository
{
    public function getClassName()
    {
        return 'Modules\Blog\Models\Blog';
    }

    public function all()
    {
        return Blog::scope()
                ->orderBy('created_at', 'desc')
                ->withTrashed();
    }

    public function find($filter = null, $userId = false)
    {
        $query = DB::table('blog')
                    ->where('blog.account_id', '=', \Auth::user()->account_id)
                    ->select(
                        
                        'blog.public_id',
                        'blog.deleted_at',
                        'blog.created_at',
                        'blog.is_deleted',
                        'blog.user_id'
                    );

        $this->applyFilters($query, 'blog');

        if ($userId) {
            $query->where('clients.user_id', '=', $userId);
        }

        /*
        if ($filter) {
            $query->where();
        }
        */

        return $query;
    }

    public function save($data, $blog = null)
    {
        $entity = $blog ?: Blog::createNew();

        $entity->fill($data);
        $entity->save();

        /*
        if (!$publicId || $publicId == '-1') {
            event(new ClientWasCreated($client));
        } else {
            event(new ClientWasUpdated($client));
        }
        */

        return $entity;
    }

}
