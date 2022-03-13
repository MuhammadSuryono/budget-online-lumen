<?php

namespace App\Repositories\Interfaces;

interface BpuInterface
{
    public function list_bpu($itemId): object;

    public function get_total_bpu_item($item);
}
