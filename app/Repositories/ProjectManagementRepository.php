<?php

namespace App\Repositories;

use App\Models\DigitalMarket\CommVoucher;
use App\Models\DigitalMarket\DataSindikasi;

class ProjectManagementRepository extends Controller implements Interfaces\ProjectManagementInterface
{

    public function get_list_project($typeProject): object
    {
        $data = [];
        $projectCommVoucher = $this->project_comm_voucher($typeProject);
        $data = array_merge($data, $projectCommVoucher);
        return $this->callback(count($data) > 0, count($data) > 0 ? "Success retrieve data":"Data not found", $data);
    }

    protected function project_comm_voucher($typeProject): array
    {
        $defaultData = [];
        $projects = CommVoucher::select("data_rfq.tgl_masuk", "comm_voucher.*", "data_user.dept")
            ->leftJoin("data_user", "comm_voucher.research_executive", "=", "data_user.id_user")
            ->leftJoin("data_rfq", "comm_voucher.nomor_project", "=", "data_rfq.nomor_rfq")
            ->where("comm_voucher.on_budget", "!=", 1);
        if (strtolower($typeProject) == "b1") {
            $projects = $projects->where("data_user.dept", "=", 76);
        } else {
            $projects = $projects->where("data_user.dept", "!=", 76);
        }
        $projects = $projects->get();
        foreach ($projects as $project) {
            $yearProject = date('Y', strtotime($project->tgl_masuk));
            $defaultData[] = [
                "id" => $project->id_comm_voucher,
                "name" => $project->nama_project_internal,
                "pic" => $project->nama_user == null ? "": $project->nama_user,
                "year" => $yearProject < date('Y') - 5 ? "-":$yearProject,
                "table" => "comm_voucher",
            ];
        }

        return $defaultData;
    }

    protected function project_sindikasi($typeProject): array
    {
        $defaultData = [];
        $projects = DataSindikasi::where("comm_voucher.on_budget", "!=", 1);
        if ($typeProject == "B1") {
            $projects = $projects->join("data_user", "comm_voucher.research_executive", "=", "data_user.id_user")->where("data_user.dept", "=", 76);
        }
        $projects = $projects->get();
        foreach ($projects as $project) {
            $defaultData[] = [
                "id" => $project->id_comm_voucher,
                "name" => $project->nama_project_internal,
                "table" => "comm_voucher",
            ];
        }

        return $defaultData;
    }
}
