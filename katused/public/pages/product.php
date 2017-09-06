<?php
/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 17.03.2017
 * Time: 9:52
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

$pictures = Picture::getPicturesByProduct($product->ID);
$translates = ProductLanguage::findByProductId($product->ID, LANG);

if(!empty($translates)) {
    $translations = (object) array_column($translates, 'column_value', 'table_column');
} else {
    $translations = null;
}

?>
<h3 class="page-header text-right"><?php echo $pages[$page]['name'] ?></h3>

<h1 class="page-header"><?php echo ProductLanguage::translate('name', $product, $translations) ?> <small><?php echo $product->price; ?>€</small></h1>

<ul>
    <li><?php echo Category::find_by_ID($product->category_id)->name; ?></li>
    <li><?php echo $product->description; ?></li>
    <li><?php echo date("d.m.Y", strtotime($product->added)); ?></li>
    <li><?php echo User::find_by_ID($product->added_by)->username; ?></li>
</ul>

<?php if (!empty($pictures)) : foreach ($pictures as $key => $pic) : ?>
    <?php echo $key % 3 == 0 ? '<div class="clearfix"></div><br>' : '' ?>
    <div class="col-xs-4">
        <img src="<?php echo makePictureLink($pic) . DS . PICTURE_THUMB . DS . $pic->name; ?>" class="img-responsive">
    </div>
<?php endforeach; endif; ?>