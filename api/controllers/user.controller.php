<?php

switch ($method) {
      case 'GET':
            $data = findAll($conn, "tbl_users", $params, "");
            echo $data;
            break;
      case 'POST':
            if ($login) {
                  $user_name = trim($reqBody['user_name']);
                  $password = trim($reqBody['password']);
                  if ($user_name != '' && $password != '') {
                        findOne($conn, 'tbl_users', $reqBody, '');
                  } else {
                        echo "Please provid valid input";
                  }
            } else {
                  $userName = trim($reqBody["user_name"]);
                  $full_name = trim($reqBody["full_name"]);
                  $password = trim($reqBody["password"]);
                  $mobile = trim($reqBody["mobile"]);
                  $email = trim($reqBody["email"]);
                  $profile = trim($reqBody["base64IMG"]);
                  if ($userName != "" && $password != "" && $email != "" && $full_name != '') {
                        if ($profile != '') {
                              $file_name = handleFile("uploads/profile/", $profile);
                        } else {
                              $file_name = "profile.png";
                        }
                        $values['profile'] = $file_name;
                        $values['full_name'] = $full_name;
                        $values['user_name'] = $userName;
                        $values['password'] = $password;
                        $values['mobile'] = $mobile;
                        $values['email'] = $email;
                        $values['created_at'] = $date->format('Y-m-d H:i:s');
                        $res =  create($conn, "tbl_users", $values, "");
                        $resp = json_decode($res, true);
                        if ($resp["status"] == 200) {
                              echo $res;
                        } else {
                              removeFile("uploads/profile/", $file_name);
                        }
                  } else {
                  }
            }

            break;
      case 'UPDATE':
            $s_id = $reqBody['update_id'];
            $values = array_filter($reqBody, function ($k) {
                  return $k != 'update_id';
            }, ARRAY_FILTER_USE_KEY);
            $values['updated_at'] = $date->format('Y-m-d H:i:s');
            $data = update($conn, "tbl_users", $values, $s_id, "");
            echo $data;
            break;
      case "DELETE":
            $s_id = $reqBody["delete_id"];
            $res = delete_($conn, "tbl_users", $s_id, "");
            echo $res;
            break;

      default:
            # code...
            break;
}
