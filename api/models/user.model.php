<?php

class User
{
    public function getAllUsers(?string $tbl_name, ?array $params = [])
    {
        include_once('../config/connection.php');
        if (COUNT($params) > 0) {
            $where = '';
            foreach ($params as $key => $value) {
                $where = "$key='" . $value . "'";
            }
            $SQL = "SELECT * FROM $tbl_name WHERE $where";
        } else {
            $SQL = "SELECT * FROM $tbl_name";
        }
        if ($conn) {
            $res = $conn->query($SQL);
            $row = $res->num_rows;
            if ($row > 0) {
                $records = $res->fetch_all(MYSQLI_ASSOC);
                return json_encode($records);
            } else {
                return json_encode(["massage" => "No Records Found !!!"]);
            }
        }
    }
    public function createUser(?string $tbl_name, ?array $reqBody)
    {
        include_once('../config/connection.php');
        $fields = "";
        foreach ($reqBody as $key => $value) {
            $fields .= "$key='$value',";
        }
        $fields .= "created_at='" . $date->format('d-m-Y H:i:s') . "'";
        $SQL = "INSERT INTO $tbl_name SET $fields";
        if ($conn) {
            $where = "user_name ='" . $reqBody["user_name"] . "' OR mobile='" . $reqBody["mobile"] . "' OR email='" . $reqBody["email"] . "'";
            $check = "SELECT * FROM $tbl_name WHERE $where";
            $resp = $conn->query($check);
            $row = $resp->num_rows;
            if ($row > 0) {
                $data = $resp->fetch_assoc();
                if ($reqBody['user_name'] == $data['user_name']) {
                    return json_encode(["status" => "409", "massage" => "Mobile Number already taken"]);
                    die;
                } elseif ($reqBody['mobile'] == $data['mobile']) {
                    return json_encode(["status" => "409", "massage" => "User Name already taken"]);
                    die;
                } elseif ($reqBody['email'] == $data['email']) {
                    return json_encode(["status" => "409", "massage" => "Email ID already taken"]);
                    die;
                } else {
                }
            } else {
                $res = $conn->query($SQL);
                if ($res) {
                    return json_encode(["status" => "201", "massage" => "User Created", "inserted_id" => $conn->insert_id]);
                } else {
                    return json_encode(["status" => "500", "massage" => "Fail to create user"]);
                }
            }
        } else {
            return json_encode(["status" => "500", "massage" => "Fail to connect with database!!!!"]);
        }
    }
    public function deleteUser(?string $tbl_name, ?array $reqBody)
    {
        
    }
}
