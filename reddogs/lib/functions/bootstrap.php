<?php

/**
 * Register autoloader
 */
function reddogs_register_autoloader()
{
    $classmap = include (get_template_directory() . '/reddogs/config/classmap.php');
    if ( is_child_theme() ) {
        $path = get_stylesheet_directory() . '/config/classmap.php';
        if (file_exists($path)) {
            $classmap = array_merge($classmap, include $path);
        }
    }

    $autoloader = new Reddogs_Loader_ClassmapAutoloader( $classmap);
    $autoloader->register();
}

add_action( 'after_setup_theme', 'reddogs_register_autoloader' );

/**
 * Load and merge config files
 */
function reddogs_load_config() {
    $reddogsConfig = include get_template_directory() . '/reddogs/config/config.php';
    $config = new Reddogs_Config_Config( $reddogsConfig );
    if ( is_child_theme() ) {
        $childConfigPath = get_stylesheet_directory() . '/config/config.php';
        if ( file_exists( $childConfigPath ) ) {
            $config->merge( include $childConfigPath );
        }
    }
    global $reddogs;
    $reddogs = $config->getConfig();
}

add_action( 'after_setup_theme', 'reddogs_load_config' );