<?php
function setValues($value)
{
     $values = '';
     foreach ($value as $key => $val) {
          $values .= $key . "='" . $val . "',";
     }
     return rtrim($values, ',');
}
function findAll($conn, ?string $tbl_name = "", ?array $where = [], ?string $sql = "")
{
     $whercl = '';
     if ($sql == '') {
          if (COUNT($where) > 0) {
               foreach ($where as $k => $v) {
                    $whercl .= "$k = '$v' and ";
               }
               $wherclf = rtrim($whercl, " and");
               $sql = "SELECT * FROM $tbl_name WHERE $wherclf";
          } else {
               $sql = "SELECT * FROM $tbl_name";
          }
     } else {
          if (COUNT($where) > 0) {
               foreach ($where as $k => $v) {
                    $whercl .= "$k = '$v' and ";
               }
               $wherclf = rtrim($whercl, " and");
               $sql . "WHERE $wherclf";
          }
     }
     $res = $conn->query($sql);
     $data = $res->fetch_all(MYSQLI_ASSOC);
     // print_r($_SERVER);
     return $data;
}
function findOne($conn, ?string $tbl_name = "", ?array $reqBody = [], ?string $sql = "")
{
     if ($sql == '') {
          if (COUNT($reqBody) > 0) {
               $whercl = '';
               foreach ($reqBody as $k => $v) {
                    $whercl .= "$k = '$v' and ";
               }
               $wherclf = rtrim($whercl, " and");
               $sql = "SELECT * FROM $tbl_name WHERE $wherclf";
          } else {
               $sql = "SELECT * FROM $tbl_name";
          }
     }
     $res = $conn->query($sql);
     $rows = $res->num_rows;
     if ($rows > 0) {
          $data = $res->fetch_all(MYSQLI_ASSOC);
          return $data;
     } else {
          return ["error" => "not found!!"];
     }
}
function create($conn, ?string $tbl_name = "", ?array $reqBody = [], ?string $sql = "")
{

     if (COUNT($reqBody) > 0) {
          $values = setValues($reqBody);
     } else {
          $values = '';
     }
     $sql = "INSERT INTO $tbl_name SET $values";
     $res = $conn->query($sql);
     if ($res) {
          return ['status' => 200, 'inserted_id' => mysqli_insert_id($conn)];
     } else {
          return ['status' => 500, 'massage' => "something went wrong"];
     }
}
function delete_($conn, ?string $tbl_name = "", $id = '', ?string $sql = "")
{
     $sql = "DELETE FROM $tbl_name WHERE id=$id";
     $res = $conn->query($sql);
     if ($res) {
          return ["status" => 200, ""];
     } else {
          return ["status" => 500, "" => ""];
     }
}
function update($conn, ?string $tbl_name = "", ?array $reqBody = [], $id = '', ?string $sql = "")
{
     if (COUNT($reqBody) > 0) {
          $values = setValues($reqBody);
     } else {
          $values = "";
     }
     $sql = "UPDATE $tbl_name SET $values WHERE id =$id";
     // return json_encode(["body"=>$reqBody , "sql"=>$sql]);
     $res = $conn->query($sql);
     if ($res) {
          return ["status" => 200];
     } else {
          return ["status" => 500, "massage" => "something went wrong"];
     }
}
