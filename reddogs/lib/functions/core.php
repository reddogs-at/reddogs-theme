<?php

/**
 * Execute reddogs theme
 */
function reddogs()
{
    do_action( 'reddogs_init' );
    get_header();
    do_action( 'reddogs_loop' );
    get_footer();
}

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
        $htmlAttributes['class'] = array( str_replace('_', '-', $name ) );
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