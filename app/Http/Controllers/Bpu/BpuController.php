<?php

namespace App\Http\Controllers\Bpu;

use App\Repositories\Interfaces\BpuInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BpuController extends \App\Http\Controllers\Controller
{
    protected BpuInterface $bpu;

    protected Request $request;

    public function __construct(BpuInterface $bpu, Request $request)
    {
        $this->bpu = $bpu;
        $this->request = $request;
    }

    public function list_bpu($itemId): JsonResponse
    {
        $callbackList = $this->bpu->list_bpu($itemId);
        return $this->BuildResponse(200, $callbackList->message, $callbackList->data);
    }
}
