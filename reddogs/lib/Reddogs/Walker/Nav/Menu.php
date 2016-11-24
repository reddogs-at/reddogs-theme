<?php
class Reddogs_Walker_Nav_Menu extends Walker_Nav_Menu  {
    /**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '<ul class="dropdown-menu">';
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '</ul>';
	}
}