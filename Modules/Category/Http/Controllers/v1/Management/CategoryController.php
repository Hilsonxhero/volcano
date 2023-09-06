<?php

namespace Modules\Category\Http\Controllers\v1\Management;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Category\Enum\CategoryStatus;
use Modules\Common\Services\ApiService;
use Modules\Category\Repository\CategoryRepositoryInterface;
use Modules\Category\Transformers\Management\CategoryResource;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }


    public function index()
    {
        $categories = $this->categoryRepo->all();
        $categories_collection = CategoryResource::collection($categories);
        ApiService::_success(
            array(
                'categories' => $categories_collection,
                'pager' => array(
                    'pages' => $categories_collection->lastPage(),
                    'total' => $categories_collection->total(),
                    'current_page' => $categories_collection->currentPage(),
                    'per_page' => $categories_collection->perPage(),
                )
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */

    public function select(Request $request)
    {
        $categories = $this->categoryRepo->select($request->q);
        ApiService::_success($categories);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        ApiService::Validator($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'link' => ['nullable'],
            'parent' => ['nullable', 'exists:categories,id'],
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'parent_id' => $request->parent,
            'status' => CategoryStatus::ENABLE->value
        ];
        $category = $this->categoryRepo->create($data);

        if ($request->image) {
            $category->addMedia($request->image)->toMediaCollection();
        }

        ApiService::_success($category);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $category = $this->categoryRepo->show($id);
        // ApiService::_success($category);
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        ApiService::Validator($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'link' => ['nullable'],
            'parent' => ['nullable', 'exists:categories,id'],
        ]);
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'parent_id' => $request->parent,
        ];
        $category = $this->categoryRepo->update($id, $data);

        if ($request->image) {
            $category->clearMediaCollectionExcept();
            $category->addMedia($request->image)->toMediaCollection();
        }


        ApiService::_success(trans('response.responses.200'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->categoryRepo->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
