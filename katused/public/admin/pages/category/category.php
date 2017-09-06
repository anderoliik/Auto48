<?php
/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 6.03.2017
 * Time: 11:45
 */

if(!defined('MAIN_PATH')) {
    header("Location: /");
    exit();
}

$ID = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);
if(!empty($ID)) {
    $category = Category::find_by_ID($ID);

    if(empty($category)) {
        $session->message('<div class="alert alert-danger">Kategooria puudub</div>');
        reDirectTo(ADMIN_URL . '?page=categories');
    }
}

$btn = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$parent = filter_input(INPUT_POST, 'parent', FILTER_VALIDATE_INT);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

if(isset($btn)) {
    $errors = [];

    if(empty($name)) {
        $errors['name'] = "Nimi ei tohi olla tühi";
    } elseif (strlen($name) > 100) {
        $errors['name'] = "Nimi ei tohi olla pikem kui 100 ühikut";
    }

    if(empty($errors)) {

        if(empty($ID)) {
            $category = new Category();
        }

        $category->name = $name;
        $category->added = date("Y-m-d H:i:s");
        $category->parent = $parent;
        $category->status = $status == 'on' ? 1 : 0;

        if($category->save()) {
            if(empty($ID)) {
                $session->message('<div class="alert alert-success">Kategooria lisati baasi</div>');
            } else {
                $session->message('<div class="alert alert-success">Kategoori uuendati</div>');
            }
            reDirectTo(ADMIN_URL . '?page=category');
        }

        $session->message('<div class="alert alert-warning">Kategooriat ei lisatud baasi</div>');
        reDirectTo(ADMIN_URL . '?page=category');
    }
}

?>
<h3 class="page-header text-right"><?php echo $pages[$page]['name'] ?></h3>
<?php echo isset($session->message) ? $session->message : '' ?>
<?php echo empty($errors) ? '' : "<ul><li>" . join("</li><li>", $errors) . "</li></ul>"; ?>
<form method="post">
    <div class="form-group">
        <label for="name">Nimi</label>
        <input value="<?php echo isset($category->name) ? $category->name : ''; ?>" name="name" type="text" class="form-control" id="name" placeholder="Lisage nimi">
    </div>
    <div class="form-group">
        <label for="parent">Vanem</label>
        <?php $categories = Category::find_all(); ?>
        <select name="parent" class="form-control chosen-select">
            <option value="0">Valige</option>
            <?php if(!empty($categories)) : foreach ($categories as $cat) : ?>
                <?php if($ID != $cat->ID) : ?>
                    <option value="<?php echo $cat->ID; ?>"
                        <?php echo isset($category->parent) && $category->parent == $cat->ID ? 'selected' : '' ?>
                    ><?php echo $cat->name; ?></option>
                <?php endif; ?>
            <?php endforeach; endif; ?>
        </select>

    </div>
    <div class="checkbox">
        <label>
            <input name="status" type="checkbox"
                <?php echo isset($category->status) && $category->status == 1 ? 'checked' : '';?>> Status
        </label>
    </div>
    <button type="submit" value="add" name="action" class="btn btn-default">Loo</button>
</form>

