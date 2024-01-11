<?php
$data = file_get_contents("php://input");
$dataObj = json_decode($data, true);
$imgStr = $dataObj['URL'];
$img = explode('base64,', $imgStr);
$fdata = base64_decode($img[1]);

$extension = explode('/', mime_content_type($imgStr))[1];
file_put_contents('images/img_1.' . $extension, $fdata);
