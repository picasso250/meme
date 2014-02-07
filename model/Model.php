<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * Description of Model
 *
 * @author ryan
 */
class Model {

    public static function orm() {
        return ORM::forTable(static::$table);
    }
}

