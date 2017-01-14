<?php

namespace Modules\Blog\Http\Controllers;

use Auth;
use App\Http\Controllers\BaseController;
use App\Services\DatatableService;
use Modules\Blog\Datatables\BlogDatatable;
use Modules\Blog\Repositories\BlogRepository;
use Modules\Blog\Http\Requests\BlogRequest;
use Modules\Blog\Http\Requests\CreateBlogRequest;
use Modules\Blog\Http\Requests\UpdateBlogRequest;

class BlogController extends BaseController
{
    protected $BlogRepo;
    //protected $entityType = 'blog';

    public function __construct(BlogRepository $blogRepo)
    {
        //parent::__construct();

        $this->blogRepo = $blogRepo;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('list_wrapper', [
            'entityType' => 'blog',
            'datatable' => new BlogDatatable(),
            'title' => mtrans('blog', 'blog_list'),
        ]);
    }

    public function datatable(DatatableService $datatableService)
    {
        $search = request()->input('test');
        $userId = Auth::user()->filterId();

        $datatable = new BlogDatatable();
        $query = $this->blogRepo->find($search, $userId);

        return $datatableService->createDatatable($datatable, $query);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(BlogRequest $request)
    {
        $data = [
            'blog' => null,
            'method' => 'POST',
            'url' => 'blog',
            'title' => mtrans('blog', 'new_blog'),
        ];

        return view('blog::edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(CreateBlogRequest $request)
    {
        $blog = $this->blogRepo->save($request->input());

        return redirect()->to($blog->present()->editUrl)
            ->with('message', mtrans('blog', 'created_blog'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(BlogRequest $request)
    {
        $blog = $request->entity();

        $data = [
            'blog' => $blog,
            'method' => 'PUT',
            'url' => 'blog/' . $blog->public_id,
            'title' => mtrans('blog', 'edit_blog'),
        ];

        return view('blog::edit', $data);
    }

    /**
     * Show the form for editing a resource.
     * @return Response
     */
    public function show(BlogRequest $request)
    {
        return redirect()->to("blog/{$request->blog}/edit");
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateBlogRequest $request)
    {
        $blog = $this->blogRepo->save($request->input(), $request->entity());

        return redirect()->to($blog->present()->editUrl)
            ->with('message', mtrans('blog', 'updated_blog'));
    }

    /**
     * Update multiple resources
     */
    public function bulk()
    {
        $action = request()->input('action');
        $ids = request()->input('public_id') ?: request()->input('ids');
        $count = $this->blogRepo->bulk($ids, $action);

        return redirect()->to('blog')
            ->with('message', mtrans('blog', $action . '_blog_complete'));
    }
}
