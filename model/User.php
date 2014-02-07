<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');

require_once Pf::model('Model');
require_once Pf::model('Topic');
require_once Pf::model('OpenAccount');

/**
 *
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class User extends Model {

    public static $table = 'user';
    
    public static function create() {
        
        // create user
        Pdb::insert(array(
            'create_time=NOW()' => null,
        ), self::$table);

        $user_id = Pdb::lastInsertId();
        return new self($user_id);
    }
    
    public function attachOpenAccount(OpenAccount $oa) {
        $oa->attachTo($this->id);
    }
    
    public function login() {
        $_SESSION['se_user_id'] = $this->id;
    }
    
    public function logout() {
        $_SESSION['se_user_id'] = 0;
    }
    
    public function setName($name) {
        $arr = array('name' => $name);
        Pdb::update($arr, self::$table, $this->selfCond());
    }
    
    public function info() {
        if (!empty($this->info)) return $this->info;
        $this->info = Pdb::fetchRow('*', self::$table, $this->selfCond());
        return $this->info;
    }

    public static function listU($conds=array()) {
        extract(self::defaultConds($conds));
        $orders = 'id DESC';
        $tail = "LIMIT $limit OFFSET $offset";
        return array_map(function ($info) {
            return new Message($info);
        }, Pdb::fetchAll('*', self::$table, array(), $orders, $tail));
    }
    
    public static function count() {
        return self::orm()->count();
    }

    private static function defaultConds($conds) {
        return array_merge(array(
            'limit' => 10,
            'offset' => 0,
        ), $conds);
    }

    public function __get($name) {
        if ($name == 'id') return $this->id;
        if (empty($this->info)) {
            $this->info = $this->info();
        }
        return $this->info[$name];
    }
    
    public function startTopic($title, $text) {
        return Topic::startBy($this->id, $title, $text);
    }
    
    public function forkTopic(Topic $topic) {
        return $topic->forkBy($this->id);
    }
    
    public function editTopic(Topic $topic,  $old_node_id, $text, $action) {
        $topic->editBy($this->id, $old_node_id, $text, $action);
    }
}

