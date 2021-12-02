<?php

namespace H22k\QueryFilter;

use H22k\QueryFilter\Exceptions\NotCallable;

class F
{

    private string $column;
    private string $queryType;
    private $callback;

    private function __construct(string $column, string $queryType, ?Callable $callback)
    {
        $this->column = $column;
        $this->queryType = $queryType;
        $this->callback = $callback;
    }

    /**
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * @return string
     */
    public function getQueryType(): string
    {
        return $this->queryType;
    }

    /**
     * @return callable|null
     * @throws NotCallable
     */
    public function getCallback(): ?callable
    {
        if ( ! $this->itHasCallback()) {
            throw new NotCallable("The callback is not callable!");
        }

        return $this->callback(...func_get_args());
    }

    /**
     * @return bool
     */
    public function itHasCallback(): bool
    {
        return is_callable($this->callback);
    }

    /**
     * @param string $column
     * @param string $queryType
     * @param callable|null $callback
     * @return F
     */
    public static function set(string $column, string $queryType = 'like', ?Callable $callback = null): F
    {
        return new F($column, $queryType, $callback);
    }

}
