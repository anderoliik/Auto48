<?php
/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 6.03.2017
 * Time: 11:12
 */

if(!defined('MAIN_PATH')) {
    header("Location: /");
    exit();
}

$pageNr = filter_input(INPUT_GET, 'pageNr', FILTER_VALIDATE_INT);
$next = $pageNr+1;
$previous = $pageNr-1;

if(empty($pageNr)) {
    $pageNrInDb = 0;
} else {
    $pageNrInDb = $pageNr * MAX_CATEGORIES;
}

$categories = Category::findAll($pageNrInDb, MAX_CATEGORIES);

$countCategories = Category::count_all();

$pagesCount = ceil( 8 / MAX_CATEGORIES);

echo $pagesCount;

?>
    <h3 class="page-header">
        <a href="<?php echo ADMIN_URL . "?page=category"; ?>"><small class="text-left"><span class="glyphicon glyphicon-plus-sign"></span> Lisa</small></a>
        <span class="pull-right"><?php echo $pages[$page]['name'] ?></span>
    </h3>

<?php echo isset($session->message) ? $session->message : '' ?>

<?php if (!empty($categories)) : ?>
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
        <?php foreach ($categories as $cat) : ?>
            <tr>
                <td><?php echo $cat->ID ?></td>
                <td><?php echo $cat->name ?></td>
                <td><?php echo $cat->added ?></td>
                <td>
                    <?php $parent = Category::find_by_ID($cat->parent); ?>
                    <?php echo empty($parent) ? 'Põhikategooria' : $parent->name; ?>
                </td>
                <td>
                    <a href="<?php echo ADMIN_URL . "?page=category&ID=" . $cat->ID; ?>">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                </td>
                <td>
                    <a href="<?php echo ADMIN_URL . "?page=delete&ID=" . $cat->ID; ?>">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <ul class="pager">
        <?php if(!empty($pageNr)) : ?>
            <?php if($pageNr == 1) : ?>
                <li><a href="<?php echo ADMIN_URL . "?page=categories"; ?>"><?php echo translate("previous_btn") ?></a></li>
            <?php else: ?>
                <li><a href="<?php echo ADMIN_URL . "?page=categories&pageNr=" . $previous; ?>"><?php echo translate("previous_btn") ?></a></li>
            <?php endif; ?>
        <?php endif; ?>
        <?php if($pagesCount-1 > $pageNr ) : ?>
            <li><a href="<?php echo ADMIN_URL . "?page=categories&pageNr=" . $next; ?>"><?php echo translate("next_btn") ?></a></li>
        <?php endif; ?>
    </ul>
<?php else :
    echo infoMessage('info', 'Kategooriad puuduvad');
endif; ?>