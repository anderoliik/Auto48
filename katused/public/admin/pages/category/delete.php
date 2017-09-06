<?php
/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 9.03.2017
 * Time: 15:07
 */

if(!defined('MAIN_PATH')) {
    header("Location: /");
    exit();
}

$ID = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);
$btn = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

if(isset($btn) && $btn == 'delete') {
    $catID = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);

    $category = Category::find_by_ID($catID);

    if(empty($category)) {
        $session->message('<div class="alert alert-danger">Kategooria puudub</div>');
        reDirectTo(ADMIN_URL . '?page=categories');
    }

    if($category->delete()) {
        $session->message('<div class="alert alert-success">Kategoori kustutati</div>');
        reDirectTo(ADMIN_URL . '?page=categories');
    }

    $session->message('<div class="alert alert-success">Kategoorit ei kustutatud</div>');
    reDirectTo(ADMIN_URL . '?page=categories');
}

if(empty($ID)) {
    $session->message('<div class="alert alert-danger">Kategooria puudub</div>');
    reDirectTo(ADMIN_URL . '?page=categories');
}

$category = Category::find_by_ID($ID);

if(empty($category)) {
    $session->message('<div class="alert alert-danger">Kategooria puudub</div>');
    reDirectTo(ADMIN_URL . '?page=categories');
}

$parent = Category::find_parent($category->ID);

if($parent) {
    $session->message('<div class="alert alert-danger">Kustuta alamkategooriad ennem ära!</div>');
    reDirectTo(ADMIN_URL . '?page=categories');
}
?>

<h1>Kas olete kindel, et tahate kustutada?</h1>
<h3><?php echo $category->name; ?></h3>
<h3><?php echo $category->added; ?></h3>
<h3><?php echo $category->status == 1 ? 'aktiivne' : 'mitteaktiivne'; ?></h3>
<form method="post">
    <input type="hidden" name="ID" value="<?php echo $category->ID; ?>">
    <button class="btn btn-danger" type="submit" value="delete" name="action">Kinnitan kustutamise!</button>
</form>