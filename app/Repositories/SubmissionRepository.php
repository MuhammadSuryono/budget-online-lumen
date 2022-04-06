<?php

namespace App\Repositories;

use App\Models\Budget\SubmissionBudget;
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

    /**
     * @inheritDoc
     */
    public function get_option_type_submission_folder(): object
    {
        $dataOptions = $this->option_types()[strtolower($this->user_division())];
        return $this->callback(true, "Success retrieve data", $dataOptions);
    }

    /**
     * @return \string[][][]
     */
    protected function option_types(): array
    {
        return [
            "direksi" => [
                [
                    "label" => "B1",
                    "value" => "B1"
                ],
                [
                    "label" => "B2",
                    "value" => "B2"
                ],
                [
                    "label" => "Rutin",
                    "value" => "Rutin"
                ],
                [
                    "label" => "Non Rutin",
                    "value" => "Non Rutin"
                ],
                [
                    "label" => "Lainnya",
                    "value" => "Lainnya"
                ]
            ],
            "finance" => [
                [
                    "label" => "Rutin",
                    "value" => "Rutin"
                ],
                [
                    "label" => "Non Rutin",
                    "value" => "Non Rutin"
                ],
                [
                    "label" => "Lainnya",
                    "value" => "Lainnya"
                ]
            ],
            "b1" => [
                [
                    "label" => "B1",
                    "value" => "B1"
                ],
            ],
            "b2" => [
                [
                    "label" => "B2",
                    "value" => "B2"
                ],
            ]
        ];
    }
}
