<?php
namespace model;
/**
 * Description of OpenAccount
 *
 * @author ryan
 */
class OpenAccount extends Model {
    public static $table = 'open_account';
    
    public static function find($platform, $openid) {
        $conds = array(
            'platform=?' => $platform,
            'openid=?' => $openid,
        );
        $info = Pdb::fetchRow('id', self::$table, $conds);
        if ($info !== FALSE) {
            return new self($info['id']);
        } else {
            return false;
        }
    }

    public static function create($platform, $openid) {
        Pdb::insert(array(
            'platform' => $platform,
            'openid' => $openid,
        ), self::$table);
        return new self(Pdb::lastInsertId());
    }
    
    public function attachTo($user_id) {
        Pdb::update(array('user' => $user_id), self::$table, $this->selfCond());
    }
    
    public function getUser() {
        if (empty($this->info)) $this->info = $this->getInfo();
        return new User($this->info['user']);
    }
    
    private function getInfo() {
        if ($this->info) return $this->info;
        return Pdb::fetchRow('*', self::$table, $this->selfCond());
    }
}

?>
