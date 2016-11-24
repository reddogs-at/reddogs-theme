<?php

class Reddogs_Metabox_Sidebar
{
	private $reddogs;

    public function __construct($reddogs)
    {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'save' ) );
        $this->reddogs = $reddogs;
    }

    public function add_meta_box($post_type)
    {
        add_meta_box(
            'reddogs_sidebar_selection',
            __( 'Sidebar Selection', 'reddogs' ),
            array( $this, 'render_meta_box_content' ),
            $post_type,
            'side'
		);
    }

    public function save($post_id)
    {
        $layout = sanitize_text_field( $_POST['reddogs_sidebar_selection'] );

		// Update the meta field.
		update_post_meta( $post_id, 'reddogs_sidebar_selection', $layout );
    }

    public function render_meta_box_content($post)
    {
        $value = get_post_meta($post->ID, 'reddogs_sidebar_selection', true);
        if (!$value) {
        	$value = $this->reddogs['defaults']['layout']['sidebars'];
        }
        $layouts = reddogs_get_sidebar_list();
        ?>
            <label for="reddogs_sidebar_selection"><?php _e('Layout', 'reddogs'); ?></label>
            <select name="reddogs_sidebar_selection" id="reddogs_sidebar_selection">
                <?php foreach ($layouts as $key => $name): ?>
                 <option value="<?php echo $key; ?>"<?php if ($key == $value) { echo ' selected="selected"'; }?>><?php echo $name;?></option>
                <?php endforeach; ?>
            </select>
        <?php
    }
}