<?php

namespace model;

/**
 * Description of Topic
 *
 * @author ryan
 */
class Topic extends Model
{

    public static $table = 'topic';

    public static function startBy($user_id, $title, $text)
    {

        // insert
        $id = self::insert([
            'editor' => $user_id,
            'title' => $title,
            'text' => $text,
        ]);
        return new self(self::getById($id));
    }

    public static function text2arr($text)
    {

        // array_values 是为了重新整理一下序号
        $arr = array_values(array_filter(array_map(function ($v) {
            return trim($v);
        }, explode(PHP_EOL, $text)), function ($v) {
            return !empty($v);
        }));

        if (empty($arr)) {
            throw new Exception('empty nodes');
        }
        return $arr;
    }

    public static function read($conds = array())
    {
        extract(self::defaultConds($conds));
        $tail = "LIMIT $limit OFFSET $offset";
        $topics = self::orm()
            ->orderByDesc('time')
            ->limit($limit)
            ->offset($offset)
            ->findMany();
        return array_map(function ($info) {
            $nodes = json_decode($info['nodes']);
            if (empty($nodes)) {
                d($info);
                throw new Exception('empty nodes');
            }
            $info['nodes'] = array_map(function ($id) {
                return new Node($id);
            }, $nodes);
            $info['editor'] = new User($info['editor']);
            return new Topic($info);
        }, $topics);
    }

    private static function defaultConds($conds)
    {
        return array_merge(array(
            'limit' => 10,
            'offset' => 0,
        ), $conds);
    }

    public static function count()
    {
        return self::orm()->count();
    }

    public function __get($name)
    {
        if ($name == 'id') {
            return $this->id;
        }

        if (empty($this->info)) {
            $this->info = $this->info();
        }
        return $this->info[$name];
    }

    public function info()
    {
        $info = Pdb::fetchRow('*', self::$table, $this->selfCond());
        $info['nodes'] = array_map(function ($id) {
            return new Node($id);
        }, json_decode($info['nodes']));
        $info['editor'] = new User($info['editor']);
        return $info;
    }

    public function forkBy($user_id)
    {

        if (empty($this->info)) {
            $this->info = $this->info();
        }

        // 叶子节点 , 如同一作者，则上一版本消隐
        if ($this->info['editor']->id == $user_id) {
            Pdb::update(array('is_leaf' => 0), self::$table, $this->selfCond());
        }

        $this->info['nodes'] = array_map(function ($node) {
            if (is_object($node)) {
                return $node->id;
            }
            return $node;
        }, $this->info['nodes']);
        Pdb::insert(array(
            'editor' => $user_id,
            'title' => $this->info['title'],
            'nodes' => json_encode($this->info['nodes']),
            'origin' => $this->id,
            'time=NOW()' => null,
        ), self::$table);

        return new self(Pdb::lastInsertId());
    }

    public function editBy($user_id, $old_node, $text, $action = 'replace')
    {

        $arr = array_map(function ($text) use ($user_id) {
            return Node::createBy($user_id, $text);
        }, self::text2arr($text));
        if (empty($this->info)) {
            $this->info = $this->info();
        }

        $nodes = array_map(function ($node) {return $node->id;}, $this->info['nodes']);
        if (empty($nodes)) {
            throw new Exception('old nodes empty');
        }
        $offset = array_search($old_node, $nodes); // what if we can not find?

        //  need array_keys() ?
        $acmap = array(
            'edit' => 1, 'replace' => 1,
            'after' => 0,
        );
        if ($action == 'after') {
            $offset++;
        }

        array_splice($nodes, $offset, $acmap[$action], array_map(function ($node) {
            return $node->id;
        }, $arr));
        $this->info['nodes'] = $nodes;
    }

    public function delNode($node_id)
    {
        if (empty($this->info)) {
            $this->info = $this->info();
        }

        $nodes = array_map(function ($node) {return $node->id;}, $this->info['nodes']);
        $offset = array_search($node_id, $nodes);
        unset($nodes[$offset]);
        $nodes = array_values($nodes);
        if (empty($nodes)) {
            return;
        }

        $this->info['nodes'] = $nodes;
    }

    public function setTitle($title)
    {
        if (empty($this->info)) {
            $this->info = $this->info();
        }

        $this->info['title'] = $title;
    }
}
