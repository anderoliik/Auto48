<?php
/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 17.03.2017
 * Time: 10:06
 */

if(!defined('MAIN_PATH')) {
    header("Location: /");
    exit();
}

$ID = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);

if(!empty($ID)) {
    $product = Product::find_by_ID($ID);

    if(empty($product)) {
        $session->message('<div class="alert alert-danger">Toode puudub</div>');
        reDirectTo(ADMIN_URL . '?page=products');
    }
}

$btn = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

if (isset($btn)) {

    $p = new Picture();
    $p->product_id = $ID;
    $p->makePictureFolders();

    if (move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_PATH_FULL . $ID . DS . $_FILES['file']['name'])) {
        $picture = new Picture();
        $picture->name = $_FILES['file']['name'];
        $picture->product_id = $ID;
        $picture->added = date("Y-m-d H:i:s");
        $picture->added_by = $_SESSION['user_id'];
        $picture->edited_by = $_SESSION['user_id'];
        $picture->status = 1;

        $picture->save();

        $picture->resizePicture();

        $session->message('<div class="alert alert-success">Pilt laeti ülesse.</div>');
        reDirectTo(ADMIN_URL . '?page=pictures&ID=' . $ID);
    }

    $session->message('<div class="alert alert-warning">Pilti ei laetud ülesse.</div>');
    reDirectTo(ADMIN_URL . '?page=pictures&ID=' . $ID);
}
?>

    <h3 class="page-header">
        <?php echo $product->name; ?><small><?php echo $pages[$page]['name'] ?></small>
    </h3>

<?php echo isset($session->message) ? $session->message : '' ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Upload Picture</label>
        <input type="file" name="file" class="form-control"><br>
        <input type="submit" name="action" value="upload" class="btn btn-success"><br>
    </form>

    <hr>

<?php $pictures = Picture::getPicturesByProduct($ID); ?>
<?php if(!empty($pictures)) : foreach ($pictures as $picture) : ?>
    <div class="col-xs-6">
        <img src="<?php echo makePictureLink($picture) . PICTURE_THUMB . '/' . $picture->name; ?>" class="img-responsive">
    </div>
<?php endforeach; endif; ?>