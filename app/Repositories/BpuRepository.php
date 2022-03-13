<?php

namespace App\Repositories;

use App\Models\Bpu;
use App\Models\ItemBudget;
use Illuminate\Support\Facades\DB;

class BpuRepository extends Controller implements Interfaces\BpuInterface
{
    public function get_total_bpu_item($item)
    {
        $totalNominalBpu = Bpu::where("waktu", $item->waktu)->sum("jumlah");
        $totalRtp = Bpu::where("waktu", $item->waktu)
            ->where("persetujuan", APRROVED_DIREKSI)
            ->where("status", NOT_YET_PAID)
            ->sum("jumlah");
        $refund = Bpu::where("waktu", $item->waktu)->sum("uangkembali");

        $item->total_nominal_bpu = (int)$totalNominalBpu;
        $item->total_rtp_bpu = (int)$totalRtp;
        $item->total_uang_kembali = (int)$refund;

        $item->total_biaya_uang_muka = $item->total_nominal_bpu - $item->total_rtp_bpu;
        $item->sisa_budget = (int)$item->totalbudget - $item->total_biaya_uang_muka;
        $item->total_pembayaran = (int)$item->totalbudget - $item->sisa_budget;
        $item->persentase_pembayaran = round(($item->total_pembayaran / $item->totalbudget) * 100);
    }

    public function list_bpu($itemId): object
    {
        $item = ItemBudget::where("id", $itemId)->first();
        $bpus = Bpu::where("waktu", $item->waktu)->where("no", $item->no)->get();

        return $this->callback(true, "Success retrieve data bpu", $bpus);
    }
}
