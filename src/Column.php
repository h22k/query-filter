<?php

namespace H22k\QueryFilter;

use App\Models\User;
use H22k\QueryFilter\Exceptions\ModelHasColumnName;

class Column
{

    /**
     * Checking if there is a similar column with the same name in the table.
     *
     * @param string $model
     * @param string $typeName
     * @param string $connection
     * @return string
     * @throws ModelHasColumnName
     */
    public static function check(string $model, string $typeName, string $connection): string
    {
        if (in_array($typeName, self::getCurrentColumns($model, $connection))) {

            $tableName = self::getTableName($model);
            throw new ModelHasColumnName
            ("You cannot use the name {$typeName} because there is a column with that name in the {$tableName} table.");
        }
        return $typeName;
    }

    /**
     * Name standard.
     *
     * @param string $model
     * @param string $typeName
     * @param string $connection
     * @return string
     * @throws ModelHasColumnName
     */
    public static function set(string $model, string $typeName, string $connection): string
    {
        return self::check($model, $typeName, $connection);
    }

    /**
     * Get current table name with eloquent getTable method.
     *
     * @param string $model
     * @return string
     */
    private static function getTableName(string $model): string
    {
        return (new $model)->getTable();
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
     * @param string $model
     * @param string $connection
     * @return array
     */
    private static function getCurrentColumns(string $model, string $connection): array
    {
        return self::getColumns($connection, self::getTableName($model));
    }

}
