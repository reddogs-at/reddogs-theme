<?php

function reddogs_nav_menu($name, $args = null)
{
    global $reddogs;
    if (isset($reddogs['nav_menus'][$name])) {
        $args = $reddogs['nav_menus'][$name]['args'];
        $args['theme_location'] = $name;
        if (is_array($args['menu_class'])) {
            $args['menu_class'] = implode(' ',  $args['menu_class']);
        }
        wp_nav_menu($args);
    }

}

function reddogs_register_nav_menus()
{
    global $reddogs;

    foreach ($reddogs['nav_menus'] as $location => $params) {
        register_nav_menu($location, $params['description']);
    }
}

add_action('after_setup_theme', 'reddogs_register_nav_menus');

function reddogs_nav_menu_primary()
{
    reddogs_nav_menu('primary');
}

function navbar_toggle_content() { ?>
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<?php }