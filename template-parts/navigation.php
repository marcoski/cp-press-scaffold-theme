<?php

use CpPress\Application\WP\Theme\Menu;

$menu = new Menu('primary', '', new \CpPressTheme\Walker\CpPressThemeMenuWalker());
$menu->setShowOption(
    'items_wrap',
    apply_filters("cppress_theme_menu_items_wrap",'<ul class="nav navbar-nav navbar-right">%3$s</ul>')
);

echo $menu->show();
?>