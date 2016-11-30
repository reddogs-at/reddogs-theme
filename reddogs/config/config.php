<?php

/**
 * Structure
 *  html
 *      head
 *  body
 *      site_container
 *          site_header
 *          site_content
 *              site_main
 *          site_footer
 */
global $reddogsAction;
global $reddogsElement;

return array(
    'html_elements' => array(
        'body' => array(
            'tag' => 'body'
        ),
        'comments_title' => array(
            'tag' => 'h2',
        ),
        'comments_section' => array(
            'tag' => 'section',
            'attributes' => array(
                'class' => 'comments-area',
                'id' => 'comments'
            )
        ),
        'comments_item' => array(
            'tag' => 'article',
        ),
        'comments_item_body' => array(
            'attributes' => array(
                'class' => array('comment-body'),
            )
        ),
        'comments_item_header' => array(
            'tag' => 'header'
        ),
        'comments_item_footer' => array(
            'tag' => 'footer'
        ),
        'comments_item_author_vcard' => array(
            'attributes' => array(
                'class' => array('comment-author', 'vcard')
            )
        ),
        'navbar' => array(
            'tag' => 'nav',
            'attributes' => array(
                'class' => array('navbar')
            )
        ),
        'navbar_content' => array(
            'attributes' => array(
                'class' => array(
                    'collapse',
                    'navbar-collapse'
                ),
                'id' => 'reddogs-navbar'
            )
        ),
        'navbar_form' => array(
            'tag' => 'form',
            'attributes' => array(
                'class' => array(
                    'navbar-form'
                )
            )
        ),
        'navbar_search' => array(
            'attributes' => array(
                'class' => array(
                    'form-group'
                )
            )
        ),
        'navbar_search_input' => array(
            'tag' => 'input',
            'attributes' => array(
                'type' => 'text',
                'class' => array(
                        'form-control'
                ),
                'placeholder' => __('Search', 'reddogs'),
            )
        ),
        'navbar_search_submit' => array(
            'tag' => 'input',
            'attributes' => array(
                'type' => 'submit',
                'value' => __('Go', 'reddogs'),
                'class' => array(
                    'btn',
                )
            )
        ),
        'navbar_toggle' => array(
            'tag' => 'button',
            'attributes' => array(
                'type' => 'button',
                'class' => array(
                    'navbar-toggle',
                    'collapsed'
                ),
                'data-toggle' => 'collapse',
                'data-target' => '#reddogs-navbar'
            ),
        ),
        'post' => array(
            'tag' => 'article'
        ),
        'sidebar_first' => array(
            'tag' => 'aside'
        ),
        'sidebar_first_content' => array(
            'wrap' => 2,
        ),
        'sidebar_second' => array(
            'tag' => 'aside'
        ),
        'site_footer' => array(
            'tag' => 'footer'
        ),
        'site_header' => array(
            'tag' => 'header'
        ),
        'site_main' => array(
            'tag' => 'main'
        ),
    ),
    'actions' => array(
        'reddogs' => array(
            'init' => array(
                'callable' => array($reddogsAction, 'reddogs_init')
            ),
            'head' => array(
                'callable' => 'reddogs_head',
            ),
            'body' => array (
                'callable' => 'reddogs_body'
            ),
        ),
        'reddogs_body' => array(
            'site_container' => array(
                'callable' => array($reddogsElement, 'site_container')
            ),
        ),
        'reddogs_comments_section' => array(
            'title' => array(
                'callable' => array($reddogsElement, 'comments_title')
            ),
            'comments' => array(
                'callable' => 'reddogs_comments_content'
            )

        ),
        'reddogs_comments_title' => array(
            'content' => array(
                'callable' => 'reddogs_comments_title_content'
            )
        ),
        'reddogs_comments_item_body' => array(
            'header' => array(
                'callable' => array($reddogsElement, 'comments_item_header')
            ),
            'content' => array(
                'callable' => array($reddogsElement, 'comments_item_content')
            ),
            'footer' => array(
                'callable' => array($reddogsElement, 'comments_item_footer')
            ),
        ),
        'reddogs_comments_item_content' => array(
            'author_vcard' => array(
                'callable' => array($reddogsElement, 'comments_item_author_vcard'),
            ),
            'text' => array(
                'callable' => 'reddogs_comments_item_content_text'
            ),
        ),
        'reddogs_comments_item_author_vcard' => array(
            'avatar' => array(
                'callable' => 'reddogs_comments_item_author_vcard_avatar'
            ),
            'link' => array(
                'callable' => 'reddogs_comments_item_author_link'
            ),
        ),
        'reddogs_init' => array(
            'init_post_structure' => array(
                'callable' => 'reddogs_init_post_structure'
            ),
            'position_widget_areas' => array(
                'callable' => 'reddogs_position_widget_areas'
            ),
        ),
        'reddogs_navbar' => array(
            'navbar_container' => array(
                'callable' => array($reddogsElement, 'navbar_container')
            )
        ),
        'reddogs_navbar_container' => array(
            'header' => array(
                'callable' => array($reddogsElement, 'navbar_header')
            ),
            'content' => array(
                'callable' => array($reddogsElement, 'navbar_content')
            )
        ),
        'reddogs_navbar_content' => array(
            'nav_menu_primary' => array(
                'callable' => 'reddogs_nav_menu_primary'
            ),
            'form' => array(
                'callable' => array($reddogsElement, 'navbar_form')
            )
        ),
        'reddogs_navbar_header' => array(
            'collapse' => array(
                'callable' => array($reddogsElement, 'navbar_toggle')
            ),
        ),
        'reddogs_navbar_toggle' => array(
            'toggle_content' => array(
                'callable' => 'navbar_toggle_content'
            )
        ),
        'reddogs_navbar_form' => array(
            'search' => array(
                'callable' => array($reddogsElement, 'navbar_search')
            ),
            'input' => array(
                'callable' => array($reddogsElement, 'navbar_search_submit')
            )
        ),
        'reddogs_navbar_search' => array(
            'input' => array(
                'callable' => array($reddogsElement, 'navbar_search_input')
            )
        ),
        'reddogs_post' => array(
            'post_content' => array(
                'callable' => array($reddogsElement, 'post_content')
            )
        ),
        'reddogs_post_content' => array(
            'entry_header' => array(
                'callable' => 'reddogs_entry_header',
            ),
            'entry_content' => array(
                'callable' => 'reddogs_entry_content',
            ),
            'entry_footer' => array(
                'callable' => 'reddogs_entry_footer',
            ),
            'comments' => array(
                'callable' => 'reddogs_comments'
            )
        ),
        'reddogs_sidebar_first' => array(
            'sidebar_first_content' => array(
                'callable' => array($reddogsElement, 'sidebar_first_content')
            ),
        ),
        'reddogs_sidebar_second' => array(
            'sidebar_second_content' => array(
                'callable' => array($reddogsElement, 'sidebar_second_content')
            ),
        ),
        'reddogs_site_container' => array(
            'site_header' => array(
                'callable' => array($reddogsElement, 'site_header')
            ),
            'site_content' => array(
                'callable' => array($reddogsElement, 'site_content')
            ),
            'site_footer' => array(
                'callable' => 'reddogs_site_footer'
            ),
        ),
        'reddogs_site_content' => array(
            'site_main' => array(
                'callable' => array($reddogsElement, 'site_main'),
                'priority' => 10,
            ),
            'sidebar_first' => array(
                'callable' => 'reddogs_sidebar_first',
                'priority' => 10,
            ),
            'sidebar_second' => array(
                'callable' => 'reddogs_sidebar_second',
                'priority' => 10,
            ),
        ),
        'reddogs_site_header' => array(
            'navbar' => array(
                'callable' => array($reddogsElement, 'navbar')
            )
        ),
        'reddogs_site_main' => array(
            'loop' => array(
                'callable' => 'reddogs_loop'
            )
        ),
    ),
    'nav_menus' => array(
        'primary' => array(
            'description' => __( 'Primary Menu', 'reddogs' ),
            'args' => array(
                'container' => false,
                'menu_class' => array('nav', 'navbar-nav'),
                'walker' => new Reddogs_Walker_Nav_Menu(),
            ),
        )
    ),
    'widget_areas' => array(
        'sidebar_first' => array(
            'enabled' => true,
 			'location' => 'reddogs_sidebar_first_content',
            'priority' => 10,
            'wrap' => 2,
            'args' => array(
                'name' => __('First Sidebar', 'reddogs' ),
                'description' => __('Main Sidebar', 'reddogs' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>'
            ),
        ),
        'sidebar_second' => array(
            'enabled' => true,
 			'location' => 'reddogs_sidebar_second_content',
            'priority' => 10,
            'args' => array(
                'name' => __('Second Sidebar', 'reddogs' ),
                'description' => __('Additional Sidebar', 'reddogs' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>'
            ),
        ),
        'footer' => array(
            'enabled' => true,
 			'location' => 'reddogs_site_footer',
            'priority' => 10,
            'args' => array(
                'name' => __('Footer Widget Area', 'reddogs' ),
                'description' => __('Widget area in the site footer', 'reddogs' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>'
            ),
        ),
    ),
    'defaults' => array(
        'layout' => array(
            'sidebars' => 'right'
        )
    ),
    'post_thumbnail' => array(
        'fallback' => array(
            'archive' => 'home',
            'archive-category' => 'archive',
            'archive-date' => 'archive',
            'archive-date-year' => 'archive-date',
            'archive-tag' => 'archive',
            'archive-tax' => 'archive',
            'frontpage' => 'single-post',
            'home' => 'single-post',
            'page' => 'single-post',
            'search' => 'archive',
        ),
        'size' => array(
            'single-post' => 'large'
        )
    ),
);

