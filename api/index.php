<?php

$url = parse_url($_SERVER['REQUEST_URI']);
$path =  str_replace("/Rabilal/PROJECT/e-com/api", "", $_SERVER['REQUEST_URI']);

switch ($path) {
    case '/':
        echo "ok";
        break;
    case '/user':
        include('./config/connection.php');
        include('./models/user.model.php');
        include("./controllers/user.controller.php");
        break;

    default:
        echo "<h2>404</h2>";
        break;
}
