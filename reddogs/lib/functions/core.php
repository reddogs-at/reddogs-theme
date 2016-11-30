<?php

/**
 * Execute reddogs theme
 */

function reddogs()
{
    do_action('reddogs');
}

add_action('after_setup_theme', 'reddogs_init_actions');


/**
 * Open HTML Element
 *
 * @param string $name
 * @param string $attributes
 */
function reddogs_element_open( $name, $attributes = null ) {
    global $reddogs;

    $htmlAttributes = array();
    $config = array();
    if ( isset( $reddogs['html_elements'][$name] ) ) {
        $config = $reddogs['html_elements'][$name];
        $tag = isset( $config['tag'] ) ? $config['tag'] : 'div';
        if ( isset( $config['attributes'] ) ) {
            $htmlAttributes = $config['attributes'];
        }
    } else {
        $tag = 'div';
        //$htmlAttributes = array( 'class' => array( $name ) );
    }

    if ( null !== $attributes ) {
        $htmlAttributes = array_merge_recursive( $htmlAttributes, $attributes );
    }
    if ( !isset( $htmlAttributes['class'] ) ) {
        $htmlAttributes['class'] = array( $id = reddogs_underscore_to_dash($name) );
    }
    $htmlAttributes = apply_filters( 'reddogs_element_attributes_' . $name, $htmlAttributes, $name, $config );

    $content = '<' . $tag;
    foreach ( $htmlAttributes as $key => $value ) {
        if ( is_array( $value ) ) {
            $value = implode( ' ', $value );
        }
        $content .= ' ' . $key . '="' . $value . '"';
    }
    $content .= '>';

    $content = apply_filters( 'reddogs_element_open_' . $name, $content, $name, $config, $htmlAttributes );

    do_action( 'reddogs_' . $name . '_before' );
    echo $content;
}

/**
 * Close html element
 *
 * @param string $name
 */
function reddogs_element_close( $name ) {
    global $reddogs;

    if ( isset( $reddogs['html_elements'][ $name ] ) ) {
        $config = $reddogs['html_elements'][ $name ];
        $tag = isset( $config['tag'] ) ? $config['tag'] : 'div';
    } else {
        $tag = 'div';
    }

    $content = '</' . $tag . '>';
    $content = apply_filters( 'reddogs_element_close_' . $name, $content, $name, $config );
    echo $content;
    do_action( 'reddogs_' . $name . '_after' );
}

/**
 * HTML Element
 *
 * @param string $name
 * @param string $attributes
 */
function reddogs_element( $name, $attributes = null ) {
    reddogs_element_open($name, $attributes);
    do_action('reddogs_' . $name);
    reddogs_element_close($name);
}

/**
 * Loop through posts
 */
function reddogs_loop()
{
	if (have_posts()) :
		do_action( 'reddogs_loop_before' );
			while (have_posts()) : the_post();
				reddogs_element_open( 'post', array( 'id' => 'post-' . get_the_ID(), 'class' => array_merge(get_post_class(), array('context-loop'))) );
				do_action('reddogs_post');
				reddogs_element_close( 'post' );
			endwhile;
		do_action( 'reddogs_loop_after' );
	else :
		do_action( 'reddogs_loop_no_posts' );
	endif;
}

/**
 * Post content
 */
function reddogs_post_content()
{
    reddogs_element_open('entry_header');
    do_action( 'reddogs_entry_header' );
    reddogs_element_close('entry_header');

    reddogs_element_open('entry_content');
    do_action( 'reddogs_entry_content' );
    reddogs_element_close('entry_content');

    reddogs_element_open('entry_footer');
    do_action( 'reddogs_entry_footer' );
    reddogs_element_close('entry_footer');
}

// add_action('reddogs_post_content', 'reddogs_post_content');

function reddogs_entry_header()
{
    if (has_action('reddogs_entry_header')) {
        reddogs_element('entry_header');
    }
}

function reddogs_entry_content()
{
    if (has_action('reddogs_entry_content')) {
        reddogs_element('entry_content');
    }
}

function reddogs_entry_footer()
{
    if (has_action('reddogs_entry_footer')) {
        reddogs_element('entry_footer');
    }
}

/**
 * Init post structure
 */
function reddogs_init_post_structure()
{
    if (!is_404()) {
        if (is_archive()) {
            if (is_post_type_archive()) {
                $function = 'reddogs_post_structure_' . get_query_var('post_type');
                if (!function_exists($function)) {
                    $function  = 'reddogs_post_structure_' . get_post_type_object('post_type')->capability_type;
                    if (!function_exists($function)) {
                        $function = 'reddogs_post_structure_page';
                    }
                }
            } elseif(is_date()) {
                $function = 'reddogs_post_structure_post';
            }
        } elseif (is_home()) {
            $function = 'reddogs_post_structure_post';
        } elseif (is_singular()) {
            $function = 'reddogs_post_structure_' . get_post_type();
        }
        elseif (is_search()) {
            $function = 'reddogs_post_structure_search';
            if (!function_exists($function)) {
                $function = 'reddogs_post_structure_post';
            }
        } else {

        }

        if (!function_exists($function)) {
            $function = 'reddogs_post_structure_post';
        }
        $function();
    }
}

function reddogs_post_thumbnail()
{
    if (has_post_thumbnail()) :
        $size = reddogs_get_post_thumbnail_size();
        reddogs_element_open('post_thumbnail');
        if (is_singular()) : ?>
            <?php the_post_thumbnail($size); ?>
        <?php else :?>
            <a href="<?php the_permalink()?>"><?php the_post_thumbnail($size); ?></a>
        <?php endif;
        reddogs_element_close('post_thumbnail');
	endif;
}

function reddogs_get_post_thumbnail_size($key = null)
{
    global $reddogs;

    if (null === $key) {
        $key = reddogs_get_page_key();
    }

    $fallback = $reddogs['post_thumbnail']['fallback'];


    if (isset($reddogs['post_thumbnail']['size'][$key])) {
        return $reddogs['post_thumbnail']['size'][$key];
    } else {
        if (isset($fallback[$key])) {
            return reddogs_get_post_thumbnail_size($fallback[$key]);
        } else {
            if (0 === strpos($key, 'single-post-format-')) {
                return reddogs_get_post_thumbnail_size('single-post');
            }
            if (0 === strpos($key, 'archive-tax-')) {
                return reddogs_get_post_thumbnail_size('archive-tax');
            }
            if (0 === strpos($key, 'archive-')) {
                return reddogs_get_post_thumbnail_size('archive');
            }
            if (0 === strpos($key, 'page-')) {
                return reddogs_get_post_thumbnail_size('page');
            }
        }
    }

}

function reddogs_get_page_key()
{
    if (is_404()) {
        return '404';
    } elseif (is_front_page()) {
        return 'frontpage';
    } elseif (is_home()) {
        return 'home';
    } elseif (is_single()) {
        $postType = get_post_type();
        if ('post' == $postType) {
            $key = 'single-post';
        } else {
            $key = 'single-' .  get_post_type();
        }

        if (post_type_supports($postType, 'post_formats')) {
            $key .= '-format-' . get_post_format();
        }
        return $key;
    } elseif (is_archive()) {
        $key = 'archive';
        if (is_date()) {
            $key .= '-date';
            if (is_year()) {
                $key .= '-year';
            } elseif (is_month()) {
                $key .= '-month';
            } elseif (is_day()) {
                $key .= '-day';
            }
        } elseif (is_category()) {
            $key .= '-category';
        } elseif (is_tag()) {
            $key .= '-tag';
        } elseif (is_tax()) {
            $key .= '-tax-' . get_query_var( 'taxonomy' );
        } elseif (is_post_type_archive()) {
            $key .= '-' . get_query_var( 'post_type' );
        }
        return $key;
    } elseif (is_page()) {
        $template_name = get_post_meta( get_post()->ID, '_wp_page_template', true );
        if (('default' == $template_name) or ('' == $template_name)) {
            return 'page';
        } else {
            $keys[] = 'page';
            if ('php' == pathinfo($template_name, PATHINFO_EXTENSION )) {
                $template_name = substr($template_name, 0, -4);
            }
            return 'page-' . strtr($template_name, array('/' => '-'));
        }


    } elseif (is_search()) {
        return 'search';
    }
}

if (!function_exists('reddogs_post_structure_page')) :
/**
 * Post structure page
 */
function reddogs_post_structure_page()
{
    add_action('reddogs_entry_header_after', 'reddogs_post_thumbnail');
    add_action('reddogs_entry_header', 'reddogs_entry_title');
    add_action('reddogs_entry_content', 'reddogs_the_content');
}
endif;

if (!function_exists('reddogs_post_structure_post')) :
/**
 * Post structure post
 */
function reddogs_post_structure_post()
{
//     add_action('reddogs_entry_header_before', 'reddogs_post_thumbnail');
    add_action('reddogs_entry_header', 'reddogs_entry_title');
//     add_action('reddogs_entry_header', 'reddogs_entry_meta_open');
//     add_action('reddogs_entry_header', 'reddogs_entry_author');
//     add_action('reddogs_entry_header', 'reddogs_entry_time');
//     add_action('reddogs_entry_header', 'reddogs_entry_meta_close');
    add_action('reddogs_entry_content', 'reddogs_the_content');

//     add_action('reddogs_entry_author_name_before', 'reddogs_entry_author_link_open');
//     add_action('reddogs_entry_author_name_after', 'reddogs_entry_author_link_close');
}
endif;

/**
 * Entry content
 */
function reddogs_the_content() {
    the_content( __( 'Read more', 'reddogs' ) );
}

/**
 * Bootstrap meta tags
 */
function reddogs_meta() { ?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php }

add_action('wp_head', 'reddogs_meta', 0);

/**
 * Setup theme
 */
function reddogs_setup_theme()
{
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-logo', array(
        'height'      => 240,
        'width'       => 240,
        'flex-height' => true,
    ) );
}

add_action( 'after_setup_theme', 'reddogs_setup_theme' );

/**
 * Enqueue scripts
 */
function reddogs_enqueue_scripts()
{
    wp_enqueue_script( 'reddogs_html5shiv', get_template_directory_uri() . '/reddogs/js/html5shiv.min.js', array(), '3.7.3' );
    wp_script_add_data( 'reddogs_html5shiv', 'conditional', 'lt IE 9' );

    wp_enqueue_script( 'reddogs_respond', get_template_directory_uri() . '/reddogs/js/respond.min.js', array(), '3.7.3' );
    wp_script_add_data( 'reddogs_respond', 'conditional', 'lt IE 9' );

    wp_enqueue_script('reddogs', get_template_directory_uri() . '/reddogs/js/reddogs.js', array('jquery'), null);
}

add_action( 'wp_enqueue_scripts', 'reddogs_enqueue_scripts' );

/**
 * Enqueue styles
 */
function reddogs_enqueue_styles()
{
    $config = json_decode(file_get_contents(dirname(dirname(__DIR__)) . '/config/config.json'));
    wp_enqueue_style(
        'reddogs',
        get_template_directory_uri() . '/reddogs/css/reddogs.' . $config->versions->css . '.min.css',
        array(),
        null
    );
}

add_action( 'wp_enqueue_scripts', 'reddogs_enqueue_styles' );

function reddogs_init_actions()
{
    global $reddogs;
    $actions = $reddogs['actions'];

    foreach ($actions as $tag => $definition) {
        foreach ($definition as $params) {
            if (isset($params['priority'])) {
                $priority = $params['priority'];
            } else {
                $priority = 10;
            }
            add_action($tag, $params['callable'], $priority, 2);
        }

    }
}

/**
 * HTML Head
 */
function reddogs_head() { ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php
wp_head();
?>
</head>
<?php }

/**
 * HTML Body
 */
function reddogs_body()
{
    reddogs_element('body', array('class' => get_body_class()));
}

function reddogs_entry_title()
{
    if ( is_singular() ) {
        the_title( '<h1 class="entry-title">', '</h1>' );
    } else {
        the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
    }
}

function reddogs_sidebar_first()
{
    if ('none' == reddogs_get_sidebar_selection()) {
        return;
    }
    if (has_action('reddogs_sidebar_first_content')) {
        reddogs_element('sidebar_first');
    }
}

function reddogs_sidebar_second()
{
    if (!in_array(reddogs_get_sidebar_selection(), array('left-right', 'left-left', 'right-right'))) {
        return;
    }
    if (has_action('reddogs_sidebar_second_content')) {
        reddogs_element('sidebar_second');
    }
}

function reddogs_site_footer()
{
    if (has_action('reddogs_site_footer')) {
        reddogs_element('site_footer');
    }
}

function reddogs_init_widget_areas() {
    global $reddogs;
    foreach ($reddogs['widget_areas'] as $id => $params) {
        $id = reddogs_underscore_to_dash($id);
        $reddogs['widget_areas'][$id]['args']['id'] = $id;
        $params['args']['id'] = $id;
        if (true === $params['enabled']) {
            register_sidebar($params['args']);
        }
    }
}

add_action('after_setup_theme', 'reddogs_init_widget_areas');

function reddogs_position_widget_areas() {
    global $reddogs;
    $dynamicSidebar = new Reddogs_DynamicSidebar($reddogs);

    foreach ($reddogs['widget_areas'] as $id => $params) {
        $id = reddogs_underscore_to_dash($id);
        if (true === $params['enabled']) {
            add_action($params['location'], array($dynamicSidebar, 'dynamic_sidebar_' . $id), $params['priority']);
        }
    }
}


function reddogs_dynamic_sidebar($id) {
    global $reddogs;
    if (!isset($reddogs['widget_areas'][$id])) {
        return;
    }
    if (!empty($reddogs['widget_areas'][$id]['restrictions'])) {
        foreach ($reddogs['widget_areas'][$id]['restrictions'] as $property => $value) {
            $function  = 'is_' . $property;
            if ($value !== $function()) {
                return;
            }
        }
    }


    dynamic_sidebar($id);
}

function reddogs_get_wrap_open($class, $depth) {
    $content = '';
    for ( $i = 0; $i < $depth; $i++ ) {
        $content .= '<div class="' . $class . '-wrap-' . ( $depth - $i ) . '">';
    }
    return $content;
}

function reddogs_wrap_open($class, $depth) {
    echo reddogs_get_wrap_open($class, $depth);
}

function reddogs_get_wrap_close( $depth ) {
    return str_repeat( '</div>', $depth );
}

function reddogs_wrap_close($depth)
{
    echo reddogs_get_wrap_close($depth);
}

function reddogs_init_html_elements_wrap() {
    global $reddogs;
    foreach ($reddogs['html_elements'] as $name => $element) {
        if (isset($element['wrap'])) {
            add_filter('reddogs_element_open_' . $name, 'reddogs_wrap_html_element_open', 5, 3);
            add_filter('reddogs_element_close_' . $name, 'reddogs_wrap_html_element_close', 20, 3);
        }
    }
}

add_action( 'reddogs_init', 'reddogs_init_html_elements_wrap');

function reddogs_underscore_to_dash($content)
{
    return str_replace('_', '-', $content);
}

function reddogs_dash_to_underscore()
{
    return str_replace('-', '_', $content);
}


function reddogs_wrap_html_element_open($content, $name, $config) {
    global $reddogs;

    if ((isset($config['attributes']['class'])) and (!empty($config['attributes']['class']))) {
        $class = $config['attributes']['class'][0];
    } else {
        $class = reddogs_underscore_to_dash($name);
    }
    return reddogs_get_wrap_open($class, $config['wrap']) . $content;

}

function reddogs_wrap_html_element_close($content, $name, $config) {
    global $reddogs;
    return $content . reddogs_get_wrap_close( $config['wrap'] );
}



function reddogs_get_sidebar_selection()
{
    global $reddogs;

    $defaultSelection = $reddogs['defaults']['layout']['sidebars'];

    if (is_singular()) {
        $selected = get_post_meta(get_the_ID(), 'reddogs_sidebar_selection', true);
        if ($selected) {
            return $selected;
        }
    } elseif (is_home()) {
        $selected = get_post_meta(get_page(get_option('page_for_posts'))->ID, 'reddogs_sidebar_selection', true);
        if ($selected) {
            return $selected;
        }
    } elseif (is_archive()) {
        if (is_post_type_archive()) {
            $key = 'reddogs_custom_post_type_archive_' . get_query_var('post_type');
            $options = get_option($key, array());
            if ((isset($options['sidebar_selection'])) and ('' != $options['sidebar_selection'])) {
                return $options['sidebar_selection'];
            }
        } elseif (is_tag() or is_tax() or is_category()) {
            $options = get_option('reddogs_term_metadata');
            $termId = get_queried_object()->term_id;
            if ((isset($options[$termId])) and ('' != $options[$termId]['sidebar_selection'])) {
                return $options[$termId]['sidebar_selection'];
            }
        } else {
            return $reddogs['components']['sidebar']['default'];
        }
    } elseif (is_search()) {
        return $reddogs['components']['sidebar']['default'];
    }

    return $defaultSelection;
}

function reddogs_body_class_sidebar_sequence($classes)
{
    $classes[] = 'layout-sidebar-' . reddogs_get_sidebar_selection();
    return $classes;
}

add_filter('body_class', 'reddogs_body_class_sidebar_sequence');

function reddogs_metabox_sidebar()
{
    global $reddogs;
    new Reddogs_Metabox_Sidebar($reddogs);
}

add_action('after_setup_theme', 'reddogs_metabox_sidebar');

function reddogs_get_sidebar_list()
{
    global $reddogs;

    $sidebars = array('none' => __( 'No Sidebar', 'reddogs' ));

    if (true === $reddogs['widget_areas']['sidebar_first']['enabled']) {
        $sidebars['left'] = __( 'Left Sidebar', 'reddogs' );
        $sidebars['right'] = __( 'Right Sidebar', 'reddogs' );
        if (true === $reddogs['widget_areas']['sidebar_second']['enabled']) {
            $sidebars['left-right'] = __('Sidebars Left and Right', 'reddogs' );
            $sidebars['left-left'] = __('Two Sidebars Left');
            $sidebars['right-right'] = __('Two Sidebars Right');
        }
    }

    return $sidebars;
}

