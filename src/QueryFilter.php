<?php

namespace H22k\QueryFilter;

trait QueryFilter
{

    /**
     * Model columns you want to filter.
     * Example: ['F::set('name', 'like')', 'F::set('age', 'higher')']
     *
     * @var array
     */
    protected array $filterKeys;

    /**
     * Query type name. I explain below.
     *
     * @var string
     */
    private string $queryTypeName = 'qt';

    /**
     * ?{$this->queryTypeName}= be should 'or' or 'and'.
     * Example: ?qt=and is correct but ?qt=jhon is false.
     *
     * @var array|string[]
     */
    private array $allowedQueryTypes = ['or', 'and'];

    /**
     * @var string
     */
    private string $defaultQueryType = 'or';


    protected function filter()
    {
        $query = \Request::query() ?? [];

        if (isset($query[$this->queryTypeName])) {

            if (in_array($query[$this->queryTypeName], $this->allowedQueryTypes)) {
                $queryType = $query[$this->queryTypeName];
            }
            unset($query[$this->queryTypeName]);
        }


    }


    /**
     * Setting query type name. Throws an exception if the table has a column with the same name.
     *
     * @param string $typeName
     * @throws Exceptions\ModelHasColumnName
     */
    protected function setQueryTypeName(string $typeName): void
    {
        $this->queryTypeName = Column::set($this, $typeName);
    }

}
