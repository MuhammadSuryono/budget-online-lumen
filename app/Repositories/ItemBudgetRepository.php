<?php

namespace App\Repositories;

use App\Models\Budget\Bpu;
use App\Models\Budget\ItemBudget;
use App\Repositories\Interfaces\ItemBudgetInterface;
use App\Repositories\Interfaces\SubmissionBudgetInterface;
use Illuminate\Http\Request;

class ItemBudgetRepository extends Controller implements ItemBudgetInterface
{
    /**
     * @var SubmissionBudgetInterface $submissionBudgetRepository
     */
    protected SubmissionBudgetInterface $submissionRepository;

    /**
     * @param Request $request
     * @param SubmissionBudgetInterface $submissionRepository
     */
    public function __construct(Request $request, SubmissionBudgetInterface $submissionRepository)
    {
        parent::__construct($request);
        $this->submissionRepository = $submissionRepository;
    }

    /**
     * @param $submissionId
     * @return object
     */
    public function item_budgets($submissionId): object
    {
        $submission = $this->submissionRepository->read_submission($submissionId);
        foreach ($submission->itemBudgets as $itemBudget) {
            $totalPayment =Bpu::where("waktu", $itemBudget->waktu)
                ->where("no", $itemBudget->no)
                ->where("status", PAID)
                ->sum("jumlah");
            $totalBpu = Bpu::where("waktu", $itemBudget->waktu)
                ->where("no", $itemBudget->no)
                ->count();

            $itemBudget->total_pembayaran = $totalPayment;
            $itemBudget->total_bpu = $totalBpu;
        }
        return $this->callback(true, "Success retrieve data", $submission->itemBudgets);
    }

    /**
     * @param $itemId
     * @return object
     */
    public function read($itemId): object
    {
        $item = ItemBudget::find($itemId);
        $totalPayment = Bpu::where("waktu", $item->waktu)
            ->where("no", $item->no)
            ->where("status", PAID)
            ->sum("jumlah");

        $item->total_pembayaran = $totalPayment;
        $item->sisa_pembayaran = (int)$item->total - $totalPayment;
        $item->persentase_pembayaran = $item->total == 0 ? 0 : round($totalPayment / $item->total * 100);
        return $this->callback(true, "Success retrieve data", $item);
    }
}
