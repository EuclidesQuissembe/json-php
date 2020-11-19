<?php


namespace Source\Core;

use Source\Core\Connect;
use Source\Support\Message;

/**
 * JSON-PHP | Class Model | Layer Super Type
 *
 * @author Euclides Bernardo <euclidesquissembebernado@gmail.com>
 * @package Source\Core
 */
abstract class Model
{

    /** @var string $table */
    private $table;

    /** @var array $required */
    private $required;

    /** @var array $protected */
    private $protected;

    /** @var $join */
    protected $join;

    /** @var $where */
    protected $where;

    /** @var $stantment */
    protected $stantment;

    /** @var $params */
    protected $params;

    /** @var $order */
    protected $order;

    /** @var $group */
    protected $group;

    /** @var $limit */
    protected $limit;

    /** @var $offset */
    protected $offset;

    /** @var $data */
    protected $data;

    /** @var $fail */
    protected $fail;

    /** @var $message */
    protected $message;


    /**
     * @param $name
     * @return |null
     */
    public function __get($name)
    {
        if (!empty($this->data)) {
            return $this->data->$name;
        }
        return null;
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new \stdClass();
        }

        return $this->data->$name = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    /**
     * Model constructor.
     * @param string $table
     * @param array $protected
     * @param array $required
     */
    public function __construct(string $table, array $protected, array $required)
    {
        $this->table = $table;
        $this->protected = array_merge($protected, ["created_at", "updated_at"]);
        $this->required = $required;

        $this->message = new Message();
    }

    /**
     * @return mixed
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function fail()
    {
        return $this->fail;
    }

    /**
     * @return mixed
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * @param string|null $terms
     * @param string|null $params
     * @param string|null $columns
     * @return $this
     */
    public function find(?string $terms = null, ?string $params = null, ?string $columns = "*"): Model
    {
        if ($terms) {
            $this->stantment = "SELECT {$columns} FROM {$this->table} WHERE {$terms}";
            parse_str($params, $this->params);
            return $this;
        }

        $this->stantment = "SELECT {$columns} FROM {$this->table}";
        return $this;
    }

    /**
     * @param int $id
     * @param string $columns
     * @return Model|null
     */
    public function findById(int $id, string $columns = '*'): ?Model
    {
        return $this->find("id = :id", "id={$id}", $columns)->fetch();
    }

    /**
     * @param string $columns
     * @return Model
     */
    public function select(string $columns = '*'): Model
    {
        $this->stantment = "SELECT {$columns} FROM {$this->table}";
        return $this;
    }

    /**
     * @param string $params
     * @return Model
     */
    public function join(string $params): Model
    {
        $this->join .= " INNER JOIN {$params}";
        return $this;
    }

    /**
     * @param string $params
     * @return Model
     */
    public function leftJoin(string $params): Model
    {
        $this->join .= " LEFT JOIN {$params}";
        return $this;
    }

    /**
     * @param string $params
     * @return Model
     */
    public function rightJoin(string $params): Model
    {
        $this->join .= " RIGHT JOIN {$params}";
        return $this;
    }


    /**
     * @param string $terms
     * @param string $params
     * @return Model
     */
    public function where(string $terms, string $params): Model
    {
        $this->where = " WHERE {$terms}";
        parse_str($params, $this->params);
        return $this;
    }


    /**
     * @param string $columnOrder
     * @return Model
     */
    public function order(string $columnOrder): Model
    {
        $this->order .= " ORDER BY {$columnOrder}";
        return $this;
    }

    /**
     * @param string $columnGroup
     * @return Model
     */
    public function group(string $columnGroup): Model
    {
        $this->group = " GROUP BY {$columnGroup}";
        return $this;
    }

    /**
     * @param int $limit
     * @return Model
     */
    public function limit(int $limit): Model
    {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }

    /**
     * @param int $offset
     * @return Model
     */
    public function offset(int $offset): Model
    {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }

    /**
     * @param bool $all
     * @return array|mixed|null|Model
     */
    public function fetch(bool $all = false)
    {
        try {
            $stmt = Connect::getInstance()->prepare(
                $this->stantment.$this->join.$this->where.$this->group.$this->order.$this->limit.$this->offset
            );
            $stmt->execute($this->params);

            if (!$stmt->rowCount()) {
                return null;
            }

            if ($all) {
                return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
            }

            return $stmt->fetchObject(static::class);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $stmt = Connect::getInstance()->prepare(
            $this->stantment.$this->join.$this->where.$this->group.$this->order.$this->limit.$this->offset
        );
        $stmt->execute($this->params);

        return $stmt->rowCount();
    }

    /**
     * @param array $data
     * @return int|null
     */
    public function create(array $data): ?int
    {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            $stmt = Connect::getInstance()->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$values})");
            $stmt->execute(static::filter($data));
            return (Connect::getInstance()->lastInsertId() ?? 1);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param array $data
     * @param string $terms
     * @param string $params
     * @return int|null
     */
    public function update(array $data, string $terms, string $params): ?int
    {
        try {
            $dataSet = [];
            foreach ($data as $bind => $value) {
                $dataSet[] = "{$bind} = :{$bind}";
            }
            $dataSet = implode(", ", $dataSet);
            parse_str($params, $params);
            $stmt = Connect::getInstance()->prepare("UPDATE {$this->table} SET {$dataSet} WHERE {$terms}");
            $stmt->execute(array_merge($params, static::filter($data)));
            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function delete(string $key, string $value): bool
    {
        try {
            $stmt = Connect::getInstance()->prepare("DELETE FROM {$this->table} WHERE {$key} = :key");
            $stmt->bindValue("key", $value, \PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (\PDOException $exception) {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function destroy(): bool
    {
        return $this->delete('id', $this->id);
    }

    /**
     * Method to save data
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->message->info("Preencha todos os campos");
            return false;
        }

        /** Update */
        if (!empty($this->id)) {
            $id = $this->id;
            $this->update($this->safe(), "id = :id", "id={$id}");
            if ($this->fail()) {
                $this->message->error("Houve um erro ao atualizar, por favor verifique os dados");
                return false;
            }
        }



        /** Create */
        if (empty($this->id)) {
            $id = $this->create($this->safe());

            if ($this->fail()) {
//                $this->message->error("Houve um erro ao cadastrar, por favor verifique os dados");
                $this->message->error($this->fail());
                return false;
            }
        }

        $this->data = $this->findById($id)->data;
        return true;
    }

    /**
     * @return array
     */
    protected function safe(): array
    {
        $safe = (array)$this->data;
        foreach ($this->protected as $unset) {
            unset($safe[$unset]);
        }
        return $safe;
    }

    /**
     * @return bool
     */
    protected function required(): bool
    {
        foreach ($this->required as $field) {
            if (empty($this->data()->$field)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Method to filter the data that will be stored.
     * @param array $data
     * @return mixed
     */
    public static function filter(array $data): array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (!is_null($value) ? filter_var($value, FILTER_SANITIZE_STRIPPED) : null);
        }
        return $filter;
    }
}
