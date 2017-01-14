<?php

namespace Modules\Blog\Transformers;

use Modules\Blog\Models\Blog;
use App\Ninja\Transformers\EntityTransformer;

/**
 * @SWG\Definition(definition="Blog", @SWG\Xml(name="Blog"))
 */

class BlogTransformer extends EntityTransformer
{
    /**
    * @SWG\Property(property="id", type="integer", example=1, readOnly=true)
    * @SWG\Property(property="user_id", type="integer", example=1)
    * @SWG\Property(property="account_key", type="string", example="123456")
    * @SWG\Property(property="updated_at", type="timestamp", example="")
    * @SWG\Property(property="archived_at", type="timestamp", example="1451160233")
    */

    /**
     * @param Blog $blog
     * @return array
     */
    public function transform(Blog $blog)
    {
        return array_merge($this->getDefaults($blog), [
            
            'id' => (int) $blog->public_id,
            'updated_at' => $this->getTimestamp($blog->updated_at),
            'archived_at' => $this->getTimestamp($blog->deleted_at),
        ]);
    }
}
