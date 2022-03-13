<?php

namespace App\Http\Controllers\Submission\Item;

use App\Repositories\Interfaces\ItemBudgetInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemBudgetController extends \App\Http\Controllers\Controller
{
    protected ItemBudgetInterface $itemBudgetRepo;

    protected Request $request;

    public function __construct(ItemBudgetInterface $itemBudgetRepo, Request $request)
    {
        $this->itemBudgetRepo = $itemBudgetRepo;
        $this->request = $request;
    }

    public function list_items($submissionId): JsonResponse
    {
        $itemBudgets = $this->itemBudgetRepo->item_budgets($submissionId);
        return $this->BuildResponse(200, $itemBudgets->message, $itemBudgets->data);
    }

    public function read($itemId): JsonResponse
    {
        $itemBudget = $this->itemBudgetRepo->read($itemId);
        return $this->BuildResponse(200, $itemBudget->message, $itemBudget->data);
    }

}
