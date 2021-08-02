<?php

namespace App\Traits;

use App\ThirdParty\SmsMasr;
use Symfony\Component\HttpFoundation\Response;


trait HelpersTrait
{
    /**
     * check if keys in array
     * @param array $keys
     * @param array $arr
     * @return bool
     */
    function array_keys_exists(array $keys, array $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }

}
