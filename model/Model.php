<?php
/**
 * Created by PhpStorm.
 * User: xiaochi.wang
 * Date: 2017/2/7
 * Time: 12:49
 */

namespace model;

use PDO;

class Model
{
    /**
     * @var \PDO
     */
    static $db;

    static $logging = false;
    private static $log = [];

    public function __construct($info, $id = null)
    {
        if ($info) {
            if (is_numeric($info)) {
                $info = self::getById($info);
            }
            foreach ($info as $k => $v) {
                $this->$k = $v;
            }
        }
    }

    public static function timestamp($t = null)
    {
        $format = 'Y-m-d H:i:s';
        if ($t === null) {
            $t = time();
        }
        return date($format, $t);
    }
    public static function getById($id)
    {
        $table = static::$table;
        $db = self::$db;
        // $stmt = $db->prepare("SELECT * FROM `$table` where id=? limit 1");
        // $stmt->execute(array($id));
        list($stmt, $rs) = self::execute("SELECT * FROM `$table` where id=? limit 1", [$id]);
        return new static($stmt->fetch(pdo::FETCH_ASSOC));
    }
    public static function findOne($where)
    {
        $a = self::find($where, 1);
        if ($a) {
            return $a[0];
        }
        return false;
    }
    public static function find($where = array(), $n = 1000)
    {
        $table = static::$table;
        $db = self::$db;
        $ws = " ";
        if ($where) {
            foreach ($where as $key => $value) {
                $s[] = "`$key`=:$key";
            }
            $ws = " WHERE " . implode(' AND ', $s);
        }
        // list($stmt, $rs) = self::execute("SELECT * FROM `$table` $ws LIMIT $n", $where);
        return self::fetchAll("SELECT * FROM `$table` $ws LIMIT $n", $where);
    }
    public static function fetchAll($sql, $where = [])
    {
        list($stmt, $rs) = self::execute($sql, $where);
        return $stmt->fetchAll(pdo::FETCH_OBJ);
    }
    public static function insert($kvs)
    {
        $table = static::$table;
        $db = self::$db;
        if (empty($kvs)) {
            die("no kvs to insert $table");
        }
        foreach ($kvs as $key => $value) {
            $s[] = "`$key`";
            $t[] = ":$key";
        }
        $keys = implode(',', $s);
        $vals = implode(',', $t);
        // $stmt = $db->prepare("INSERT `$table` ($keys) VALUES ($vals)");
        // $stmt->execute($kvs);
        list($stmt, $rs) = self::execute("INSERT `$table` ($keys) VALUES ($vals)", $kvs);
        return $db->lastInsertId();
    }
    public static function updateById($kvs, $id)
    {
        $table = static::$table;
        $db = self::$db;
        if (empty($kvs)) {
            die("no kvs to update $table by id($id)");
        }
        foreach ($kvs as $key => $value) {
            $s[] = "`$key`=:$key";
        }
        $kvs['id'] = $id;
        $sets = implode(',', $s);
        // $stmt = $db->prepare("UPDATE `$table` set $sets where id=:id");
        // $stmt->execute($kvs);
        list($stmt, $rs) = self::execute("UPDATE `$table` set $sets where id=:id", $kvs);
        return $db->lastInsertId();
    }
    public static function update($kvs, $where = array())
    {
        if (empty($kvs)) {
            die("no kvs to update");
        }
        $table = static::$table;
        $db = self::$db;
        $ws = " ";
        if ($where) {
            foreach ($where as $key => $value) {
                $s[] = "`$key`=:$key";
            }
            $ws = " WHERE " . implode(' AND ', $s);
        }
        $s = array();
        foreach ($kvs as $key => $value) {
            $s[] = "`$key`=:$key";
        }
        $sets = implode(',', $s);
        $sql = "UPDATE `$table` SET $sets $ws";
        // $stmt = $db->prepare($sql);
        // $stmt->execute(array_merge($kvs, $where));
        list($stmt, $rs) = self::execute($sql, array_merge($kvs, $where));
        return $stmt->rowCount();
    }
    public static function execute($sql, $kvs)
    {
        self::$log[] = self::prettyLog($sql, $kvs);
        $db = self::$db;
        $stmt = $db->prepare($sql);
        return [$stmt, $stmt->execute($kvs)];
    }
    private static function prettyLog($sql, $kvs)
    {
        if (strpos($sql, "?") !== false && is_numeric(key($kvs))) {
            $sql = str_replace("?", "'%s'", $sql);
            return call_user_func_array('sprintf', array_merge([$sql], $kvs));
        } else {
            return preg_replace_callback('/:(\w+)/', function ($m) use ($kvs) {
                $key = $m[1];
                return "'$kvs[$key]'";
            }, $sql);
        }
    }
    public static function getLog()
    {
        return self::$log;
    }
    public static function findByIds($ids)
    {
        $ids = array_unique($ids);
        $n = count($ids);
        $idss = implode(',', $ids);
        $table = static::$table;
        $a = User::fetchAll("SELECT * from `$table` where id in($idss) limit $n");
        $t = [];
        foreach ($a as $e) {
            $t[$e->id] = $e;
        }
        return $t;
    }

}
