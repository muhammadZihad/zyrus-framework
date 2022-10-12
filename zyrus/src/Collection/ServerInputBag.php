<?php

namespace Zyrus\Collection;

class ServerInputBag extends InputBag {

    public function getRequestUri()
    {
        return $this->__get('REQUEST_URI');
    }
}