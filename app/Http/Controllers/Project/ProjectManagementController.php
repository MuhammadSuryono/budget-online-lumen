<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProjectManagementInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectManagementController extends Controller
{
    /**
     * @var ProjectManagementInterface $projectManagement
     */
    protected ProjectManagementInterface $projectManagement;

    /**
     * @var Request $request
     */
    protected Request $request;

    public function __construct(Request $request, ProjectManagementInterface $projectManagement)
    {
        $this->middleware('auth:api');
        $this->projectManagement = $projectManagement;
        $this->request = $request;
    }

    /**
     * @param $type
     * @return JsonResponse
     */
    public function get_list_project($type): JsonResponse
    {
        $callbackRead = $this->projectManagement->get_list_project($type);
        return $this->BuildResponse(200, $callbackRead->message, $callbackRead->data);
    }
}
