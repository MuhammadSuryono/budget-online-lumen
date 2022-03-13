<?php

namespace App\Repositories\Interfaces;

interface ItemBudgetInterface
{
    public function item_budgets($submissionId): object;

    public function read($itemId): object;
}
