<?php

namespace H22k\QueryFilter;

trait QueryFilter
{

    /**
     * Controller's main eloquent model.
     * Example: UserController => Model/User.php => User::class.
     *
     * @var string
     */
    protected string $model;

    /**
     * Model columns you want to filter.
     * Example: ['name', 'age', 'email']
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
     * Connection name. If you use another connection, change that.
     *
     * @var string
     */
    protected string $connectionType = 'mysql';

    protected function filter(array $query, array|string $columns)
    {
        if (isset($query[$this->queryTypeName])) {
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
        $this->queryTypeName = Column::set($this->model, $typeName, $this->connectionType);
    }

}
