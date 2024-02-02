<?php

function handleFile($path, $profile)
{
    $file = base64_decode(explode(',', $profile)[1]);
    $fxt = explode("/", explode(";", explode(',', $profile)[0])[0])[1];
    $file_name = time() . '.' . $fxt;
    file_put_contents($path . $file_name, $file);
    return $file_name;
}

function removeFile($path, $name){
    unlink($path . $name);
}
