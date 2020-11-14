<?php

function random_string($length)
{
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

$save_path_In_folder = "file/";
if (isset($_POST['addFile'])) {
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $fileNameNew = $save_path_In_folder . "" . random_string(20) . "_" . basename($_FILES['file']['name']);
    $url = $actual_link . "/" . $fileNameNew;

    $data = move_uploaded_file($_FILES['file']['tmp_name'], $fileNameNew);
    if ($data) {
        $message = "File Uploaded";
        $result = array("success" => true, "url" => $url);
    } else {
        $message = "File Uploading Failed";
        $result = array("success" => false,);

    }
    echo json_encode(array("status" => 200, "message" => $message, "result" => $result));

}
?>