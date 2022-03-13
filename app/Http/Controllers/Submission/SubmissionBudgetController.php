<?php

namespace App\Http\Controllers\Submission;

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
     * @var Request $request
     */
    protected Request $request;

    public function __construct(SubmissionBudgetInterface $submissionBudgetRepository, Request $request)
    {
        $this->middleware('auth:api');
        $this->submissionBudgetRepository = $submissionBudgetRepository;
        $this->request = $request;
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

}
