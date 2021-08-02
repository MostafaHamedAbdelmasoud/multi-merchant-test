<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 10/11/20
 * Time: 01:50 م
 */

namespace App\Repositories;


trait Sortable
{
    public $sortBy='created_at';

    public $sortOrder='asc';

    public function setSortBy($sortBy = 'created_at')
    {
        $this->sortBy = $sortBy;
    }

    public function setSortOrder($sortOrder = 'desc')
    {
        $this->sortOrder = $sortOrder;
    }
}
