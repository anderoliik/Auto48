<?php
/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 9.03.2017
 * Time: 13:44
 */

if(!defined('MAIN_PATH')) {
    header("Location: /");
    exit();
}

$ID = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);
if(!empty($ID)) {
    $product = Product::find_by_ID($ID);

    if(empty($product)) {
        $session->message('<div class="alert alert-danger">Produkt puudub</div>');
        reDirectTo(ADMIN_URL . '?page=product');
    }
}

$btn = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$parent = filter_input(INPUT_POST, 'parent', FILTER_VALIDATE_INT);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);

if(isset($btn)) {
    $errors = [];

    if(empty($name)) {
        $errors['name'] = "Nimi ei tohi olla tühi";
    } elseif (strlen($name) > 100) {
        $errors['name'] = "Nimi ei tohi olla pikem kui 100 ühikut";
    }

    if(empty($errors)) {

        if(empty($ID)) {
            $product = new Product();
        }

        $product->name = $name;
        $product->added = date("Y-m-d H:i:s");
        $product->parent = $parent;
        $product->status = $status == 'on' ? 1 : 0;
        $product->price = $price;
        $product->category_id = $category_id;
        $product->description = $description;
        $product->added_by = date("Y-m-d H:i:s");

        if($product->save()) {
            if(empty($ID)) {
                $session->message('<div class="alert alert-success">Produkt lisati baasi</div>');
            } else {
                $session->message('<div class="alert alert-success">Produkti uuendati</div>');
            }
            reDirectTo(ADMIN_URL . '?page=product');
        }

        $session->message('<div class="alert alert-warning">Produkti ei lisatud baasi</div>');
        reDirectTo(ADMIN_URL . '?page=product');
    }
}

?>
<h3 class="page-header text-right"><?php echo $pages[$page]['name'] ?></h3>
<?php echo isset($session->message) ? $session->message : '' ?>
<?php echo empty($errors) ? '' : "<ul><li>" . join("</li><li>", $errors) . "</li></ul>"; ?>
<form method="post">
    <div class="form-group">
        <label for="name">Nimi</label>
        <input value="<?php echo isset($product->name) ? $product->name : ''; ?>" name="name" type="text" class="form-control" id="name" placeholder="Lisage nimi">
    </div>
    <div class="form-group">
        <label for="parent">Vanem</label>
        <?php $products = Product::find_all(); ?>
        <select name="parent" class="form-control chosen-select">
            <option value="0">Valige</option>
            <?php if(!empty($products)) : foreach ($products as $pro) : ?>
                <?php if($ID != $pro->ID) : ?>
                    <option value="<?php echo $pro->ID; ?>"
                        <?php echo isset($product->parent) && $product->parent == $pro->ID ? 'selected' : '' ?>
                    ><?php echo $pro->name; ?></option>
                <?php endif; ?>
            <?php endforeach; endif; ?>
        </select>

    </div>
    <div class="checkbox">
        <label>
            <input name="status" type="checkbox"
                <?php echo isset($product->status) && $product->status == 1 ? 'checked' : '';?>> Status
        </label>
    </div>
    <button type="submit" value="add" name="action" class="btn btn-default">Loo</button>
</form>