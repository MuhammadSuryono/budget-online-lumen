<?php

namespace App\Http\Controllers\Submission;

use App\Repositories\Interfaces\CategoryFolderInterface;
use App\Repositories\Interfaces\SubmissionBudgetInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubmissionBudgetController extends \App\Http\Controllers\Controller
{
    /**
     * @var SubmissionBudgetInterface $submissionBudgetRepository
     */
    protected SubmissionBudgetInterface $submissionBudgetRepository;

    /**
     * @var CategoryFolderInterface $categoryFolderRepository
     */
    protected CategoryFolderInterface $categoryFolderRepository;

    /**
     * @var Request $request
     */
    protected Request $request;

    public function __construct(SubmissionBudgetInterface $submissionBudgetRepository, Request $request, CategoryFolderInterface $categoryFolderRepository)
    {
        $this->middleware('auth:api');
        $this->submissionBudgetRepository = $submissionBudgetRepository;
        $this->request = $request;
        $this->categoryFolderRepository = $categoryFolderRepository;
    }

    /**
     * @return JsonResponse
     */
    public function list_submission(): JsonResponse
    {
        $submissionBudgets = $this->submissionBudgetRepository->list_submission_budget();
        return $this->BuildResponse(200, $submissionBudgets->message, $submissionBudgets->data);
    }

    /**
     * @param $submissionId
     * @return JsonResponse
     */
    public function read($submissionId): JsonResponse
    {
        $submissionBudget = $this->submissionBudgetRepository->read_submission($submissionId);
        return $this->BuildResponse(200, "Success retrieve data", $submissionBudget);
    }

    /**
     * @return JsonResponse
     */
    public function get_options_folder(): JsonResponse
    {
        $dataOptions = $this->submissionBudgetRepository->get_option_type_submission_folder();
        return $this->BuildResponse(200, $dataOptions->message, $dataOptions->data);
    }

    /**
     * @return JsonResponse
     */
    public function get_category_folder(): JsonResponse
    {
        $dataCategory = $this->categoryFolderRepository->get_all_category_folders();
        return $this->BuildResponse(200, $dataCategory->message, $dataCategory->data);
    }

}
