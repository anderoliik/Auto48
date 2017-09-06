<?php

require_once "../include/start.php";

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

if(empty($page)) {
    $page = 'home';
}

$ID = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);

$categories = Category::find_all();
$categories = createCategoryArray($categories);

pd($_POST);

get_template('head'); ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header text-center">AS Katused</h1>
            </div>
            <div class="col-lg-12 text-right">
                <?php if(LANG != 'et') : ?><span class="flag-icon flag-icon-ee btn-lg make-default-lang" data-lang="et"></span><?php endif; ?>
                <?php if(LANG != 'en') : ?><span class="flag-icon flag-icon-gb btn-lg make-default-lang" data-lang="en"></span><?php endif; ?>
                <?php if(LANG != 'de') : ?><span class="flag-icon flag-icon-de btn-lg make-default-lang" data-lang="de"></span><?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <form method="post">
                    <?php if(!empty($categories[0])) : foreach ($categories[0] as $category) : ?>
                        <input type="hidden" value="<?php echo $category->ID; ?>" name="categories[]">
                        <h3><?php echo $category->name; ?></h3>
                        <?php if(!empty($categories[$category->ID])) : ?>
                            <select name="categories[]">
                                <option value="0"><?php echo translate("select") ?></option>
                                <?php foreach ($categories[$category->ID] as $subCategory) : ?>
                                    <option value="<?php echo $subCategory->ID; ?>"><?php echo $subCategory->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    <?php endforeach; endif; ?>
                    <hr>
                    <button class="btn btn-primary" type="submit" name="action" value="search">Search</button>
                </form>
            </div>
            <div class="col-sm-9">
                <?php if(!empty($page) && isset($pages[$page])) :
                    require_once MAIN_PAGES_PATH . $pages[$page]['path'];
                else :
                    require_once ADMIN_404;
                endif; ?>
            </div>
        </div>
    </div>

<?php get_template('footer');