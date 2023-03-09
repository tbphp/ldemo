<?php

namespace App\Models;

use Carbon\Carbon;
use Closure;
use DateTimeInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Concerns\BuildsQueries;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Query\Builder as QBuilder;
use Illuminate\Database\Query\Expression;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

/**
 * @property int $id 唯一主键
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property array $attributes
 *
 * @method static bool each(callable $callback, int $count = 1000) Execute a callback over each item while chunking.
 * @method static Eloquent|static|object|BuildsQueries|null first(array $columns = ['*']) Execute the query and get the first result.
 * @method static mixed|Builder when(mixed $value, callable $callback, callable $default = null) Apply the callback's query changes if the given "value" is true.
 * @method static Builder|static has(string $relation, string $operator = '>=', int $count = 1, string $boolean = 'and', Closure $callback = null) Add a relationship count / exists condition to the query.
 * @method static Builder|static whereHas(string $relation, Closure $callback = null, string $operator = '>=', int $count = 1) Add a relationship count / exists condition to the query with where clauses.
 * @method static Builder|static orWhereHas(string $relation, Closure $callback = null, string $operator = '>=', int $count = 1) Add a relationship count / exists condition to the query with where clauses and an "or".
 * @method static Builder|static doesntHave(string $relation, string $boolean = 'and', Closure $callback = null) Add a relationship count / exists condition to the query.
 * @method static Eloquent|static make(array $attributes = []) Create and return an un-saved model instance.
 * @method static Builder|static where(string | array | Closure $column, mixed $operator = null, mixed $value = null, string $boolean = 'and') Add a basic where clause to the query.
 * @method static Builder|static whereBetween(string | Expression $column, array $values, string $boolean = 'and', boolean $not = false) Add a where between statement to the query.
 * @method static Builder|static orWhere(Closure | array | string $column, mixed $operator = null, mixed $value = null) Add an "or where" clause to the query.
 * @method static EloquentCollection|Builder[]|null|Builder|Eloquent|static|static[] find(mixed $id, array $columns = ['*']) Find a model by its primary key.
 * @method static EloquentCollection findMany(Arrayable | array $ids, $columns = ['*']) Find multiple models by their primary keys.
 * @method static EloquentCollection|Builder[]|null|Builder|Eloquent|static|static[] findOrFail(mixed $id, array $columns = ['*']) Find a model by its primary key or throw an exception.
 * @method static Builder|Eloquent|static firstOrCreate(array $attributes, array $values = []) Get the first record matching the attributes or create it.
 * @method static Builder|Eloquent|static updateOrCreate(array $attributes, array $values = []) Create or update a record matching the attributes, and fill it with values.
 * @method static mixed value(string $column) Get a single column's value from the first result of a query.
 * @method static EloquentCollection|Builder[] get(array $columns = ['*']) Execute the query as a "select" statement.
 * @method static int count(string $columns = '*') Retrieve the "count" result of the query.
 * @method static mixed sum(string $column) Retrieve the sum of the values of a given column.
 * @method static Collection pluck(string $column, string | null $key = null) Get an array with the values of a given column.
 * @method static LengthAwarePaginator paginate(int|null $perPage = null, array $columns = ['*'], string $pageName = 'page', int | null $page = null) Paginate the given query.
 * @method static Paginator page(int|null|Closure $perPage = null, Closure $callback = null) Paginate the given query.
 * @method static Builder|Eloquent|static create(array $attributes = []) Save a new model and return the instance.
 * @method static Builder|static with(mixed ...$relations) Begin querying a model with eager loading.
 * @method static Builder|static withCount(mixed ...$relations) Add subselect queries to count the relations.
 * @method static Builder|static without(mixed $relations) Prevent the specified relations from being eager loaded.
 * @method static QBuilder getQuery() Get the underlying query builder instance.
 * @method static QBuilder select(array | mixed $columns = ['*']) Set the columns to be selected.
 * @method static QBuilder|QBuilder selectRaw(string $expression, array $bindings = []) Add a new "raw" select expression to the query.
 * @method static QBuilder|Builder whereIn(string $column, mixed $values, string $boolean = 'and', bool $not = false) Add a "where in" clause to the query.
 * @method static QBuilder|Builder orWhereIn(string $column, mixed $values) Add an "or where in" clause to the query.
 * @method static QBuilder|Builder whereDate(string $column, string $operator, DateTimeInterface | string $value = null, string $boolean = 'and') Add a "where date" statement to the query.
 * @method static QBuilder groupBy(array|string ...$groups) Add a "group by" clause to the query.
 * @method static QBuilder orderBy(string $column, string $direction = 'asc') Add an "order by" clause to the query.
 * @method static QBuilder orderByDesc(string $column) Add a descending "order by" clause to the query.
 * @method static QBuilder limit(int $value) Set the "limit" value of the query.
 * @method static Builder|static withoutGlobalScope(Scope | string $scope) Remove a registered global scope.
 * @method static Builder|static withTrashed()
 */
trait ModelAnnotate
{
}
