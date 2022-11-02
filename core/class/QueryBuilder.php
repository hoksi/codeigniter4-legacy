<?php
namespace Fran;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\RawSql;

class QueryBuilder
{
    private $qb;
    private $qryType = 'select';
    private $dbType = 'mysql';

    public function __construct($dbType = 'mysql', $config = [])
    {
        $this->dbType = $dbType;

        switch($dbType) {
            case 'oci8':
                $this->qb = new \CodeIgniter\Database\MySQLi\Builder('dual', new \CodeIgniter\Database\OCI8\Connection($config));
                break;
            case 'postgre':
                $this->qb = new \CodeIgniter\Database\MySQLi\Builder('dual', new \CodeIgniter\Database\Postgre\Connection($config));
                break;
            case 'sqlite3':
                $this->qb = new \CodeIgniter\Database\MySQLi\Builder('dual', new \CodeIgniter\Database\SQLite3\Connection($config));
                break;
            case 'sqlsrv':
                $this->qb = new \CodeIgniter\Database\MySQLi\Builder('dual', new \CodeIgniter\Database\SQLSRV\Connection($config));
                break;
            default:
                $this->dbType = 'mysql';
                $this->qb = new \CodeIgniter\Database\MySQLi\Builder('dual', new \CodeIgniter\Database\MySQLi\Connection($config));
                break;
        }
    }

    public function getQueryString()
    {
        return $this->toStr();
    }

    public function toStr()
    {
        switch ($this->qryType) {
            case 'select':
                return $this->qb->getCompiledSelect();
            case 'insert':
                return $this->qb->getCompiledInsert();
            case 'delete':
                return $this->qb->getCompiledDelete();
            case 'update':
                return $this->qb->getCompiledUpdate();
        }

        return '';
    }

    /**
     * Generates the SELECT portion of the query
     *
     * @param array|RawSql|string $select
     *
     * @return $this
     */
    public function select($select = '*', ?bool $escape = null): self
    {
        $this->qryType = 'select';

        $this->qb->select($select, $escape);

        return $this;
    }

    /**
     * Generates a SELECT MAX(field) portion of a query
     *
     * @return $this
     */
    public function selectMax(string $select = '', string $alias = '')
    {
        $this->qb->selectMax($select, $alias);

        return $this;
    }

    /**
     * Generates a SELECT MIN(field) portion of a query
     *
     * @return $this
     */
    public function selectMin(string $select = '', string $alias = '')
    {
        $this->qb->selectMin($select, $alias);

        return $this;
    }

    /**
     * Generates a SELECT AVG(field) portion of a query
     *
     * @return $this
     */
    public function selectAvg(string $select = '', string $alias = '')
    {
        $this->qb->selectAvg($select, $alias);

        return $this;
    }

    /**
     * Generates a SELECT SUM(field) portion of a query
     *
     * @return $this
     */
    public function selectSum(string $select = '', string $alias = '')
    {
        $this->qb->selectSum($select, $alias);

        return $this;
    }

    /**
     * Generates a SELECT COUNT(field) portion of a query
     *
     * @return $this
     */
    public function selectCount(string $select = '', string $alias = '')
    {
        $this->qb->selectCount($select, $alias);

        return $this;
    }

    /**
     * Generates the FROM portion of the query
     *
     * @param array|string $from
     *
     * @return $this
     */
    public function from($from, bool $overwrite = true): self
    {
        $this->qb->from($from, $overwrite);

        return $this;
    }

    /**
     * Generates the JOIN portion of the query
     *
     * @param RawSql|string $cond
     *
     * @return $this
     */
    public function join(string $table, $cond, string $type = '', ?bool $escape = null)
    {
        $this->qb->join($table, $cond, $type, $escape);

        return $this;
    }

    /**
     * Generates the WHERE portion of the query.
     * Separates multiple calls with 'AND'.
     *
     * @param array|RawSql|string $key
     * @param mixed               $value
     *
     * @return $this
     */
    public function where($key, $value = null, ?bool $escape = null): self
    {
        $this->qb->where($key, $value, $escape);

        return $this;
    }

    /**
     * OR WHERE
     *
     * Generates the WHERE portion of the query.
     * Separates multiple calls with 'OR'.
     *
     * @param array|RawSql|string $key
     * @param mixed               $value
     * @param bool                $escape
     *
     * @return $this
     */
    public function orWhere($key, $value = null, ?bool $escape = null)
    {
        $this->qb->orWhere($key, $value, $escape);

        return $this;
    }

    /**
     * Generates a WHERE field IN('item', 'item') SQL query,
     * joined with 'AND' if appropriate.
     *
     * @param array|BaseBuilder|Closure|string $values The values searched on, or anonymous function with subquery
     *
     * @return $this
     */
    public function whereIn(?string $key = null, $values = null, ?bool $escape = null)
    {
        $this->qb->whereIn($key, $values, $escape);

        return $this;
    }

    /**
     * Generates a WHERE field IN('item', 'item') SQL query,
     * joined with 'OR' if appropriate.
     *
     * @param array|BaseBuilder|Closure|string $values The values searched on, or anonymous function with subquery
     *
     * @return $this
     */
    public function orWhereIn(?string $key = null, $values = null, ?bool $escape = null)
    {
        $this->qb->orWhereIn($key, $values, $escape);

        return $this;
    }

    /**
     * Generates a WHERE field NOT IN('item', 'item') SQL query,
     * joined with 'AND' if appropriate.
     *
     * @param array|BaseBuilder|Closure|string $values The values searched on, or anonymous function with subquery
     *
     * @return $this
     */
    public function whereNotIn(?string $key = null, $values = null, ?bool $escape = null)
    {
        $this->qb->whereNotIn($key, $values, $escape);

        return $this;
    }

    /**
     * Generates a WHERE field NOT IN('item', 'item') SQL query,
     * joined with 'OR' if appropriate.
     *
     * @param array|BaseBuilder|Closure|string $values The values searched on, or anonymous function with subquery
     *
     * @return $this
     */
    public function orWhereNotIn(?string $key = null, $values = null, ?bool $escape = null)
    {
        $this->qb->orWhereNotIn($key, $values, $escape);

        return $this;
    }

    /**
     * Generates a HAVING field IN('item', 'item') SQL query,
     * joined with 'AND' if appropriate.
     *
     * @param array|BaseBuilder|Closure|string $values The values searched on, or anonymous function with subquery
     *
     * @return $this
     */
    public function havingIn(?string $key = null, $values = null, ?bool $escape = null)
    {
        $this->qb->havingIn($key, $values, $escape);

        return $this;
    }

    /**
     * Generates a HAVING field IN('item', 'item') SQL query,
     * joined with 'OR' if appropriate.
     *
     * @param array|BaseBuilder|Closure|string $values The values searched on, or anonymous function with subquery
     *
     * @return $this
     */
    public function orHavingIn(?string $key = null, $values = null, ?bool $escape = null)
    {
        $this->qb->orHavingIn($key, $values, $escape);

        return $this;
    }

    /**
     * Generates a HAVING field NOT IN('item', 'item') SQL query,
     * joined with 'AND' if appropriate.
     *
     * @param array|BaseBuilder|Closure|string $values The values searched on, or anonymous function with subquery
     *
     * @return $this
     */
    public function havingNotIn(?string $key = null, $values = null, ?bool $escape = null)
    {
        $this->qb->havingNotIn($key, $values, $escape);

        return $this;
    }

    /**
     * Generates a HAVING field NOT IN('item', 'item') SQL query,
     * joined with 'OR' if appropriate.
     *
     * @param array|BaseBuilder|Closure|string $values The values searched on, or anonymous function with subquery
     *
     * @return $this
     */
    public function orHavingNotIn(?string $key = null, $values = null, ?bool $escape = null)
    {
        $this->qb->orHavingNotIn($key, $values, $escape);

        return $this;
    }

    /**
     * Generates a %LIKE% portion of the query.
     * Separates multiple calls with 'AND'.
     *
     * @param array|RawSql|string $field
     *
     * @return $this
     */
    public function like($field, string $match = '', string $side = 'both', ?bool $escape = null, bool $insensitiveSearch = false)
    {
        $this->qb->like($field, $match, $side, $escape);

        return $this;
    }

    /**
     * Generates a NOT LIKE portion of the query.
     * Separates multiple calls with 'AND'.
     *
     * @param array|RawSql|string $field
     *
     * @return $this
     */
    public function notLike($field, string $match = '', string $side = 'both', ?bool $escape = null, bool $insensitiveSearch = false)
    {
        $this->qb->notLike($field, $match, $side, $escape, $insensitiveSearch);

        return $this;
    }

    /**
     * Generates a %LIKE% portion of the query.
     * Separates multiple calls with 'OR'.
     *
     * @param array|RawSql|string $field
     *
     * @return $this
     */
    public function orLike($field, string $match = '', string $side = 'both', ?bool $escape = null, bool $insensitiveSearch = false)
    {
        $this->qb->orLike($field, $match, $side, $escape, $insensitiveSearch);

        return $this;
    }

    /**
     * Generates a NOT LIKE portion of the query.
     * Separates multiple calls with 'OR'.
     *
     * @param array|RawSql|string $field
     *
     * @return $this
     */
    public function orNotLike($field, string $match = '', string $side = 'both', ?bool $escape = null, bool $insensitiveSearch = false)
    {
        $this->qb->orNotLike($field, $match, $side, $escape, $insensitiveSearch);

        return $this;
    }

    /**
     * Generates a %LIKE% portion of the query.
     * Separates multiple calls with 'AND'.
     *
     * @param array|RawSql|string $field
     *
     * @return $this
     */
    public function havingLike($field, string $match = '', string $side = 'both', ?bool $escape = null, bool $insensitiveSearch = false)
    {
        $this->qb->havingLike($field, $match, $side, $escape, $insensitiveSearch);

        return $this;
    }

    /**
     * Generates a NOT LIKE portion of the query.
     * Separates multiple calls with 'AND'.
     *
     * @param array|RawSql|string $field
     *
     * @return $this
     */
    public function notHavingLike($field, string $match = '', string $side = 'both', ?bool $escape = null, bool $insensitiveSearch = false)
    {
        $this->qb->notHavingLike($field, $match, $side, $escape, $insensitiveSearch);

        return $this;
    }

    /**
     * Generates a %LIKE% portion of the query.
     * Separates multiple calls with 'OR'.
     *
     * @param array|RawSql|string $field
     *
     * @return $this
     */
    public function orHavingLike($field, string $match = '', string $side = 'both', ?bool $escape = null, bool $insensitiveSearch = false)
    {
        $this->qb->orHavingLike($field, $match, $side, $escape, $insensitiveSearch);

        return $this;
    }

    /**
     * Generates a NOT LIKE portion of the query.
     * Separates multiple calls with 'OR'.
     *
     * @param array|RawSql|string $field
     *
     * @return $this
     */
    public function orNotHavingLike($field, string $match = '', string $side = 'both', ?bool $escape = null, bool $insensitiveSearch = false)
    {
        $this->qb->orNotHavingLike($field, $match, $side, $escape, $insensitiveSearch);

        return $this;
    }

    /**
     * @param array|string $by
     *
     * @return $this
     */
    public function groupBy($by, ?bool $escape = null)
    {
        $this->qb->groupBy($by, $escape);

        return $this;
    }

    /**
     * Sets a flag which tells the query string compiler to add DISTINCT
     *
     * @return $this
     */
    public function distinct(bool $val = true)
    {
        $this->qb->distinct($val);

        return $this;
    }

    /**
     * Separates multiple calls with 'AND'.
     *
     * @param array|RawSql|string $key
     * @param mixed               $value
     *
     * @return $this
     */
    public function having($key, $value = null, ?bool $escape = null)
    {
        $this->qb->having($key, $value, $escape);

        return $this;
    }

    /**
     * Separates multiple calls with 'OR'.
     *
     * @param array|RawSql|string $key
     * @param mixed               $value
     *
     * @return $this
     */
    public function orHaving($key, $value = null, ?bool $escape = null)
    {
        $this->qb->orHaving($key, $value, $escape);

        return $this;
    }

    /**
     * @param string $direction ASC, DESC or RANDOM
     *
     * @return $this
     */
    public function orderBy(string $orderBy, string $direction = '', ?bool $escape = null)
    {
        $this->qb->orderBy($orderBy, $direction, $escape);

        return $this;
    }

    /**
     * @return $this
     */
    public function limit(?int $value = null, ?int $offset = 0)
    {
        $this->qb->limit($value, $offset);

        return $this;
    }

    /**
     * Sets the OFFSET value
     *
     * @return $this
     */
    public function offset(int $offset)
    {
        $this->qb->offset($offset);

        return $this;
    }

    /**
     * Compiles an insert string and runs the query
     *
     * @param array|object|null $set
     *
     * @return bool
     *
     * @throws DatabaseException
     */
    public function insert($table): self
    {
        $this->qryType = 'insert';

        $this->qb->from($table);

        return $this;
    }

    /**
     * Compiles an update string and runs the query.
     *
     * @param array|object|null        $set
     * @param array|RawSql|string|null $where
     *
     * @throws DatabaseException
     */
    public function update($table): self
    {
        $this->qryType = 'update';

        $this->qb->from($table);

        return $this;
    }

    /**
     * Compiles a delete string and runs the query
     *
     * @param mixed $where
     *
     * @return bool|string
     *
     * @throws DatabaseException
     */
    public function delete($table): self
    {
        $this->qryType = 'delete';

        $this->qb->from($table);

        return $this;
    }


}