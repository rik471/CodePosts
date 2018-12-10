<?php

namespace CodePress\CodeDatabase\Contracts\Criteria;


use CodePress\CodeDatabase\Contracts\CriteriaInterface;
use CodePress\CodeDatabase\Contracts\RepositoryInterface;

class OrderDescByName implements CriteriaInterface
{


    public function apply($model, RepositoryInterface $repository)
    {
        return $model->orderBy('name', 'desc');

    }
}