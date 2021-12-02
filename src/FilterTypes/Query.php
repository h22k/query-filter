<?php

use H22k\QueryFilter\F;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

abstract class Query
{
    protected Model $model;
    protected F $filter;

    public function __construct(Model $model, F $filter)
    {
        $this->model = $model;
        $this->filter = $filter;
    }

    abstract public function filter(): Model;

    /**
     * @return string
     */
    #[Pure]
    protected function getColumn(): string
    {
        return $this->filter->getColumn();
    }

}
