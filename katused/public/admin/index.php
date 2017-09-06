<?php
/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 21.02.2017
 * Time: 11:16
 */

require_once "../../include/start.php";

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

if(!$session->is_logged_in() || !User::checkRights($session->user_id, 'index.php')) {
    $session->message('<div class="alert alert-info">Teil puuduvad õigused näha Admin DashBoardi</div>');
    reDirectTo('login.php');
}

get_template('head'); ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header text-center"><?php echo $t['admin_dashboard']; ?> <small class="pull-right"><a href="logout.php" class="btn btn-danger"><?php echo $t['logout']; ?></a></small></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <ul class="nav nav-pills nav-stacked">
                    <li role="presentation" <?php echo !isset($page) || $page == 'home' ? 'class="active"' : ''; ?>><a href="<?php echo ADMIN_URL; ?>">Home</a></li>
                    <li role="presentation" <?php echo in_array($page, ['categories', 'category', 'delete']) ? 'class="active"' : ''; ?>><a href="<?php echo ADMIN_URL; ?>?page=categories">Kategooriad</a></li>
                    <li role="presentation" <?php echo in_array($page, ['products', 'product']) ? 'class="active"' : ''; ?>><a href="<?php echo ADMIN_URL; ?>?page=products">Tooted</a></li>
                </ul>
            </div>
            <div class="col-sm-9">
                <?php if(!empty($page) && isset($pages[$page])) :
                    require_once ADMIN_PAGES_PATH . $pages[$page]['path'];
                else :
                    require_once ADMIN_404;
                endif; ?>
            </div>
        </div>
    </div>

<?php get_template('footer');