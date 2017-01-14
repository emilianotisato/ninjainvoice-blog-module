<?php

namespace Modules\Blog\Http\ApiControllers;

use App\Http\Controllers\BaseAPIController;
use Modules\Blog\Repositories\BlogRepository;
use Modules\Blog\Http\Requests\BlogRequest;
use Modules\Blog\Http\Requests\CreateBlogRequest;
use Modules\Blog\Http\Requests\UpdateBlogRequest;

class BlogApiController extends BaseAPIController
{
    protected $BlogRepo;
    protected $entityType = 'blog';

    public function __construct(BlogRepository $blogRepo)
    {
        parent::__construct();

        $this->blogRepo = $blogRepo;
    }

    /**
     * @SWG\Get(
     *   path="/blog",
     *   summary="List of blog",
     *   tags={"blog"},
     *   @SWG\Response(
     *     response=200,
     *     description="A list with blog",
     *      @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/Blog"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function index()
    {
        $data = $this->blogRepo->all();

        return $this->listResponse($data);
    }

    /**
     * @SWG\Get(
     *   path="/blog/{blog_id}",
     *   summary="Individual Blog",
     *   tags={"blog"},
     *   @SWG\Response(
     *     response=200,
     *     description="A single blog",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Blog"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */

    public function show(BlogRequest $request)
    {
        return $this->itemResponse($request->entity());
    }




    /**
     * @SWG\Post(
     *   path="/blog",
     *   tags={"blog"},
     *   summary="Create a blog",
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     @SWG\Schema(ref="#/definitions/Blog")
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="New blog",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Blog"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function store(CreateBlogRequest $request)
    {
        $blog = $this->blogRepo->save($request->input());

        return $this->itemResponse($blog);
    }

    /**
     * @SWG\Put(
     *   path="/blog/{blog_id}",
     *   tags={"blog"},
     *   summary="Update a blog",
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     @SWG\Schema(ref="#/definitions/Blog")
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Update blog",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Blog"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */

    public function update(UpdateBlogRequest $request, $publicId)
    {
        if ($request->action) {
            return $this->handleAction($request);
        }

        $blog = $this->blogRepo->save($request->input(), $request->entity());

        return $this->itemResponse($blog);
    }


    /**
     * @SWG\Delete(
     *   path="/blog/{blog_id}",
     *   tags={"blog"},
     *   summary="Delete a blog",
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     @SWG\Schema(ref="#/definitions/Blog")
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Delete blog",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Blog"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */

    public function destroy(UpdateBlogRequest $request)
    {
        $blog = $request->entity();

        $this->blogRepo->delete($blog);

        return $this->itemResponse($blog);
    }

}
