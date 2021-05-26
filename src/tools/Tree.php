<?php
/**
 * 目录树
 */

namespace tools;
class Tree
{
    /**
     * 分类目录树 - 父子目录树
     * @param array $data
     * @param int $pid
     * @return array
     */
    public static function getCategorySubTree(array $data = [], int $pid = 0): array
    {
        $tree = [];
        foreach ($data as $k => $v) {
            if ($v["pid"] == $pid) {
                unset($data[$k]);
                if (!empty($data)) {
                    $children = self::getCategorySubTree($data, $v["id"]);
                    if (!empty($children)) {
                        $v["_child"] = $children;
                    }
                }
                $tree[] = $v;
            }
        }
        return $tree;
    }

    /**
     * 分类目录树 - 顺序
     * @param $data
     * @param int $pid
     * @return array
     */
    public static function getCategoryOrderTree(array $data = [], int $pid = 0): array
    {
        static $tree = [];
        foreach ($data as $v) {
            if ($v['pid'] == $pid) {
                $tree[] = $v;
                self::getCategoryOrderTree($data, $v['id']);
            }
        }
        return $tree;
    }

    /**
     * 分类目录树 - 子找父
     * @param $data
     * @param $id
     * @return array
     */
    public static function getCategoryInvertedTree(array $data, int $id): array
    {
        static $tree = [];
        foreach ($data as $k => $v) {
            if ($v["id"] == $id) {
                self::getCategoryInvertedTree($data, $v["pid"]);
                $tree[] = $v;
            }
        }
        return $tree;
    }

    /**
     * 获取当前分类下的所有分类id
     * @param $data
     * @param int $pid
     * @return array
     */
    public static function getChildIdByPid($data, $pid = 0)
    {
        static $ids = [];
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                $ids[] = $v['id'];
                unset($data[$k]);
                if (!empty($data)) {
                    self::getChildIdByPid($data, $v['id']);
                }
            }
        }
        return $ids;
    }
}