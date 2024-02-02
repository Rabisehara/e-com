<?php

switch ($method) {
    case "GET":
        $data = findAll($conn, "tbl_products", $params, "");
        echo $data;
        break;
}
