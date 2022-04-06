<?php

namespace App\Repositories\Interfaces;

interface SubmissionBudgetInterface
{
    /**
     * @return object
     */
    public function list_submission_budget(): object;

    /**
     * @param $submissionId
     * @return mixed
     */
    public function read_submission($submissionId);

    /**
     * @return object
     */
    public function get_option_type_submission_folder(): object;

}
