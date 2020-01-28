<?php

	add_action( 'wp_enqueue_scripts', 'stockie_child_local_enqueue_parent_styles' );

	function stockie_child_local_enqueue_parent_styles() {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	}