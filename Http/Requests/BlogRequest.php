<?php

namespace Modules\Blog\Http\Requests;

use App\Http\Requests\EntityRequest;

class BlogRequest extends EntityRequest
{
    protected $entityType = 'blog';
}
