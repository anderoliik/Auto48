<?php
/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 29.03.2017
 * Time: 10:38
 */

if(!defined('MAIN_PATH')) {
    header("Location: /");
    exit();
}

$args = [
    'categories'  => [
        'filter' => FILTER_SANITIZE_STRING,
        'flags'  => FILTER_REQUIRE_ARRAY,
    ],
    'action'      => FILTER_SANITIZE_STRING
];

$categories = filter_input_array(INPUT_POST, $args);

if(isset($categories['action']) && $categories['action'] == 'search') {
    $category_ids = array_unique($categories['categories']);
    pd($category_ids);
    $category_ids = join(",", $category_ids);

    $products = Product::find_by_category($category_ids);
} else {
    $products = Product::find_all();
}

?>
<div class="row">
    <div id="grid" data-columns>
        <?php if(!empty($products)) : foreach ($products as $product) : ?>
            <div>
                <div class="thumbnail">
                    <?php if (empty($product->main_picture)) : ?>
                        <img src="<?php echo MAIN_URL; ?>template/img/no-image-icon-24.jpg" class="img-responsive" width="200">
                    <?php else: ?>
                        <?php $picture = Picture::getPictureByNameAndProduct($product->main_picture, $product->ID); ?>
                        <img src="<?php echo makePictureLink($picture) . PICTURE_THUMB . '/' . $picture->name; ?>" class="img-responsive">
                    <?php endif; ?>

                    <div class="caption">
                        <h3><?php echo $product->name; ?></h3>
                        <div class="row">
                            <div class="col-xs-6"><?php echo $product->showPrice(); ?></div>
                            <div class="col-xs-6">
                                <a class="btn btn-default pull-right" href="<?php echo MAIN_URL . "?page=product-view&ID=" . $product->ID; ?>" ><?php echo translate("info") ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; else: ?>

            <?php echo infoMessage('info', 'Tooted puuduvad'); ?>

        <?php endif; ?>
    </div>
</div>