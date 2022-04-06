<?php

namespace App\Repositories;

use App\Models\Budget\CategoryNonRoutine;

class CategoryFolderRepository extends Controller implements Interfaces\CategoryFolderInterface
{
    /**
     * @return object
     */
    public function get_all_category_folders(): object
    {
        $data = CategoryNonRoutine::where("kode", "!=", "012")->get();
        return $this->callback(true, "Success retrieve data", $data);
    }
}
