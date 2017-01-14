<?php

namespace Modules\Blog\Datatables;

use Utils;
use URL;
use Auth;
use App\Ninja\Datatables\EntityDatatable;

class BlogDatatable extends EntityDatatable
{
    public $entityType = 'blog';
    public $sortCol = 1;

    public function columns()
    {
        return [
            
            [
                'created_at',
                function ($model) {
                    return Utils::fromSqlDateTime($model->created_at);
                }
            ],
        ];
    }

    public function actions()
    {
        return [
            [
                mtrans('blog', 'edit_blog'),
                function ($model) {
                    return URL::to("blog/{$model->public_id}/edit");
                },
                function ($model) {
                    return Auth::user()->can('editByOwner', ['blog', $model->user_id]);
                }
            ],
        ];
    }

}
