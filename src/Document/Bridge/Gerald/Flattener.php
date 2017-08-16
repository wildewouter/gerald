<?php

namespace Document\Bridge\Gerald;

final class Flattener
{
    public static function flatten(array &$list, array $subnode = null, $path = null)
    {
        if (null === $subnode) {
            $subnode = &$list;
        }
        foreach ($subnode as $key => $value) {
            if (is_array($value)) {
                $nodePath = $path ? $path.'.'.$key : $key;
                self::flatten($list, $value, $nodePath);
                if (null === $path) {
                    unset($list[$key]);
                }
            } elseif (null !== $path) {
                $list[$path.'.'.$key] = $value;
            }
        }
    }
}
