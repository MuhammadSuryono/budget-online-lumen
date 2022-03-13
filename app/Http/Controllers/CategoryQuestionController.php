<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryQuestionRepository;
use App\Repositories\Interfaces\CategoryQuestionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryQuestionController extends Controller
{
    /**
     * @var CategoryQuestionInterface
     */
    private CategoryQuestionInterface $categoryQuestion;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @param CategoryQuestionInterface $categoryQuestion
     * @param Request $request
     */
    public function __construct(CategoryQuestionInterface $categoryQuestion, Request $request)
    {
        $this->middleware('auth:api');
        $this->categoryQuestion = $categoryQuestion;
        $this->request = $request;
    }

    /***
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        $this->validate_request($this->request, [
            'name' => 'required'
        ]);
        $callbackCreate = $this->categoryQuestion->create_category($this->request->input('name'));
        return $this->BuildResponse($callbackCreate->is_success ? 200 : 400, $callbackCreate->message);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function update($id): JsonResponse
    {
        $this->validate_request($this->request, [
            'name' => 'required'
        ]);
        $callbackUpdate = $this->categoryQuestion->update_category($id,$this->request->input('name'));
        return $this->BuildResponse($callbackUpdate->is_success ? 200 : 400, $callbackUpdate->message);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $callbackDelete = $this->categoryQuestion->delete_category($id);
        return $this->BuildResponse($callbackDelete->is_success ? 200 : 400, $callbackDelete->message);
    }

    /***
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $page = $this->request->input('page');
        $callbackList = $this->categoryQuestion->list_category(is_null($page) ? 1 : $page);
        return $this->BuildResponse(200, "Success retrieve data", $callbackList);
    }
}
