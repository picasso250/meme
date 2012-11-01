<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * Description of Model
 *
 * @author ryan
 */
class Model {
    
    protected $id = null;
    protected $info = null;
    
    function __construct($para) {
        if (is_array($para) && isset($para['id'])) { // info array
            $this->id = $para['id'];
            $this->info = $para;
        } else { // id
            $this->id = $para;
        }
    }
    
    protected function selfCond() {
        return array('id=?' => $this->id);
    }
}

?>
