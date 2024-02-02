<?php
header("Access-control-Allow-Origin:*");
header("Access-control-Allow-Methods:POST,GET,UPDATE,DELETE");
header("Access-control-Allow-Headers:Content-Type");

// print_r($_SERVER);
include_once "./models/query.php";
include_once "./config/connection.php";
include_once "./helper/handleFile.php";
$url = $_SERVER["REDIRECT_URL"];
$uri = str_replace('index.php', '', $_SERVER['PHP_SELF']);
$base = rtrim($uri, '/');
$path = str_replace($base, "", $url);
$json = file_get_contents("php://input");
$reqBody = json_decode($json, true);
$method = $_SERVER['REQUEST_METHOD'];
$url = $_SERVER['QUERY_STRING'];
$qry = explode('@', $url);
$params = [];
if ($qry[0] != '') {
      foreach ($qry as $key => $value) {
            $kyval = explode('=', $value);
            $params[$kyval[0]] = $kyval[1];
      }
}

$login = false;
switch ($path) {
      case '/':
            echo "ok";
            break;
      case '/user':
            if (in_array($method, ["GET", "POST", "UPDATE", "DELETE"])) {
                  include "./controllers/user.controller.php";
            } else {
                  echo json_encode(["massage" => "$method Method is not allowed on this route"]);
            }
            break;
      case '/user/login':
            if ($method == "POST") {
                  $login = true;
                  include "./controllers/user.controller.php";
            } else {
                  echo json_encode(["massage" => "$method Method is not allowed on this route"]);
            }
            break;
      case "product":
            if (in_array($method, ["GET", "POST", "UPDATE", "DELETE"])) {
                  include "./controllers/product.controller.php";
            } else {
                  echo json_encode(["massage" => "$method Method is not allowed on this route"]);
            }
            break;

      default:

            break;
}
