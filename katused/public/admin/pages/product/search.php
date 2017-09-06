<?php
/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 29.03.2017
 * Time: 11:20
 */

require_once "../../../../include/start.php";

$name = filter_input(INPUT_POST, 's', FILTER_SANITIZE_STRING);

if(empty($name)) {
    $products = Product::find_all();
} else {
    $products = Product::find_by_name($name);
}

?>

<?php if (!empty($products)) : ?>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nimi</th>
            <th>Lisatud</th>
            <th>Kategooria</th>
            <th>Galerii</th>
            <th>Vaata</th>
            <th>Muuda</th>
            <th>Kustuta</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product) : ?>
            <tr>
                <td><?php echo $product->ID ?></td>
                <td><?php echo $product->name ?></td>
                <td><?php echo $product->added ?></td>
                <td>
                    <?php $category = Category::find_by_ID($product->category_id); ?>
                    <?php echo $category->name; ?>
                </td>
                <td>
                    <a href="<?php echo MAIN_URL . "?page=product-view&ID=" . $product->ID; ?>">
                        <span class="glyphicon glyphicon-globe"></span>
                    </a>
                </td>
                <td>
                    <a href="<?php echo ADMIN_URL . "?page=pictures&ID=" . $product->ID; ?>">
                        <span class="glyphicon glyphicon-picture"></span>
                    </a>
                </td>
                <td>
                    <a href="<?php echo ADMIN_URL . "?page=product&ID=" . $product->ID; ?>">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                </td>
                <td>
                <span
                    data-url="pages/product/delete"
                    data-delete-id="<?php echo $product->ID; ?>"
                    class="glyphicon glyphicon-trash bg-danger delete-confirm"
                    style="cursor: pointer;"></span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else :
    echo infoMessage('info', 'Tooted puuduvad');
endif; ?>

<script src="<?php echo TEMPLATE_URL; ?>js/custom.js"></script>