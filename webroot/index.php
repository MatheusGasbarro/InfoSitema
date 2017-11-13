<?php

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(dirname(__FILE__)));
define("VIEW_PATH", ROOT . DS . 'views');

use Lib\App;

require_once ROOT . DS . 'lib' . DS . 'init.php';

session_start();

try {
    App::run();
} catch (Exception $ex) {
    echo "Erro inesperado: {$ex->getMessage()}";
}

\Lib\DB::close();


//\Lib\Session::setFlash('Hello World');

//$db = App::getDb();
//$con = $db->getConnection();
//$res = $con->query('SELECT * FROM Produto');
//while ($row = $res->fetch_assoc()) {
//    var_dump($row);
//}

// echo \Lib\Config::get('site_name');

