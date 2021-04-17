<?php

declare(strict_types=1);

namespace Tpetry\PostgresqlEnhanced\Schema;

use Illuminate\Database\Query\Builder as QueryBuilder;

trait BuilderView
{
    /**
     * Create a recursive view on the schema.
     */
    public function createRecursiveView(string $name, QueryBuilder | string $query, array $columns): void
    {
        $name = $this->getConnection()->getSchemaGrammar()->wrapTable($name);
        $columns = $this->getConnection()->getSchemaGrammar()->columnize($columns);
        $query = $this->makeSqlQuery($query);
        $this->getConnection()->statement("create recursive view {$name} ({$columns}) as {$query}");
    }

    /**
     * Create or replace a recursive view on the schema.
     */
    public function createRecursiveViewOrReplace(string $name, QueryBuilder | string $query, array $columns): void
    {
        $name = $this->getConnection()->getSchemaGrammar()->wrapTable($name);
        $columns = $this->getConnection()->getSchemaGrammar()->columnize($columns);
        $query = $this->makeSqlQuery($query);
        $this->getConnection()->statement("create or replace recursive view {$name} ({$columns}) as {$query}");
    }

    /**
     * Create a view on the schema.
     */
    public function createView(string $name, QueryBuilder | string $query): void
    {
        $name = $this->getConnection()->getSchemaGrammar()->wrapTable($name);
        $query = $this->makeSqlQuery($query);
        $this->getConnection()->statement("create view {$name} as {$query}");
    }

    /**
     * Create or replace a view on the schema.
     */
    public function createViewOrReplace(string $name, QueryBuilder | string $query): void
    {
        $name = $this->getConnection()->getSchemaGrammar()->wrapTable($name);
        $query = $this->makeSqlQuery($query);
        $this->getConnection()->statement("create or replace view {$name} as {$query}");
    }

    /**
     * Drop views from the schema.
     */
    public function dropView(string ...$name): void
    {
        $names = $this->getConnection()->getSchemaGrammar()->namize($name);
        $this->getConnection()->statement("drop view {$names}");
    }

    /**
     * Drop views from the schema if they exist.
     */
    public function dropViewIfExists(string ...$name): void
    {
        $names = $this->getConnection()->getSchemaGrammar()->namize($name);
        $this->getConnection()->statement("drop view if exists {$names}");
    }
}
