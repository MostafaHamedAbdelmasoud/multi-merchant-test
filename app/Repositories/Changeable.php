<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 10/11/20
 * Time: 01:51 م
 */

namespace App\Repositories;


trait Changeable
{
    protected $relations = [];
    protected $conditions = [];
    protected $column_conditions = [];
    protected $key = [];
    protected $related_ids = [];
    protected $RelationName = [];
    protected $appendsColumns = [];
    protected $original_id = [];
    protected $orConditions = [];
    protected $columns = ['*'];
    protected $column = 'id';

    public function setRelations($relations = null)
    {
        $this->relations = $relations;
    }

    public function setConditions(array $conditions = [])
    {
        $this->conditions = $conditions;
    }

    public function setColumnConditions(array $column_conditions = [])
    {
        $this->column_conditions = $column_conditions;
    }

    public function setOrConditions(array $conditions = [])
    {
        $this->orConditions = $conditions;
    }

    public function setColumns($columns = null)
    {
        $this->columns = $columns;
    }

    public function setRelatedIds($original_id = null, array $related_ids = null)
    {
        $this->original_id = $original_id;

        $this->related_ids = $related_ids;
    }

    public function setHasRelationName($RelationName = null, array  $key = null )
    {
        $this->RelationName = $RelationName;

        $this->key = $key;
    }

    public function setNotNullColumn($column = 'id')
    {
        $this->column = $column;

    }

    public function setAppends($appendsColumns = [])
    {
        $this->appendsColumns = $appendsColumns;

    }


}
