<?php

namespace App\Repositories\Interfaces;

interface CategoryQuestionInterface
{
    /***
     * @param string $name
     * @return object
     */
    public function create_category(string $name): object;

    /***
     * @param int $id
     * @param string $name
     * @return object
     */
    public function update_category(int $id, string $name): object;

    /***
     * @param int $id
     * @return object
     */
    public function delete_category(int $id): object;

    /***
     * @param int $perPage
     * @param int $page
     * @return object
     */
    public function list_category(int $page = 1, int $perPage = 10): object;
}
