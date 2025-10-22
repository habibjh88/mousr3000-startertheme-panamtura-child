<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class MSR_Child_Custom_Meta_Box {

	private $meta_key = '_msr_child_custom_meta';

	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
		add_action( 'save_post', [ $this, 'save_meta_box' ] );
	}

	// Add meta box
	public function add_meta_box() {
		add_meta_box(
			'msr_child_meta_box',
			__( 'Custom Info', 'msr-child' ),
			[ $this, 'render_meta_box' ],
			'post',
			'side',
			'high'
		);
	}

	// Render meta box content
	public function render_meta_box( $post ) {
		// Nonce field for security
		wp_nonce_field( 'msr_child_meta_box_nonce', 'msr_child_meta_box_nonce_field' );

		// Get existing value
		$value = get_post_meta( $post->ID, $this->meta_key, true );

		?>
        <h2 style="margin:0 0 10px;font-weight: bold;border-bottom: 1px solid;padding:0"><?php echo esc_html__( 'CTA Content', 'msr-child' ) ?></h2>
        <textarea name="msr_child_meta_field" rows="6"
                  style="width:100%;"><?php echo esc_textarea( $value ); ?></textarea>
        <p style="font-size:12px;color:#555;">You can use HTML tags like &lt;strong&gt;, &lt;br&gt;, &lt;em&gt;, &lt;a&gt;,
            etc.</p>
        <br>
        <h2 style="margin:0 0 10px;font-weight: bold;border-bottom: 1px solid;padding:0"><?php echo esc_html__( 'Table Class', 'msr-child' ) ?></h2>
        <p><strong>Use the below classes in any table for different style:</strong></p>
        <p><code>border-all</code> <br> <code>bg-even</code></p>

        <h2 style="margin:0 0 10px;font-weight: bold;border-bottom: 1px solid;padding:0"><?php echo esc_html__( 'Note box', 'msr-child' ) ?></h2>
        <p><strong>Use the below classes in any group or row for make it a note box:</strong></p>
        <p><code>note-box</code> <br> <code>note-box-2</code><br> <code>note-box-3</code></p>

		<?php
	}

	// Save meta box data
	public function save_meta_box( $post_id ) {
		// Verify nonce
		if ( ! isset( $_POST['msr_child_meta_box_nonce_field'] ) || ! wp_verify_nonce( $_POST['msr_child_meta_box_nonce_field'], 'msr_child_meta_box_nonce' ) ) {
			return;
		}

		// Autosave check
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Permission check
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Save or delete
		// Save field (allow safe HTML)
		if ( isset( $_POST['msr_child_meta_field'] ) ) {
			$allowed_html = [
				'a'      => [ 'href' => [], 'title' => [], 'target' => [], 'class' => [] ],
				'h1'     => [ 'class' => [] ],
				'h2'     => [ 'class' => [] ],
				'h3'     => [ 'class' => [] ],
				'h4'     => [ 'class' => [] ],
				'h5'     => [ 'class' => [] ],
				'h6'     => [ 'class' => [] ],
				'br'     => [],
				'em'     => [],
				'strong' => [],
				'p'      => [],
				'span'   => [ 'style' => [] ],
				'ul'     => [],
				'ol'     => [],
				'li'     => [],
				'b'      => [],
				'i'      => [],
			];

			$clean_content = wp_kses( $_POST['msr_child_meta_field'], $allowed_html );
			update_post_meta( $post_id, $this->meta_key, $clean_content );
		} else {
			delete_post_meta( $post_id, $this->meta_key );
		}
	}
}

// Initialize the class
new MSR_Child_Custom_Meta_Box();