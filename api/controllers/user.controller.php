<?php
$data = file_get_contents("php://input");
$dataObj = json_decode($data);
$url = parse_url($_SERVER['REQUEST_URI']);

$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
    case "GET":
        $user = new User($connection, $date);
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
                $user = new User($connection, $date);
                $res = $user->createUser("tbl_users", $req_body);
                echo $res;
            } else {
                echo json_encode(["status" => "ERR_OR", "massage" => "you must have to provide either Mobile Number or Email ID"]);
            }
        } else {
            echo json_encode(["status" => "ERR_OR", "massage" => "user name and password are mandatory"]);
        }
        break;
    case "UPDATE":
        if (isset($url['query'])) {
            parse_str($url['query'], $params);
            $req_body = (array) $dataObj;
            $user = new User($connection, $date);
            $res = $user->updateUser("tbl_users", $req_body, $params['id']);
            echo $res;
        } else {
            echo json_encode(["status" => "ERR_OR", "massage" => "You have to send user id as query param"]);
        }
        break;
    case "DELETE":
        if ($dataObj->user_id != '') {
            $req_body = [
                "id" => trim($dataObj->user_id)
            ];
            $user = new User($connection, $date);
            $res = $user->deleteUser("tbl_users", $req_body);
            echo $res;
        } else {
            echo json_encode(["massage" => "In Order to Delete an User You have to send the user_id through Requeste Body"]);
        }
        break;
    default:
        echo json_encode(["status" => "ERR_OR", "massage" => "$method method is not allowed on this route"]);
}
die;
