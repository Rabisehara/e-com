<?php

class User
{
    protected $conn;
    public $date;

    function __construct()
    {
        include_once('../config/connection.php');
        $this->conn = $connection;
        $this->date = $date;
    }

    public function getAllUsers(?string $tbl_name, ?array $params = [])
    {

        if (COUNT($params) > 0) {
            $where = '';
            foreach ($params as $key => $value) {
                $where = "$key='" . $value . "'";
            }
            $SQL = "SELECT * FROM $tbl_name WHERE $where";
        } else {
            $SQL = "SELECT * FROM $tbl_name";
        }
        if ($this->conn) {
            $res = $this->conn->query($SQL);
            $row = $res->num_rows;
            if ($row > 0) {
                $records = $res->fetch_all(MYSQLI_ASSOC);
                return json_encode(["status" => 200, "data" => $records]);
            } else {
                return json_encode(["massage" => "No Records Found !!!"]);
            }
        }
    }
    public function createUser(?string $tbl_name, ?array $reqBody)
    {
        $fields = "";
        foreach ($reqBody as $key => $value) {
            $fields .= "$key='$value',";
        }
        $fields .= "created_at='" . $this->date->format('d-m-Y H:i:s') . "'";
        $SQL = "INSERT INTO $tbl_name SET $fields";
        if ($this->conn) {
            $where = "user_name ='" . $reqBody["user_name"] . "' OR mobile='" . $reqBody["mobile"] . "' OR email='" . $reqBody["email"] . "'";
            $check = "SELECT * FROM $tbl_name WHERE $where";
            $resp = $this->conn->query($check);
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
                $res = $this->conn->query($SQL);
                if ($res) {
                    return json_encode(["status" => "201", "massage" => "User Created", "inserted_id" => $this->conn->insert_id]);
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
        $where = '';
        foreach ($reqBody as $key => $value) {
            $where .= "$key = $value";
        }

        $SQL = "DELETE FROM $tbl_name WHERE $where";
        $res = $this->conn->query($SQL);
        if ($res) {
            return json_encode(["status" => 200, "massage" => "User Deleted Successfully !!!"]);
        } else {
            return json_encode(["status" => 500, "massage" => "Something went wrong"]);
        }
    }
    public function updateUser(?string $tbl_name, ?array $reqBody, ?int $id)
    {
        $set = '';
        foreach ($reqBody as $key => $value) {
            $set .= "$key ='" . $value . "',";
        }
        $set .= "updated_at = '" . $this->date->format('d-m-Y H:i:s') . "'";
        $SQL = "UPDATE $tbl_name SET $set WHERE id = $id";
        $res = $this->conn->query($SQL);
        if ($res) {
            $rtnRes = $this->conn->query("SELECT * FROM $tbl_name WHERE id = $id");
            $updatedUser = $rtnRes->fetch_assoc();
            return json_encode(["status" => 200, "data" => $updatedUser]);
        } else {
            return json_encode(["status" => 500, "massage" => "something went wrong"]);
        }
    }
}
