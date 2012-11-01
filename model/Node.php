<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');

include_once Pf::model('Model');

/**
 * Description of Node
 *
 * @author ryan
 */
class Node extends Model {
    
    public static $table = 'node';
    
    public function info() {
        if ($this->info) return $this->info;
        $info = Pdb::fetchRow('*', self::$table, $this->selfCond());
        $info['user'] = new User($info['user']);
        return $info;
    }
    
    public static function createBy($user_id, $text) {
        $info = array(
            'user' => $user_id,
            'text' => $text);
        Pdb::insert(array_merge($info, array('time=NOW()' => NULL)), self::$table);
        $info['id'] = Pdb::lastInsertId();
        return new self($info);
    }
    
    public function __get($name) {
        if ($name == 'id') return $this->id;
        if (empty($this->info)) {
            $this->info = $this->info();
        }
        return $this->info[$name];
    }
}

?>
