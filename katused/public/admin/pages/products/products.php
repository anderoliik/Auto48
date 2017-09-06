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

$products = Product::find_all();

?>
    <h3 class="page-header">
        <a href="<?php echo ADMIN_URL . "?page=product"; ?>"><small class="text-left"><span class="glyphicon glyphicon-plus-sign"></span></small></a>
        <span class="pull-right"><?php echo $pages[$page]['name'] ?></span>
    </h3>

<?php echo isset($session->message) ? $session->message : '' ?>

<?php if (!empty($products)) : ?>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nimi</th>
            <th>Lisatud</th>
            <th>Vanem</th>
            <th>Muuda</th>
            <th>Kustuta</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $pro) : ?>
            <tr>
                <td><?php echo $pro->ID ?></td>
                <td><?php echo $pro->name ?></td>
                <td><?php echo $pro->added ?></td>
                <td><?php echo $pro->added_by ?></td>
                <td><?php echo $pro->category_id ?></td>
                <td><?php echo $pro->description ?></td>
                <td>
                    <?php $parent = Product::find_by_ID($pro->parent); ?>
                    <?php echo empty($parent) ? 'Põhiprodukt' : $parent->name; ?>
                </td>
                <td>
                    <a href="<?php echo ADMIN_URL . "?page=category&ID=" . $pro->ID; ?>">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                </td>
                <td>
                    <a href="<?php echo ADMIN_URL . "?page=delete&ID=" . $pro->ID; ?>">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else :
    echo infoMessage('info', 'Produktid puuduvad');
endif;

?>