<?php

namespace Core;

use Core\Compile;
use Exception;
use PDO;
use PDOException;

class QueryBuilder
{
    public static $calledModelInstance;

    public $pdo;

    /**
     * The columns that should be returned.
     *
     * @var array
     */
    private $columns;

    /**
     * The table which the query is targeting.
     *
     * @var string
     */
    private $table;

    /**
     * Indicates if the query returns distinct results.
     *
     * @var bool
     */
    private $distinct = false;

    /**
     * The table joins for the query.
     *
     * @var array
     */
    private $joins;

    /**
     * The where constraints for the query.
     *
     * @var array
     */
    private $wheres;

    /**
     * The where constraints for the query.
     *
     * @var array
     */
    private $wherein;

    /**
     * The groupings for the query.
     *
     * @var array
     */
    private $groups;

    /**
     * The having constraints for the query.
     *
     * @var array
     */
    private $having;

    /**
     * The orderings for the query.
     *
     * @var array
     */
    private $orders;

    /**
     * The maximum number of records to return.
     *
     * @var int
     */
    private $limit;

    /**
     * The number of records to skip.
     *
     * @var int
     */
    private $offset;

    /**
     * Take 1 record
     *
     * @var b0olean
     */
    private $find = false;

    /**
     * Take 1 record
     *
     * @var boolean
     */
    private $first = false;

    /**
     * Fails throw Exception
     */
    private $isThrow = false;

    /**
     * Create a new query builder instance.
     *
     * @param  ConnectionInterface  $this->table
     * @return void
     */

    /**
     * Compile instance
     */
    private $compile;

    public function __construct($table)
    {
        $this->calledFromModel = app()->callModel;
        $this->table = $table;
        $this->compile = new Compile;
    }

    public function getConnection()
    {
        try {
            $this->config = [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'mvc',
                'username' => 'root',
                'password' => '',
            ];
            $connection = $this->config['driver'];
            $host = $this->config['host'];
            $port = $this->config['port'];
            $database_name = $this->config['database'];
            $username = $this->config['username'];
            $password = $this->config['password'];
            $pdo = new PDO("$connection:host=$host;port=$port;dbname=$database_name", $username, $password, null);
            $pdo->exec("set names utf8");
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Create new query builder from model
     *
     * @param ConnectionInterface $this->bindClass
     * return self
     */
    public static function staticEloquentBuilder($table, $method, $args = null)
    {
        switch ($method) {
            case 'select':
                $select = $args && is_array($args[0]) ? $args[0] : $args;
                return (new self($table))->select($select);
            case 'addSelect':
                $select = $args && is_array($args[0]) ? $args[0] : $args;
                return (new self($table))->addSelect($select);
            case 'distinct':
                return (new self($table))->distinct();
            case 'join':
                list($tableJoin, $st, $operator, $nd) = $args;
                return (new self($table))->join($tableJoin, $st, $operator, $nd);
            case 'leftJoin':
                list($tableJoin, $st, $operator, $nd) = $args;
                return (new self($table))->leftJoin($tableJoin, $st, $operator, $nd);
            case 'rightJoin':
                list($tableJoin, $st, $operator, $nd) = $args;
                return (new self($table))->rightJoin($tableJoin, $st, $operator, $nd);
            case 'where':
                list($column, $operator, $value) = $args;
                return (new self($table))->where($column, $operator, $value);
            case 'orWhere':
                list($column, $operator, $value) = $args;
                return (new self($table))->orWhere($column, $operator, $value);
            case 'whereIn':
                list($column, $value) = $args;
                return (new self($table))->whereIn($column, $value);
            case 'whereNotIn':
                list($column, $value) = $args;
                return (new self($table))->whereNotIn($column, $value);
            case 'groupBy':
                $groupBy = $args && is_array($args[0]) ? $args[0] : $args;
                return (new self($table))->groupBy($groupBy);
            case 'having':
                list($column, $operator, $value) = $args;
                return (new self($table))->having($column, $operator, $value);
            case 'orHaving':
                list($column, $operator, $value) = $args;
                return (new self($table))->orHaving($column, $operator, $value);
            case 'orderBy':
                list($columns, $type) = $args;
                return (new self($table))->orderBy($columns, $type);
            case 'orderByDesc':
                list($columns) = $args;
                return (new self($table))->orderByDesc($columns);
            case 'latest':
                list($columns) = $args;
                return (new self($table))->latest($columns);
            case 'oldest':
                list($columns) = $args;
                return (new self($table))->oldest($columns);
            case 'limit':
                list($limit) = $args;
                return (new self($table))->limit($limit);
            case 'take':
                list($take) = $args;
                return (new self($table))->take($take);
            case 'skip':
                list($skip) = $args;
                return (new self($table))->skip($skip);
            case 'offset':
                list($offset) = $args;
                return (new self($table))->offset($offset);
            case 'get':
                return (new self($table))->get();
            case 'insert':
                list($data) = $args;
                return (new self($table))->insert($data);
            case 'create':
                list($data) = $args;
                return (new self($table))->create($data);
            case 'update':
                list($data) = $args;
                return (new self($table))->update($data);
            case 'find':
                list($value) = $args;
                $instance = self::calledModelInstance();
                $primaryKey = $instance->primaryKey();
                return (new self($table))->find($value, $primaryKey);
            case 'first':
                return (new self($table))->first();
            case 'findOrFail':
                list($value) = $args;
                $instance = self::calledModelInstance();
                $primaryKey = $instance->primaryKey();
                return (new self($table))->findOrFail($value, $primaryKey);
            case 'firstOrFail':
                return (new self($table))->firstOrFail();
            case 'delete':
                return (new self($table))->delete();
            case 'login':
                list($data) = $args;
                return (new self($table))->login($data);
            default:
                return new self($table);
        }
        return (new self($table))->$method($args);
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $this
     * @return \SupportCollection
     */
    public function get()
    {
        $sql = $this->pase();
        return $this->request($sql);
    }

    /**
     * View query builder to sql statement.
     *
     * @return \SupportSqlCollection
     */
    public function toSql()
    {
        echo $this->pase();die();
    }

    /**
     * Convert variables to sql
     *
     * @return \SupportSqlCollection
     */
    public function pase()
    {
        if (!isset($this->table) || empty($this->table)) {
            return false;
        }
        $sql = $this->compile->compileSelect($this->distinct);
        $sql .= $this->compile->compileColumns($this->columns);
        $sql .= $this->compile->compileFrom($this->table);
        if (isset($this->joins) && is_array($this->joins)) {
            $sql .= $this->compile->compileJoins($this->joins);
        }
        if (isset($this->wheres) && is_array($this->wheres)) {
            $sql .= $this->compile->compileWheres($this->wheres);
        }
        if (isset($this->wherein)) {
            $sql .= $this->compile->compileWhereIn($this->wherein);
        }
        if (isset($this->groups) && is_array($this->groups)) {
            $sql .= $this->compile->compileGroups($this->groups);
        }
        if (isset($this->havings) && is_array($this->havings)) {
            $sql .= $this->compile->compileHavings($this->havings);
        }
        if (isset($this->orders) && is_array($this->orders)) {
            $sql .= $this->compile->compileOrders($this->orders);
        }
        if (isset($this->limit)) {
            $sql .= $this->compile->compileLimit($this->limit);
        }
        if (isset($this->offset)) {
            $sql .= $this->compile->compileOffset($this->offset);
        }
        return $sql;
    }

    /**
     * Create new record
     *
     * @param array data
     *
     * @return \SupportSqlCollection
     */
    public function insert(array $data)
    {
        $sql = $this->compile->compileInsert($this->table, $data);
        return $this->request($sql);
    }

    /**
     * Create new record
     *
     * @param array data
     *
     * @return \SupportSqlCollection
     */
    public function create(array $data)
    {
        if (!empty($this->calledFromModel)) {
            $object = (new $this->calledFromModel);
            $fillable = $object->fillable() ?: [];
            $sql = $this->compile->compileCreate($this->table, $fillable, $data);
            return $this->request($sql);
        } else {
            throw new Exception("Method 'create' doesn't exists");
        }
    }

    /**
     * Find 1 record usually use column id
     *
     * @param string value
     * @param string column
     * @return \SupportSqlCollection
     */
    public function find($value, $column = 'id')
    {
        $this->find = true;
        $this->limit = 1;
        $this->where($column, '=', $value);
        $sql = $this->compile->compileSelect($this->distinct);
        $sql .= $this->compile->compileColumns($this->columns);
        $sql .= $this->compile->compileFrom($this->table);
        $sql .= $this->compile->compileWheres($this->wheres);
        return $this->request($sql);
    }

    /**
     * Find 1 record usually use column id
     *
     * @param string value
     * @param string column
     * @return \SupportSqlCollection
     */
    public function findOrFail($value, $column = 'id')
    {
        $this->find = true;
        $this->limit = 1;
        $this->isThrow = true;
        $this->where($column, '=', $value);
        $sql = $this->compile->compileSelect($this->distinct);
        $sql .= $this->compile->compileColumns($this->columns);
        $sql .= $this->compile->compileFrom($this->table);
        $sql .= $this->compile->compileWheres($this->wheres);
        return $this->request($sql);
    }

    /**
     * First 1 record usually use column id
     *
     * @param string value
     * @param string column
     * @return \SupportSqlCollection
     */
    public function first()
    {
        $this->first = true;
        $this->limit = 1;
        $sql = $this->pase();
        return $this->request($sql);
    }

    /**
     * First 1 record usually use column id
     *
     * @param string value
     * @param string column
     * @return \SupportSqlCollection
     */
    public function firstOrFail()
    {
        $this->first = true;
        $this->isThrow = true;
        $this->limit = 1;
        $sql = $this->pase();
        return $this->request($sql);
    }
    /**
     * Quick login with array params
     *
     * @param array data
     * @return \SupportSqlCollection
     */
    public function login(array $data)
    {
        $this->find = true;
        $sql = $this->compile->compileLogin($this->table, $data);
        return $this->request($sql);
    }

    /**
     * Destroy a record from condition
     *
     * @return \SupportSqlCollection
     */
    public function delete()
    {
        $sql = $this->compile->compileDelete($this->table);
        $sql .= $this->compile->compileWheres($this->wheres);
        return $this->request($sql);
    }

    /**
     * Update records from condition
     *
     * @param array data
     * @return \SupportSqlCollection
     */
    public function update(array $data)
    {
        $sql = $this->compile->compileUpdate($this->table, $data);
        $sql .= $this->compile->compileWheres($this->wheres);
        return $this->request($sql);
    }

    /**
     * Execute sql
     *
     * @param string sql
     * @return \SupportSqlCollection
     */
    public function request($sql)
    {
        try {
            $connection = $this->getConnection();
            $object = $connection->prepare($sql);
            $object->execute();
            $type = explode(" ", $sql);
            switch ($type[0]) {
                case 'SELECT':
                    return $this->inCaseSelect($object);
                case 'INSERT':
                    return $this->inCaseInsert($connection);
                case 'UPDATE':
                    return $this->find($this->wheres[0][0], $this->wheres[0][2]);
                default:
                    return $object;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function getOneItemHasModel($connection)
    {
        // $primaryKey = (new $this->calledFromModel)->primaryKey();
        $primaryKey = self::getCalledModelInstance()->primaryKey();
        return $this->find($connection->lastInsertId(), $primaryKey);
    }

    /**
     * Exec sql get column id in connection
     *
     * @param Object $connection
     *
     */
    private function sqlExecGetColumnIdInConnection($connection)
    {
        $lastInsertId = $connection->lastInsertId();
        $getConfigFromConnection = $this->connection;
        $connection = $getConfigFromConnection->getConnection();
        $databaseName = $getConfigFromConnection->config['database'];
        $newObject = $connection->prepare($this->createSqlStatementGetColumnName($databaseName));
        $newObject->execute();
        return $this->find($lastInsertId, $newObject->fetch()->COLUMN_NAME);
    }

    /**
     * Create sql statement get column name
     *
     * @param String $databaseName
     *
     */
    private function createSqlStatementGetColumnName($databaseName)
    {
        return "
            SELECT
                COLUMN_NAME
            FROM
                INFORMATION_SCHEMA.COLUMNS
            WHERE
                TABLE_SCHEMA = '{$databaseName}' AND
                TABLE_NAME = '{$this->table}' AND EXTRA = 'auto_increment'
        ";
    }

    /**
     * Handle in case insert SQL
     *
     * @param Object $connection
     *
     */
    private function inCaseInsert($connection)
    {
        if (!empty($this->calledFromModel)) {
            return $this->getOneItemHasModel($connection);
        }
        return $this->sqlExecGetColumnIdInConnection($connection);
    }

    /**
     * Handle in case select SQL
     *
     * @param Object $object
     *
     */
    private function inCaseSelect($object)
    {
        if ($this->find === true || $this->first === true) {
            if (!empty($this->calledFromModel)) {
                return $this->fetchOnlyOneItemHasModel($object);
            }
            return $object->fetch();
        }
        if (!empty($this->calledFromModel)) {
            return $this->fetchListItemsHasModel($object);
        }
        return $this->fetchOneItemWithoutModel($object);
    }

    /**
     * Fetch one item without model
     *
     * @param Object $object
     *
     */
    private function fetchOneItemWithoutModel($object)
    {
        return $object->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Fetch list items has model
     *
     * @param Object $object
     *
     */
    private function fetchListItemsHasModel($object)
    {
        return $object->fetchAll(PDO::FETCH_CLASS, $this->calledFromModel);
    }

    /**
     * Fetch one item has model
     *
     * @param Object $object
     * @throws ModelException
     *
     */
    private function fetchOnlyOneItemHasModel($object)
    {
        $resource = $object->fetchAll(PDO::FETCH_CLASS, $this->calledFromModel);
        if (is_array($resource) && count($resource) > 0) {
            return $resource[0];
        }
        if ($this->isThrow === true) {
            throw new ModelException("Resource not found", 404);
        }
        return null;
    }
    /**
     * Get instance of called model
     *
     * @param ConnectionInterface $this->bindClass
     * return self
     */
    public static function getCalledModelInstance()
    {
        $calledModel = app()->callModel;
        if (!self::$calledModelInstance) {
            self::$calledModelInstance = (new $calledModel);
        }
        return self::$calledModelInstance;
    }

    private static function calledModelInstance()
    {
        return self::getCalledModelInstance();
    }

    /**
     * Set the table which the query is targeting.
     *
     * @param  string  $table
     * @return $this
     */
    public static function table($table)
    {
        return new self($table);
    }

    /**
     * Create new query builder from model
     *
     * @param ConnectionInterface $this->bindClass
     * return self
     */
    public static function bindClass($class)
    {
        return new self((new $class)->table());
    }

    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $columns
     * @return $this
     */
    public function select($columns)
    {
        $this->columns = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    /**
     * Add a new select column to the query.
     *
     * @param  array|mixed  $column
     * @return $this
     */
    public function addSelect($column)
    {
        $column = is_array($column) ? $column : func_get_args();

        $this->columns = array_merge((array) $this->columns, $column);

        return $this;
    }

    /**
     * Force the query to only return distinct results.
     *
     * @return $this
     */
    public function distinct()
    {
        $this->distinct = true;
        return $this;
    }

    /**
     * Add a join clause to the query.
     *
     * @param  string  $table
     * @param  string  $first
     * @param  string  $operator
     * @param  string  $second
     * @param  string  $type
     * @param  bool    $where
     * @return $this
     */
    public function join($tableJoin, $st, $operator, $nd, $type = 'INNER')
    {
        $this->joins[] = [$tableJoin, $st, $operator, $nd, $type];
        return $this;
    }

    /**
     * Add a left join to the query.
     *
     * @param  string  $table
     * @param  string  $first
     * @param  string  $operator
     * @param  string  $second
     * @return \Database\QueryBuilder|static
     */
    public function leftJoin($tableJoin, $st, $operator = '=', $nd)
    {
        return $this->join($tableJoin, $st, $operator, $nd, 'LEFT');
    }

    /**
     * Add a right join to the query.
     *
     * @param  string  $table
     * @param  string  $first
     * @param  string  $operator
     * @param  string  $second
     * @return \Database\QueryBuilder|static
     */
    public function rightJoin($tableJoin, $st, $operator = '=', $nd)
    {
        return $this->join($tableJoin, $st, $operator, $nd, 'RIGHT');
    }

    /**
     * Add a basic where clause to the query.
     *
     * @param  string|array|\Closure  $column
     * @param  string  $operator
     * @param  mixed   $value
     * @param  string  $boolean
     * @return $this
     */
    public function where($column, $operator = '=', $value = null, $boolean = 'AND')
    {
        if (!is_callable($column)) {
            $this->wheres[] = [$column, $operator, $value, $boolean];
            return $this;
        }
        $this->wheres[] = ['start_where'];
        call_user_func_array($column, [$this]);
        $this->wheres[] = ['end_where'];
        return $this;
    }

    /**
     * Add an "or where" clause to the query.
     *
     * @param  string|array|\Closure  $column
     * @param  string  $operator
     * @param  mixed   $value
     * @return \Database\QueryBuilder|static
     */
    public function orWhere($column, $operator = '=', $value = null)
    {
        if (!is_callable($column)) {
            return $this->where($column, $operator, $value, 'OR');
        }
        $this->wheres[] = ['start_or'];
        call_user_func_array($column, [$this]);
        $this->wheres[] = ['end_or'];
        return $this;
        // return $this->where($column, $operator, $value, 'OR');
    }

    /**
     * Add a "where in" clause to the query.
     *
     * @param  string  $column
     * @param  mixed   $values
     * @param  string  $boolean
     * @param  bool    $not
     * @return $this
     */
    public function whereIn($column, $value = [], $is = true)
    {
        $this->wherein = [$column, !is_array($value) ? $value : implode(', ', $value), $is];
        return $this;
    }

    /**
     * Add a "where not in" clause to the query.
     *
     * @param  string  $column
     * @param  mixed   $values
     * @param  string  $boolean
     * @return \Database\QueryBuilder|static
     */
    public function whereNotIn($column, $value = [])
    {
        return $this->whereIn($column, $value, false);
    }

    /**
     * Add a "group by" clause to the query.
     *
     * @param  array  ...$groups
     * @return $this
     */
    public function groupBy($columns)
    {
        $this->groups = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    /**
     * Add a "having" clause to the query.
     *
     * @param  string  $column
     * @param  string  $operator
     * @param  string  $value
     * @param  string  $boolean
     * @return $this
     */
    public function having($column, $operator = '=', $value, $boolean = 'and')
    {
        $this->havings[] = [$column, $operator, $value, $boolean];
        return $this;
    }

    /**
     * Add a "or having" clause to the query.
     *
     * @param  string  $column
     * @param  string  $operator
     * @param  string  $value
     * @return \Database\QueryBuilder|static
     */
    public function orHaving($column, $operator = '=', $value, $boolean = 'and')
    {
        return $this->having($column, $operator, $value, 'or');
    }

    /**
     * Add an "order by" clause to the query.
     *
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($columns, $type = 'asc')
    {
        $this->orders[] = [$columns, $type];
        return $this;
    }

    /**
     * Add a descending "order by" clause to the query.
     *
     * @param  string  $column
     * @return $this
     */
    public function orderByDesc($column)
    {
        return $this->orderBy($column, 'desc');
    }

    /**
     * Add an "order by" clause for a timestamp to the query.
     *
     * @param  string  $column
     * @return \Database\QueryBuilder|static
     */
    public function latest($column = 'created_at')
    {
        return $this->orderBy($column, 'desc');
    }

    /**
     * Add an "order by" clause for a timestamp to the query.
     *
     * @param  string  $column
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function oldest($column = 'created_at')
    {
        return $this->orderBy($column, 'asc');
    }

    /**
     * Set the "limit" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Alias to set the "limit" value of the query.
     *
     * @param  int  $value
     * @return \Database\QueryBuilder|static
     */
    public function take($value)
    {
        return $this->limit($value);
    }

    /**
     * Alias to set the "offset" value of the query.
     *
     * @param  int  $value
     * @return \Database\QueryBuilder|static
     */
    public function skip($value)
    {
        return $this->offset($value);
    }

    /**
     * Set the "offset" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }
}
