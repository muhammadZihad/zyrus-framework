<?php

function app($alias = null)
{
    $instance = \Zyrus\Application\Container::getInstance();
    if (!$alias || $instance->isResolved($alias)) {
        return $instance;
    }
    return $instance->getResolved($alias);
}