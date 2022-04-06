<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return response()->json([
        "status" => "success",
        "message" => "Welcome to the API",
        "app_version" => "1.0.0",
        "app_name" => "Budget Online Api",
    ]);
});

$router->group(['prefix' => 'api/v1'], function () use ($router)
{
    // Auth
    $router->group(['prefix' => 'auth'], function () use ($router)
    {
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh-token', 'AuthController@refresh_token');
    });

    $router->group(['prefix' => 'submission'], function () use ($router)
    {
        $router->get('/list', 'Submission\SubmissionBudgetController@list_submission');
        $router->get('/{submissionId}', 'Submission\SubmissionBudgetController@read');
        $router->get('/option-folder/list', 'Submission\SubmissionBudgetController@get_options_folder');
        $router->get('/category-folder/list', 'Submission\SubmissionBudgetController@get_category_folder');

        $router->group(['prefix' => '{submissionId}/item'], function () use ($router)
        {
            $router->get('/list', 'Submission\Item\ItemBudgetController@list_items');
        });
    });

    $router->group(['prefix' => 'item'], function () use ($router)
    {
        $router->get('/{itemId}', 'Submission\Item\ItemBudgetController@read');
        $router->get('/{itemId}/bpu', 'Bpu\BpuController@list_bpu');
    });

    $router->group(['prefix' => 'user'], function () use ($router)
    {
        $router->get('/list', 'UserController@list_all');
    });

    $router->group(['prefix' => 'project'], function () use ($router)
    {
        $router->get('/{type}/list', 'Project\ProjectManagementController@get_list_project');
    });

});
