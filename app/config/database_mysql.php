<?php

return [
    'dsn'     => "mysql:host=blu-ray.student.bth.se;dbname=heoa13;",
    'username'        => "heoa13",
    'password'        => "if890u=R",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "phpmvc_",
    'verbose' => false,
    'debug_connect' => false,
];
