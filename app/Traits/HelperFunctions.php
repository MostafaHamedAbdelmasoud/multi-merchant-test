<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 04/10/20
 * Time: 02:48 م
 */

namespace App\Traits;

use App\Models\User\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait HelperFunctions
{
    public function checkUniqueValues(array $array, string $column, $value)
    {
        if (!is_array($array[0]))
            return false;

        $collection = collect($array);
        $count = $collection->where($column, $value)->count();
        return ($count <= 1) ? true : false;
    }

    public function checkDuplicate(array $array, string $column)
    {
        if (!is_array($array[0]))
            return false;
        $collection = collect($array);
        $collection = collect($collection->map(function ($arr) {
            return collect($arr);
        }));
        $unique = $collection->unique($column);
        $dupes = $collection->diff($unique);
        return ($dupes->count() == 0) ? true : false;
    }

    static function removeImage($image)
    {
        $file = str_replace(url('/'), '', $image);
        $path = public_path($file);
        File::delete($path);
    }

    static function makeSlug($string = null, $lettersCount = 100, $separator = "-")
    {
        if (is_null($string)) {
            return "";
        }
        // Remove spaces from the beginning and from the end of the string
        $string = trim($string);
        // Lower case everything
        $string = mb_strtolower($string, "UTF-8");
        // letters and numbers only with arabic letters too
        $string = preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);
        // Remove multiple dashes or whitespaces
        $string = preg_replace("/[\s\-]+/", " ", $string);
        // Convert whitespaces and underscore to the given separator
        $string = preg_replace("/[\s_]/", $separator, $string);
        //limit slug to  $lettersCount = (100)

        return Str::limit($string, $lettersCount, '');
    }


    /**
     * it helps to update,delete,create all the related models with processed model
     *
     * @param $request
     * @param $parent
     * @param $model
     * @param $childName
     * @param $parentName
     * @param $oldIDs
     * @return mixed
     */
    static function CurdOperation($request, $parent, $model, $childName, $parentName, $oldIDs)
    {

        $arr = [];

        foreach ($request[$childName] as $child) {

            if ($child['id']) {

                $childModel = $model->findOrFail($child['id']);
                $childModel->update($child);

                $arr[] = $child['id'];

            } else {
                $model->create(array_merge($child, [
                    $parentName . '_id' => $parent->id
                ]));
            }
        }

        //delete variants
        $deletedIds = array_diff($oldIDs, $arr);
        $model->whereIn('id', $deletedIds)->delete();

        return $parent;


    }

}
