<?php

use Lib\Config;

Config::set('site_name', 'Sistema Info');
Config::set('base_uri', '/sistema/');

Config::set('languages', [ 'pt_br', 'en_us']);

Config::set('routes', [
    'default' => '',
    'admin' => 'admin_'
]);

Config::set('default_route', 'default');
Config::set('default_language', 'pt_br');
Config::set('default_controller', 'produto');
Config::set('default_action', 'index');

//Definições do Banco de Dados
Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', 'vertrigo');
Config::set('db.name', 'mydb');