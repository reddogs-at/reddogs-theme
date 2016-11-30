<?php

function reddogs_comments()
{
    /**
     * section
     *  h2
     *  article
     */
    if (!is_single()) {
        return;
    }
    if ( comments_open() || get_comments_number() ) {
        reddogs_element('comments_section');
        //         reddogs_element_open('comments_section');
        //         $comments = get_comments(array(
        // 			'post_id' => get_the_ID(),
        // 			'status' => 'approve'
        // 		));
        //         wp_list_comments(array(
            //             'per_page' => 10,
        //             'reverse_top_level' => true
        //         ), $comments);
        //         reddogs_element_close('comments_section');
    }
}

function reddogs_comments_title_content()
{
    $comments_number = get_comments_number();
    if (1 == $comments_number) {
        printf( _x( 'One comment on &ldquo;%s&rdquo;', 'comments title', 'reddogs' ), get_the_title() );
    } else {
        printf(
            /* translators: 1: number of comments, 2: post title */
            _nx(
                '%1$s comments on &ldquo;%2$s&rdquo;',
                '%1$s comments on &ldquo;%2$s&rdquo;',
                $comments_number,
                'comments title',
                'reddogs'
                ),
            number_format_i18n( $comments_number ),
            get_the_title()
            );
    }
}

function reddogs_comments_content()
{
    $comments = get_comments(array(
        'post_id' => get_the_ID(),
        'status' => 'approve'
    ));
    wp_list_comments(array(
        'style' => 'div',
        'per_page' => 10,
        'reverse_top_level' => true,
        'callback' => 'reddogs_comments_item',
        'end-callback' => 'reddogs_comments_item_end',
        //         'walker' => new Reddogs_Walker_Comment(),
    ), $comments);
}

function reddogs_comments_item_vorlage($comment, $args, $depth)
{
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-author vcard">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        <?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ); ?>
    </div>
    <?php if ( $comment->comment_approved == '0' ) : ?>
         <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
          <br />
    <?php endif; ?>

    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
        <?php
        /* translators: 1: date, 2: time */
        printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), '  ', '' );
        ?>
    </div>

    <?php comment_text(); ?>

    <div class="reply">
        <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
    <?php
    }

function reddogs_comments_item($comment, $args, $depth)
{
    reddogs_element_open('comments_item', array(
        'class' => get_comment_class( empty( $args['has_children'] ) ? '' : 'parent' ),
        'id' => 'comment-' . get_comment_ID()
    ));
    do_action('reddogs_comments_item_body');
}

function reddogs_comments_item_end()
{
    reddogs_element_close('comments_item');
}

function reddogs_comments_item_content_text()
{
    comment_text();
}

function reddogs_comments_item_author_vcard_avatar()
{
    echo get_avatar( get_comment() );
}

function reddogs_comments_item_author_link()
{
    printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() );
}