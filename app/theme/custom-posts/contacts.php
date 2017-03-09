<?php

function post_type_contacts(){

	register_post_type('contacts',
		array(
			'labels' => array(
				'name'               => "Contact",
				'singular_name'      => "Contact",
				'menu_name'          => "Contacts",
				'all_items'          => "Contacts",
				'add_new'            => "Add New",
				'add_new_item'       => "Add New Contact",
				'edit_item'          => "Edit Contact",
			    'new_item'           => "New Contact",
			    'view_item'          => "View",
			    'search_items'       => "Search Contacts",
			    'not_found'          => "No Contacts found",
			    'not_found_in_trash' => "No Contacts found in Trash",
			    'parent_item_colon'  => ""
			),
			'description'         => "Contacts",
			'menu_icon'           => "dashicons-id",
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'menu_position'       => 30,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'rewrite'             => array('slug'=>'contacts','with_front'=>false),
			'hierarchical'        => false,
			'supports'            => array('title',)
		)
	);

} add_action( 'init', 'post_type_contacts' );
