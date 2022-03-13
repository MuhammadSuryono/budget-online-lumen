<?php

namespace App\Repositories;

use App\Models\CategoryQuestion;
use Illuminate\Support\Facades\DB;

class CategoryQuestionRepository extends Controller implements Interfaces\CategoryQuestionInterface
{
    /***
     * @param string $name
     * @return object
     */
    public function create_category(string $name): object
    {
        if ($this->already_category_name($name)) return $this->callback(false, "Already exists for " . $name);
        $category = new CategoryQuestion();
        $category->code = $this->generate_code();
        $category->name = $name;
        $category->save();

        return $this->callback(true, "Success create", $name);
    }

    /***
     * @param int $id
     * @param string $name
     * @return object
     */
    public function update_category(int $id, string $name): object
    {
        $getData = $this->already_category_id($id);
        if (!$getData->is_exist) return $this->callback(false, "Data not found");
        if ($this->already_category_name($name)) return $this->callback(false, "Already exists for " . $name);

        $category = $getData->data;
        $category->name = $name;
        $category->save();

        return $this->callback(true, "Success update");
    }

    /***
     * @param int $id
     * @return object
     */
    public function delete_category(int $id): object
    {
        $getData = $this->already_category_id($id);
        if (!$getData->is_exist) return $this->callback(false, "Data not found");
        $category = $getData->data;
        $category->delete();

        return $this->callback(true, "Success delete");
    }

    /***
     * @param int $page
     * @param int $perPage
     * @return object
     */
    public function list_category(int $page = 1, int $perPage = 10): object
    {
        return DB::table('category_question')->paginate($perPage, ['*'], 'page', $page);
    }

    /***
     * @return string
     */
    private function generate_code(): string
    {
        $prefixCode = 'QUE';
        $data = CategoryQuestion::orderBy('created_at', 'desc');
        if (!$data->exists()) {
            return $prefixCode . "0001";
        }
        $data = $data->first();
        $lastCode = $data->code;
        $splitCode = explode("E", $lastCode);

        $addQue = (int)$splitCode[1] + 1;
        return $prefixCode.str_pad($addQue, 4, "0", STR_PAD_LEFT);
    }

    /***
     * @param string $name
     * @return bool
     */
    private function already_category_name(string $name): bool
    {
        $category = CategoryQuestion::where('name', $name);
        if ($category->exists()) return true;
        return false;
    }

    /***
     * @param int $id
     * @return object
     */
    private function already_category_id(int $id): object
    {
        $category = CategoryQuestion::find($id);
        if (!$category) return (object)["is_exist" => false, "data" => null];
        return (object)["is_exist" => true, "data" => $category];
    }

    /**
     * @return mixed
     */
    public function get_category_sequence($lastCategoryId)
    {
        if ($lastCategoryId != null) {
            return CategoryQuestion::where('id', '>', $lastCategoryId)->orderBy('id', 'asc')->first();
        }
        return CategoryQuestion::orderBy('sequence', 'asc')->first();
    }

    public function is_last_category($categoryId): bool
    {
        $category = CategoryQuestion::where('id', '>', $categoryId)->first();
        return $category == null;
    }

    public function category_sort_type($typeId)
    {
        return CategoryQuestion::where('type_exam_id', $typeId)->first();
    }
}
