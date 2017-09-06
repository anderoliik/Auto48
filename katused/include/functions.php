<?php

function get_template($template_part) {
    $template_part_with_path = TEMPLATE_PATH . $template_part . ".php";
    if(file_exists($template_part_with_path)) {
        require_once $template_part_with_path;
    }
}

function better_crypt($input, $rounds = 10) {
    $crypt_options = array(
        'cost' => $rounds
    );
    return password_hash($input, PASSWORD_BCRYPT, $crypt_options);
}

function pd($data) {
    if(empty($data)) {
        echo "Data missing!";
        return;
    }

    if(is_array($data) || is_object($data)) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        return;
    }

    echo $data;
}

function reDirectTo($url) {

    if(empty($url)) {
        exit();
    }

    header('Location: ' . $url);
    exit();
}

function userRights($page) {
    if(empty($page)) {
        return [];
    }

    switch ($page) {
        case 'index.php':
            return ['moderator', 'admin', 'user'];
            break;

        case 'login.php':
            return ['user', 'moderator', 'admin'];
            break;

        case 'delete-product.php':
            return ['user', 'moderator', 'admin'];
            break;
    }
}

function generateHash( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);
}

function infoMessage($status, $info) {
    return '<div class="alert alert-'. $status .'">'. $info .'</div>';
}

function makePictureLink($picture) {
    //UPLOAD_PATH -> aasta -> kuu -> product_id

    $year = date("Y", strtotime($picture->added));
    $month = date("m", strtotime($picture->added));

    return UPLOAD_URL . $year . "/" . $month . "/" . $picture->product_id . "/";
}

function makePicturePath($picture) {
    //UPLOAD_PATH -> aasta -> kuu -> product_id

    $year = date("Y", strtotime($picture->added));
    $month = date("m", strtotime($picture->added));

    return UPLOAD_PATH . $year . "/" . $month . "/" . $picture->product_id . "/";
}

function deleteFolder($str = ""){
    if(is_file($str)){
        return @unlink($str) ? true : false;
    } elseif(is_dir($str)) {
        $scan = glob(rtrim($str, '/') . '/*');
        foreach ($scan as $index => $path) {
            deleteFolder($path);
        }
        return @rmdir($str) ? true : false;
    }
}

function translate($translate, $l = null) {
    global $t;

    if(!empty($l)) {

        if(file_exists(INCLUDE_PATH . "languages" . DS . $l . '.php')) {
            require_once INCLUDE_PATH . "languages" . DS . $l . '.php';
            return isset($t[$translate]) ? $t[$translate] : "[" . $translate . "]";
        }

    }

    return isset($t[$translate]) ? $t[$translate] : "[" . $translate . "]";

}

function filterArray ($array, $filter) {

    if(empty($array)) {
        return false;
    }

    foreach ($array as $key => $value) {
        $array[$key] = filter_var($value, $filter);
    }

    return $array;
}

function createCategoryArray ($categories) {
    if(empty($categories)) {
        return false;
    }

    $array = [];

    foreach ($categories as $category) {
        $array[$category->parent][] = $category;
    }

    return $array;
}

