<?php

namespace H22k\QueryFilter;

use H22k\QueryFilter\Exceptions\ModelHasColumnName;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class Column
{

    /**
     * Checking if there is a similar column with the same name in the table.
     *
     * @param Model $model
     * @param string $typeName
     * @return string
     * @throws ModelHasColumnName
     */
    private static function check(Model $model, string $typeName): string
    {
        if (in_array($typeName, self::getCurrentColumns($model))) {

            $tableName = self::getTableNameAndConnection($model)['tableName'];
            throw new ModelHasColumnName
            ("You cannot use the name {$typeName} because there is a column with that name in the {$tableName} table.");
        }
        return $typeName;
    }

    /**
     * Name standard.
     *
     * @param Model $model
     * @param string $typeName
     * @return string
     * @throws ModelHasColumnName
     */
    public static function set(Model $model, string $typeName): string
    {
        return self::check($model, $typeName);
    }

    /**
     * Get current table name with eloquent getTable method.
     *
     * @param Model $model
     * @return array
     */
    #[ArrayShape(['tableName' => "string", 'connection' => "string"])]
    private static function getTableNameAndConnection(Model $model): array
    {
        return [
            'tableName' => $model->getTable(),
            'connection' => $model->getConnection()->getDriverName()
        ];
    }

    /**
     * Any model columns.
     *
     * @param string $connection
     * @param string $tableName
     * @return array
     */
    public static function getColumns(string $connection, string $tableName): array
    {
        return \Schema::connection($connection)->getColumnListing($tableName);
    }

    /**
     * Current model columns.
     *
     * @param Model $model
     * @return array
     */
    private static function getCurrentColumns(Model $model): array
    {
        [
            'tableName'     => $tableName,
            'connection'    => $connection
        ] = self::getTableNameAndConnection($model);

        return self::getColumns($connection, $tableName);
    }

}
