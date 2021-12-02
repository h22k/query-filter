<?php

namespace H22k\QueryFilter;

use H22k\QueryFilter\Exceptions\UnexpectedVariableType;
use Illuminate\Database\Eloquent\Model;

class Filter
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @var array
     */
    protected array $whereData;

    /**
     * @var string
     */
    protected string $queryType;

    /**
     * @throws UnexpectedVariableType
     */
    public function __construct(Model $model, array $whereData, string $queryType)
    {
        $this->model = $model;
        $this->whereData = $whereData;
        $this->queryType = $queryType;

        $this->checkWhereData();
    }

    /**
     * @throws UnexpectedVariableType
     */
    private function checkWhereData(): void
    {
        array_map(function ($item) {
           if ( ! $item instanceof F) {
               throw new UnexpectedVariableType
               ("Check your whereData array! All items of whereData must be instance of F");
           }
        }, $this->whereData);
    }

}
