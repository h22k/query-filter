<?php

use H22k\QueryFilter\F;

if ( ! function_exists('h22kFilter')) {

    /**
     * @param string $column
     * @param string $queryType
     * @param callable|null $callback
     * @return F
     */
    function h22kFilter(string $column, string $queryType = 'like', ?Callable $callback = null): F
    {
        return F::set($column, $queryType, $callback);
    }

}

