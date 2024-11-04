<?php

namespace Vendor\Esmefis;

class GetEnv{

    public static function cargar(){
        $dotEnv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotEnv->load();
    }

}

?>