<?php
/**
 * Air functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package air
 */

/**
 * The current version of the theme.
 */
define( 'AIR_VERSION', '2.0.0' );

/**
 * WooCommerce support
 */
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'woocommerce_support' );

/**
 * Requires
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Disable emojicons introduced with WP 4.2
 *
 * @link http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
 */
function disable_wp_emojicons() {
  // All actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  // Remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

// Disable TinyMCE emojicons
function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

/**
 * Allow Gravity Forms to hide labels to add placeholders
 */
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

/**
 *  Set Yoast SEO plugin metabox priority to low
 */
function air_lowpriority_yoastseo() {
  return 'low';
}
add_filter( 'wpseo_metabox_prio', 'air_lowpriority_yoastseo' );

/**
 * Enable theme support for essential features
 */
load_theme_textdomain( 'air', get_template_directory() . '/languages' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

/**
 * Set a locale for Finnish language
 */
// setlocale( LC_ALL, 'fi_FI.utf8' );

/*
* Clean up WP admin bar
*/
function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

/*
* Clean up WP admin menu from stuff we usually don't need
*/
function remove_admin_menu_links() {
    remove_menu_page('themes.php?page=editcss');
    // remove_menu_page('edit.php');
    remove_menu_page('widgets.php');
    remove_menu_page('edit-comments.php');
    remove_menu_page('admin.php?page=jetpack');
}
add_action('admin_menu', 'remove_admin_menu_links', 999);

/**
* Hide WP updates nag
*/
function air_wphidenag() {
   remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action( 'admin_menu', 'air_wphidenag' );

/**
 * Editable navigation menus.
 */
register_nav_menus( array(
	'header_left' => __( 'Header Left', 'air'),
  'header_right' => __( 'Header Right', 'air'),
  'footer_left' => __( 'Footer Left', 'air'),
  'footer_right' => __( 'Footer Right', 'air'),
  'mobile_menu' => __( 'Mobile Menu', 'air'),
) );

/**
 * Limit number of nav menu items on menus
 */
function my_nav_menu_objects( $sorted_menu_items, $args ) {

    $menu_limits = array(
      'header_left' => 2,
      'header_right' => 2,
      'footer_left' => 4,
      'footer_right' => 4,
    );

    if ( array_key_exists($args->theme_location, $menu_limits) ) {
      $menu_limit = $menu_limits[$args->theme_location];
    } else {
      return $sorted_menu_items;
    }

    $unset_top_level_menu_item_ids = array();
    $array_unset_value = 1;
    $count = 1;

    foreach ( $sorted_menu_items as $sorted_menu_item ) {

        // unset top level menu items if over count 4
        if ( 0 == $sorted_menu_item->menu_item_parent ) {
            if ( $count > $menu_limit ) {
                unset( $sorted_menu_items[$array_unset_value] );
                $unset_top_level_menu_item_ids[] = $sorted_menu_item->ID;
            }
            $count++;
        }

        // unset child menu items of unset top level menu items
        if ( in_array( $sorted_menu_item->menu_item_parent, $unset_top_level_menu_item_ids ) )
            unset( $sorted_menu_items[$array_unset_value] );

        $array_unset_value++;
    }

    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'my_nav_menu_objects', 10, 2 );

/**
 * Helper function to display a menu
 */
function include_menu( $location = false, $depth = 0, $class = false, $nav_id = false, $nav_class = false ) {

  if ( !$location ) {
    throw new Exception('theme_location is a required field for displaying a menu.');
  }

  $vars = array(
    'theme_location'      => $location,
    'menu_class'          => $class,
    'depth'               => $depth,
    'container_id'        => $nav_id,
    'container_class'     => $nav_class,
  );

  foreach ($vars as $k=>$v) {
    if ( !$v ) {
      unset($vars[$k]);
    }
  }

  wp_nav_menu($vars + array(
      'container'       	=> 'nav',
      'echo'            	=> true,
      'fallback_cb'       => 'wp_page_menu',
      'items_wrap'      	=> '<ul class="%2$s">%3$s</ul>',
      'walker'            => new Flo_Walker(),
    )
  );
}

/**
 * Custom navigation walker
 */
// require get_template_directory() . '/nav.php';

/**
 * Custom navigation walker
 */
require get_template_directory() . '/flo-walker.php';

/**
 * Custom comments
 */
function air_comments( $comment, $args, $depth ) {
$GLOBALS['comment'] = $comment; ?>

  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>">
        <?php echo get_avatar( $comment, $size = '62' ); ?>
        <h4 class="comment-author"><?php printf(__('<a href="#">%s</h4>'), get_comment_author_link()) ?></a>

      <?php if ( 0 === $comment->comment_approved ) : ?>
        <p><em>Kommenttisi odottaa ylläpidon hyväksymistä.</em></p>
      <?php endif; ?>

        <p class="comment-time">
          <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
            <svg width="16" height="16" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1520 1216q0-40-28-68l-208-208q-28-28-68-28-42 0-72 32 3 3 19 18.5t21.5 21.5 15 19 13 25.5 3.5 27.5q0 40-28 68t-68 28q-15 0-27.5-3.5t-25.5-13-19-15-21.5-21.5-18.5-19q-33 31-33 73 0 40 28 68l206 207q27 27 68 27 40 0 68-26l147-146q28-28 28-67zm-703-705q0-40-28-68l-206-207q-28-28-68-28-39 0-68 27l-147 146q-28 28-28 67 0 40 28 68l208 208q27 27 68 27 42 0 72-31-3-3-19-18.5t-21.5-21.5-15-19-13-25.5-3.5-27.5q0-40 28-68t68-28q15 0 27.5 3.5t25.5 13 19 15 21.5 21.5 18.5 19q33-31 33-73zm895 705q0 120-85 203l-147 146q-83 83-203 83-121 0-204-85l-206-207q-83-83-83-203 0-123 88-209l-88-88q-86 88-208 88-120 0-204-84l-208-208q-84-84-84-204t85-203l147-146q83-83 203-83 121 0 204 85l206 207q83 83 83 203 0 123-88 209l88 88q86-88 208-88 120 0 204 84l208 208q84 84 84 204z"/></svg>
            <time><?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()) ?></time>
          </a>
        </p>

        <?php comment_text() ?>

        <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        <?php edit_comment_link(__('&mdash; Edit'),'  ','') ?>

    </div>
<?php
}

/**
 * Remove WordPress Admin Bar when not on development env
 *
 * @link http://davidwalsh.name/remove-wordpress-admin-bar-css
 */
// add_action( 'get_header', 'air_remove_admin_login_header' );
// function air_remove_admin_login_header() {
//   remove_action( 'wp_head', '_admin_bar_bump_cb' );
// }

// if ( getenv( 'WP_ENV' ) === 'development' && is_user_logged_in() ) {
if ( WP_ENV === 'dev' && is_user_logged_in() ) {
  // Do Nothing
} else {
  show_admin_bar(false);
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function air_pingback_header() {
	if ( is_singular() && pings_open() ) :
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	endif;
}
add_action( 'wp_head', 'air_pingback_header' );

/**
 * Custom uploads folder media/ instead of default content/uploads/.
 * Comment these out if you want to set up media library folder in wp-admin.
 */
add_filter( 'option_uploads_use_yearmonth_folders', '__return_false', 100 );

if ( ! function_exists( 'air_entry_footer' ) ) :

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function air_entry_footer() {
  // Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'air' ) );
		if ( $categories_list ) { ?>
      <p class="cat"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'air' ) ); ?></p>
    <?php	}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'air' ) );
		if ( $tags_list ) { ?>
      <?php the_tags('<ul class="tags"><li>','</li><li>','</li></ul>'); ?>
		<?php }
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">
    <svg width="16" height="16" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1408 768q0 139-94 257t-256.5 186.5-353.5 68.5q-86 0-176-16-124 88-278 128-36 9-86 16h-3q-11 0-20.5-8t-11.5-21q-1-3-1-6.5t.5-6.5 2-6l2.5-5 3.5-5.5 4-5 4.5-5 4-4.5q5-6 23-25t26-29.5 22.5-29 25-38.5 20.5-44q-124-72-195-177t-71-224q0-139 94-257t256.5-186.5 353.5-68.5 353.5 68.5 256.5 186.5 94 257zm384 256q0 120-71 224.5t-195 176.5q10 24 20.5 44t25 38.5 22.5 29 26 29.5 23 25q1 1 4 4.5t4.5 5 4 5 3.5 5.5l2.5 5 2 6 .5 6.5-1 6.5q-3 14-13 22t-22 7q-50-7-86-16-154-40-278-128-90 16-176 16-271 0-472-132 58 4 88 4 161 0 309-45t264-129q125-92 192-212t67-254q0-77-23-152 129 71 204 178t75 230z"/></svg> ';
		comments_popup_link( sprintf( wp_kses( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'air' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'air' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<p class="edit-link">',
		'</p>'
	);
}
endif;

/**
 * Enqueue scripts and styles.
 */
function air_scripts() {
  // If you want to use a different CSS per view, you can set it up here
  $air_template = 'global';

  wp_enqueue_style( 'styles', get_template_directory_uri() . '/css/' . $air_template . '.css', array(), 'stuff' );
  wp_enqueue_script( 'jquery-core' );
  wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/all.js', array(), AIR_VERSION, true );
  wp_localize_script( 'scripts', 'screenReaderTexts', array(
		'expandMenu'            => esc_html__( 'MENU', 'air' ),
		'collapseMenu'          => esc_html__( 'CLOSE', 'air' ),
		'expandSubMenu'         => '<span class="screen-reader-text">' . esc_html__( 'Open sub menu', 'air' ) . '</span>',
		'collapseSubMenu'       => '<span class="screen-reader-text">' . esc_html__( 'Close sub menu', 'air' ) . '</span>',
	) );
  wp_localize_script( 'scripts', 'form', array(
		'submit_url' => admin_url( 'admin-ajax.php' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'air_scripts' );

// Custom hashing function for creating field and group keys for Custom Fields
function get_short_hash($groupID, $salt = 'thaw_design') {

  $hash = md5($groupID);
  $hash = substr($hash,0,13);

  return $hash;
}

// IMPORT CUSTOM POST TYPE DEFINITIONS
foreach( glob( get_template_directory() . "/custom-posts/*.php" ) as $filename ) {
    include $filename;
}

// Function to load all Custom Field Groups from code
function load_custom_field_groups() {

  $field_definitions = glob(get_template_directory() . '/custom-fields/*.php');

  foreach($field_definitions as $field_group){
      include $field_group;
  }
}
add_action('acf/init', 'load_custom_field_groups');


////////////////////////
// Hide Editor Panels //
////////////////////////

/*
*
*   Function:   hide_editor_panels
*   Usage:      Setup which post types will have which features hidden
*   Features:   'title'
*               'editor' (content)
*               'author'
*               'thumbnail' (featured image)
*               'excerpt'
*               'trackbacks'
*               'custom-fields'
*               'comments'
*               'revisions'
*               'page-attributes' (template and menu order)
*               'post-formats'
*
*/
function hide_editor_panels() {

  $to_hide = array(
    'page' => array(
      'editor',
      'author',
      'trackbacks',
      'custom-fields',
      'comments',
      'post-formats',
    ),
    'post' => array(
      // 'editor',
      'custom-fields',
    ),
  );

  foreach ($to_hide as $type => $features) {
    foreach ($features as $feature) {
      remove_post_type_support($type, $feature);
    }
  }

  // Get the Post ID.
  // $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

  // if( !isset( $post_id ) ) return;

  // Hide the editor on the page titled 'Homepage'
  // $homepgname = get_the_title($post_id);
  // if($homepgname == 'Homepage'){
    // remove_post_type_support('page', 'editor');
  // }

  // Hide the editor on a page with a specific page template
  // Get the name of the Page Template file.
  // $template_file = get_post_meta($post_id, '_wp_page_template', true);
  // if($template_file == 'my-page-template.php'){ // the filename of the page template
    // remove_post_type_support('page', 'editor');
  // }
}
add_action( 'admin_head', 'hide_editor_panels' );


//////////////////////////
// ACF Helper Functions //
//////////////////////////

/*
*
*   Function:   make_label
*   Accepts:    $name (string)
*   Usage:      Create a proper label from a field or group name
*   Example:    field_name --> Field Name
*   Returns:    string
*
*/
function make_label($name) {
  return ucwords(preg_replace('/[-_]+/',' ',$name));
}



/*
*
*   Function:   construct_acf_layouts
*   Accepts:    $arr (array)
*   Usage:      Construct a properly formatted array of layouts for our acf Custom Field Group
*   Returns:    array
*
*/
function construct_acf_layouts($arr) {

  // echo '<pre>';
  foreach ($arr as $k=>$v) {

    $v = array(
      'key' => get_short_hash($k),
      'name' => $k,
      'label' => make_label($k),
      'display' => 'row',
      'sub_fields' => construct_acf_fields($v,$k),
    );

    // Push the new dependency to $arr
    $arr[] = $v;

    // Cleanup $arr
    unset($arr[$k]);
  }

  // Return our newly constructed dependencies
  return $arr;
}



/*
*
*   Function:   construct_acf_dependencies
*   Accepts:    $arr (array)
*   Usage:      Construct a properly formatted array of dependency rules for our acf Custom Field Group
*   Returns:    array
*
*/
function construct_acf_dependencies($arr,$mod = false) {

  foreach ($arr as $k=>$v) {

    // If there is a modifier, apply it
    $modded = ( is_array($v) ? ( $mod ? $mod.'_'.$v[0] : $v[0]) : ( $mod ? $mod.'_'.$v : $v) );

    // if dependency is_array, then construct, else construct with defaults ( == '1')
    if (is_array($v)) {

      $v = array(
        'field' => 'field_' . get_short_hash($modded),
        'operator' => $v[1],
        'value' => $v[2],
      );
    } else {

      $v = array(
        'field' => 'field_' . get_short_hash($modded),
        'operator' => '==',
        'value' => '1',
      );
    }

    // Push the new dependency to $arr
    $arr[] = $v;

    // Cleanup $arr
    unset($arr[$k]);
  }

  // Wrap $arr in another array to force 'and' ruleset (Need to build in model for 'or' logic as well)
  $arr = array($arr);

  // Return our newly constructed dependencies
  return $arr;
}



/*
*
*   Function:   construct_acf_fields
*   Accepts:    $arr (array)
*   Usage:      Construct a properly formatted array of fields for our acf Custom Field Group
*   Returns:    array
*
*/
function construct_acf_fields($arr,$mod = false) {

  foreach ($arr as $k=>$v) {

    // If 'label' is defined, use that, otherwise create it from the field name
    if (!(isset($v['label']))) {
      $v = array('label' => make_label($k)) + $v;
    }

    // Set our field name
    $v = array('name' => $k) + $v;

    // Apply a modifier if present
    $modded = ( $mod ? $mod.'_'.$k : $k);

    // Generate our 'unique' key for this field
    $v = array('key' => 'field_' . get_short_hash($modded)) + $v;

    // If there are dependencies, construct them properly
    if (isset($v['depends'])) {
      $v['conditional_logic'] = construct_acf_dependencies($v['depends'], $mod);
      unset($v['depends']);
    }

    // If there are layouts, construct them properly
    if (isset($v['layouts'])) {
      $v['layouts'] = construct_acf_layouts($v['layouts']);
    }

    // Push our new array of fields to $arr
    $arr[] = $v;

    // Cleanup $arr
    unset($arr[$k]);
  }

  // d($arr);
  // Return our new array of fields
  return $arr;
}



/*
*
*   Function:   construct_acf_locations
*   Accepts:    $arr (array)
*   Usage:      Construct a properly formatted array of location rules for our acf Custom Field Group
*   Returns:    array
*
*/
function construct_acf_locations($arr) {

  foreach ($arr as $k=>$v) {

    foreach ($v as $val=>$op) {

      // Build inner array from nested vars
      // Wrap $arr in another array to force 'or' ruleset (Need to build in model for 'and' logic as well)
      $arr[] = array(
        array(
          'param' => $k,
          'operator' => $op,
          'value' => $val,
        ),
      );
    }

    unset($arr[$k]);
  }

  // Return our newly constructed locations
  return $arr;
}



/*
*
*   Function:   construct_acf_array
*   Accepts:    $arr (array)
*   Usage:      Construct a properly formatted array for creating acf Custom Fields
*   Returns:    array
*   Samples:    'hide_on_screen' => array (
*                 0 => 'permalink',
*                 1 => 'the_content',
*                 2 => 'excerpt',
*                 3 => 'custom_fields',
*                 4 => 'discussion',
*                 5 => 'comments',
*                 6 => 'revisions',
*                 7 => 'slug',
*                 8 => 'author',
*                 9 => 'format',
*                 10 => 'page_attributes',
*                 11 => 'featured_image',
*                 12 => 'categories',
*                 13 => 'tags',
*                 14 => 'send-trackbacks',
*                ),
*
*/
function construct_acf_array($arr) {

  foreach ($arr as $gn=>$gd) {

    // If 'title' is defined, use that, otherwise create it from the group name
    if ( !(isset($gd['title'])) ) {
      $gd = array('title' => make_label($gn)) + $gd;
    }

    // Generate our 'unique' key for this group
    $gd = array('key' => 'group_' . get_short_hash($gn)) + $gd;

    // Construct the proper array for the fields
    ( (isset($gd['fields'])) ? $gd['fields'] = construct_acf_fields($gd['fields']) : $noop );

    // Construct the proper array for the locations
    ( (isset($gd['location'])) ? $gd['location'] = construct_acf_locations($gd['location']) : $noop );

    // Push back to our parent array
    $arr[] = $gd;

    // Cleanup the parent array and the temp array for the next round
    unset($arr[$gn]);
  }

  return $arr;
}

///////////////////////////
// Maps Helper Functions //
///////////////////////////

function simple_locator_infowindow_flo($infowindow) {

  $id = $title = '';
  $dom = new DOMDocument();
  $dom->loadHTML($infowindow);

  $tmp = $dom->getElementsByTagName("a");

  foreach ($tmp as $v) {
    $id = $v->getAttribute("data-location-id");
  }

  $tmp = $dom->getElementsByTagName("h4");

  foreach ($tmp as $v) {
    $title = trim(preg_replace("/[\r\n]+/", " ", $v->nodeValue));
  }

  $infowindow = '<h4 class="awesome">'.$title.'</h4>'.'<a href="#" onClick="event.preventDefault(); get_directions('.$id.');">Get Directions - <i class="fa fa-fw fa-map-o"></i></a>';
  return $infowindow;
} add_filter('simple_locator_infowindow','simple_locator_infowindow_flo');

// Function to create new Contact Form Entry in WP
function create_contact_form_entry( $fields = false ) {

  if ( $fields === false || count($fields) < 1 ) {
    return 'Missing fields on contact creation';
  }

  foreach ($fields as $key=>$val) {
    if ( !strlen($val) ) {
      return 'Fields are empty';
    }
  }

  $new_contact = array(
  	'post_title'	=> $fields['email'],
  	'post_type'		=> 'contacts',
  	'post_status'	=> 'publish'
  );

  $post_id = wp_insert_post( $new_contact );

  if ( !$post_id ) {
    return 'Failed to submit your contact';
  }

  // save a basic text value
  $keys = array(
    'first' => 'field_'.get_short_hash('contact_first_name'),
    'last' => 'field_'.get_short_hash('contact_last_name'),
    'email' => 'field_'.get_short_hash('contact_email'),
    'message' => 'field_'.get_short_hash('contact_message'),
  );

  foreach ($keys as $k=>$v) {
    update_field( $v, $fields[$k], $post_id );
  }

  $mailsender = $fields['first'] . ' ' . $fields['last'] . ' <' . $fields['email'] . '>';
  $mailheaders = array(
    'From: ' . $mailsender,
    'Reply-To: ' . $mailsender,
  );
  $mailsubject = 'New customer contact from the website!';
  $mailstring = PHP_EOL . $fields['first'] . ' ' . $fields['last'] . 'writes:' . PHP_EOL;
  $mailstring .= PHP_EOL . 'Message:' . PHP_EOL . $fields['message'] . PHP_EOL;
  $mailstring .= PHP_EOL . 'Please respond at your earliest convenience.';

  wp_mail('info@focusedlabs.com',$mailsubject,$mailstring,$mailheaders);

  return true;
}

// function to handle form AJAX call
function form_submit_actions() {

  $form_data = $_POST['fields'];

  if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

    $response = create_contact_form_entry( $form_data );

    if ( $response === false ) {
      echo 'Something went wrong creating the contact';
      wp_die();
    } else {

      echo $response;
    }
	} else {

    echo "Looks like you don't support AJAX";
  }
  wp_die();
} add_action( 'wp_ajax_nopriv_post_form_send_form', 'form_submit_actions' );
add_action( 'wp_ajax_post_form_send_form', 'form_submit_actions' );
