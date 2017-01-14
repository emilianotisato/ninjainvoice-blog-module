<?php

namespace Modules\Blog\;

use App\Providers\AuthServiceProvider;

class BlogAuthProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \Modules\Blog\Models\Blog::class => \Modules\Blog\Policies\BlogPolicy::class,
    ];
}
