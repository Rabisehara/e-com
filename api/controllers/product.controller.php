<?php

switch ($method) {
    case "GET":
        // $cSql = "SELECT * FROM tbl_products "
        $data = findAll($conn, "tbl_products", $params, "");
        $i = 0;
        foreach ($data as $d) {
            $catId = $d['product_category'];
            $cSql = "SELECT * FROM tbl_colors WHERE id IN (" . $d['product_color'] . ")";
            $cat = findAll($conn, "tbl_category", ['id' => $d['product_category']], "");
            $colors = findAll($conn, "", $params, $cSql);
            $data[$i]['product_color'] = $colors;
            $data[$i]['product_category'] = $cat;
            $i++;
        }
        echo json_encode($data);
        break;
    case 'POST':
        break;
}
