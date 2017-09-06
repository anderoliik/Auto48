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
        $session->message('<div class="alert alert-danger">Toode puudub</div>');
        reDirectTo(ADMIN_URL . '?page=products');
    }
}

$btn = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$parent = filter_input(INPUT_POST, 'parent', FILTER_VALIDATE_INT);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

if(isset($btn)) {
    $errors = [];

    $names = filterArray($_POST['name'], FILTER_SANITIZE_STRING);
    $prices = filterArray($_POST['price'], FILTER_VALIDATE_FLOAT);
    $descriptions = filterArray($_POST['description'], FILTER_SANITIZE_STRING);

    unset($names['et']);
    unset($prices['et']);
    unset($descriptions['et']);

    pd($names);
    pd($prices);
    pd($descriptions);

    exit();

    if(empty($name)) {
        $errors['name'] = "Nimi ei tohi olla tühi";
    } elseif (strlen($name) > 100) {
        $errors['name'] = "Nimi ei tohi olla pikem kui 100 ühikut";
    }

    if(empty($price)) {
        $errors['price'] = "Hind ei tohi tühi olla";
    }

    if(empty($parent)) {
        $errors['parent'] = "Kategooria ei tohi tühi olla";
    }

    if(empty($errors)) {

        if(empty($ID)) {
            $product = new Product();
        }

        $product->name = $names['et'];
        $product->price = number_format($prices['et'], 2);
        $product->added = date("Y-m-d H:i:s");
        $product->category_id = $parent;
        $product->status = $status == 'on' ? 1 : 0;
        $product->added_by = $_SESSION['user_id'];
        $product->edited_by = $_SESSION['user_id'];
        $product->description = $descriptions['et'];

        if($product->save()) {

            unset($names['et']);

            if(empty($ID)) {
                $session->message('<div class="alert alert-success">Toode lisati baasi</div>');
                reDirectTo(ADMIN_URL . '?page=products');
            } else {
                $session->message('<div class="alert alert-success">Toodet uuendati</div>');
                reDirectTo(ADMIN_URL . '?page=product&ID=' . $ID);
            }
        }

        $session->message('<div class="alert alert-warning">Toodet ei lisatud baasi</div>');
        reDirectTo(ADMIN_URL . '?page=products');
    }
}

?>
<h3 class="page-header text-right"><?php echo $pages[$page]['name'] ?></h3>

<?php echo isset($session->message) ? $session->message : '' ?>
<?php echo empty($errors) ? '' : "<ul><li>" . join("</li><li>", $errors) . "</li></ul>"; ?>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#et" aria-controls="et" role="tab" data-toggle="tab"><?php echo translate('flag_estonia'); ?></a></li>
    <li role="presentation"><a href="#en" aria-controls="profile" role="tab" data-toggle="tab"><?php echo translate('flag_english'); ?></a></li>
</ul>

<form method="post">

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="et">
            <div class="form-group">
                <label for="name">Nimi</label>
                <input value="<?php echo isset($product->name) ? $product->name : ''; ?>" name="name[et]" type="text" class="form-control" id="name" placeholder="Lisage nimi">
            </div>
            <div class="form-group">
                <label for="name">Hind</label>
                <input value="<?php echo isset($product->price) ? $product->price : ''; ?>" name="price[et]" type="text" class="form-control" id="price" placeholder="Lisage Hind">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description[et]" class="form-control" id="description"><?php echo isset($product->description) ? $product->description : ''; ?></textarea>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="en">
            <div class="form-group">
                <label for="name"><?php echo translate('product_name'); ?></label>
                <input value="<?php echo isset($product->name) ? $product->name : ''; ?>" name="name[en]" type="text" class="form-control" id="name" placeholder="Lisage nimi">
            </div>
            <div class="form-group">
                <label for="name"><?php echo translate('product_price'); ?></label>
                <input value="<?php echo isset($product->price) ? $product->price : ''; ?>" name="price[en]" type="text" class="form-control" id="price" placeholder="Lisage Hind">
            </div>
            <div class="form-group">
                <label for="description"><?php echo translate('product_description'); ?></label>
                <textarea name="description[en]" class="form-control" id="description"><?php echo isset($product->description) ? $product->description : ''; ?></textarea>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="parent">Kategooria</label>
        <?php $categories = Category::find_all(); ?>
        <select name="parent" class="form-control chosen-select">
            <option value="0">Valige</option>
            <?php if(!empty($categories)) : foreach ($categories as $cat) : ?>
                <?php if($ID != $cat->ID) : ?>
                    <option value="<?php echo $cat->ID; ?>"
                        <?php echo isset($product->category_id) && $product->category_id == $cat->ID ? 'selected' : '' ?>
                    ><?php echo $cat->name; ?></option>
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