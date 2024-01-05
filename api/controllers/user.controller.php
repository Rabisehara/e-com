<?php
include_once('../models/user.model.php');
$data = file_get_contents("php://input");
$dataObj = json_decode($data);


$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
    case "GET":
        $url = parse_url($_SERVER['REQUEST_URI']);
        $user = new User();
        if (isset($url['query'])) {
            parse_str($url['query'], $params);
            $res = $user->getAllUsers("tbl_users", $params);
        } else {
            $res = $user->getAllUsers("tbl_users");
        }

        echo $res;
        break;
    case "POST":
        if ($dataObj->user_name != '' && $dataObj->password != '') {
            if ($dataObj->mobile != "" || $dataObj->email != "") {
                $req_body = [
                    "user_name" => trim($dataObj->user_name),
                    "password" => trim($dataObj->password),
                    "mobile" => trim($dataObj->mobile),
                    "email" => trim($dataObj->email),
                ];
                $user = new User();
                $res = $user->createUser("tbl_users", $req_body);
                echo $res;
            } else {
                echo json_encode(["status" => "ERR_OR", "massage" => "you must have to provide either Mobile Number or Email ID"]);
            }
        } else {
            echo json_encode(["status" => "ERR_OR", "massage" => "user name and password are mandatory"]);
        }
        break;
    case "PUT":
        echo json_encode(["status" => "Success", "massage" => "$method is allowed on this route"]);
        break;
    case "DELETE":
        if ($dataObj->user_id != '') {
            $req_body = [
                "id" => trim($dataObj->user_id)
            ];
        }else{
            
        }
        break;
    default:
        echo json_encode(["status" => "ERR_OR", "massage" => "$method is not allowed on this route"]);
}
die;
