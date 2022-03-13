<?php

namespace App\Repositories;

use App\Models\SubmissionBudget;
use App\Repositories\Interfaces\BpuInterface;
use Illuminate\Http\Request;

class SubmissionRepository extends Controller implements Interfaces\SubmissionBudgetInterface
{
    /**
     * @var BpuInterface $bpuRepository
     */
    public BpuInterface $bpuRepository;

    /**
     * @param Request $request
     * @param BpuInterface $bpuRepository
     */
    public function __construct(Request $request, BpuInterface $bpuRepository)
    {
        parent::__construct($request);
        $this->bpuRepository = $bpuRepository;
    }

    /**
     * @return object
     */
    public function list_submission_budget(): object
    {
        $submissionBudgets = SubmissionBudget::where("jenis", $this->get_query_url("type"))
            ->where("tahun", $this->get_query_url("year"))
            ->where("status", "!=", NOT_SUBMITTED)->get();
        foreach ($submissionBudgets as $submissionBudget) {
            $this->bpuRepository->get_total_bpu_item($submissionBudget);
        }

        return $this->callback(true, "Success retrieve data", $submissionBudgets);
    }

    /**
     * @param $submissionId
     * @return mixed
     */
    public function read_submission($submissionId)
    {
        $submission = SubmissionBudget::where("noid", $submissionId)->first();
        $this->bpuRepository->get_total_bpu_item($submission);
        return $submission;
    }
}
