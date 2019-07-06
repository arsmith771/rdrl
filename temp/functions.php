<?php

/*==================================================
=            Starter Theme Introduction            =
==================================================*/

/**
 *
 * About Starter
 * --------------
 * Starter is a project by Calvin Koepke to create a starter theme for Genesis Framework developers that doesn't over-bloat
 * their starting base. It includes commonly used templates, codes, and styles, along with optional SCSS and Gulp tasking.
 *
 * Credits and Licensing
 * --------------
 * Starter was created by Calvin Koepke, and is under GPL 2.0+.
 *
 * Find me on Twitter: @cjkoepke
 *
 */


/*============================================
=            Begin Functions File            =
============================================*/

/**
 *
 * Define Child Theme Constants
 *
 * @since 1.0.0
 *
 */
define( 'CHILD_THEME_NAME', 'rdrl' );
define( 'CHILD_THEME_AUTHOR', '' );
define( 'CHILD_THEME_AUTHOR_URL', '' );
define( 'CHILD_THEME_URL', '' );
define( 'CHILD_THEME_VERSION', '1.1.0' );
define( 'TEXT_DOMAIN', 'rdrl' );

/**
 *
 * Start the engine
 *
 * @since 1.0.0
 *
 */
include_once( get_template_directory() . '/lib/init.php');

/**
 *
 * Load files in the /assets/ directory
 *
 * @since 1.0.0
 *
 */
add_action( 'wp_enqueue_scripts', 'startertheme_load_assets' );
function startertheme_load_assets() {

	// Load fonts.
	

	// Load JS.
	wp_enqueue_script( 'startertheme-global', get_stylesheet_directory_uri() . '/build/js/global.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	// Load default icons.
	wp_enqueue_style( 'dashicons' );

	// Load responsive menu.
	 /*
	$suffix = defined( SCRIPT_DEBUG ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'startertheme-responsive-menu', get_stylesheet_directory_uri() . '/build/js/responsive-menus' . $suffix . '.js', array( 'jquery', 'startertheme-global' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'startertheme-responsive-menu',
		'genesis_responsive_menu',
	 	starter_get_responsive_menu_args()
	);
	*/

}

// Admin css
add_action('admin_enqueue_scripts', 'admin_styles');
function admin_styles() {
    wp_enqueue_style('backend-admin', get_stylesheet_directory_uri() . '/admin.css');
}

/**
 * Set the responsive menu arguments.
 *
 * @return array Array of menu arguments.
 *
 * @since 1.1.0
 */
function starter_get_responsive_menu_args() {

	$args = array(
		'mainMenu'         => __( 'Menu', TEXT_DOMAIN ),
		'menuIconClass'    => 'dashicons-before dashicons-menu',
		'subMenu'          => __( 'Menu', TEXT_DOMAIN ),
		'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
				'.nav-secondary',
			),
			'others'  => array(
				'.nav-footer',
				'.nav-sidebar',
			),
		),
	);

	return $args;

}

/**
 *
 * Add theme supports
 *
 * @since 1.0.0
 *
 */
add_theme_support( 'genesis-responsive-viewport' ); /* Enable Viewport Meta Tag for Mobile Devices */
add_theme_support( 'html5',  array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) ); /* HTML5 */
add_theme_support( 'genesis-accessibility', array( 'skip-links', 'search-form', 'drop-down-menu', 'headings' ) ); /* Accessibility */
add_theme_support( 'genesis-after-entry-widget-area' ); /* After Entry Widget Area */
add_theme_support( 'genesis-footer-widgets', 3 ); /* Add Footer Widgets Markup for 3 */


/**
 *
 * Apply custom body classes
 *
 * @since 1.0.0
 * @uses /lib/classes.php
 *
 */
include_once( get_stylesheet_directory() . '/lib/classes.php' );

/**
 *
 * Apply Starter Theme defaults (overrides default Genesis settings)
 *
 * @since 1.0.0
 * @uses /lib/defaults.php
 *
 */
include_once( get_stylesheet_directory() . '/lib/defaults.php' );

/**
 *
 * Apply Starter Theme default attributes
 *
 * @since 1.0.0
 * @uses /lib/attributes.php
 *
 */
include_once( get_stylesheet_directory() . '/lib/attributes.php' );

//------------------------- Image sizes -------------
add_image_size( 'header-image', 2000, 810, true ); // width, height, crop
add_image_size( 'header-image-small', 768, 768, true ); // width, height, crop
add_image_size( 'thumbnail-small', 400, 300, true ); // width, height, crop
add_image_size( 'thumbnail-medium', 360, 473, true ); // width, height, crop
add_image_size( 'thumbnail-large', 768, 576, true ); // width, height, crop
add_image_size( 'letterbox', 900, 400, true ); // width, height, crop


// Disable the superfish script
add_action( 'wp_enqueue_scripts', 'sp_disable_superfish' );
function sp_disable_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}


// Adding Dashicons in WordPress Front-end
add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
  wp_enqueue_style( 'dashicons' );
}

// Homepage - move entry title to head
add_action( 'genesis_meta', 'reposition_entry_header_elements' );
function reposition_entry_header_elements() {
    
if ( is_page_template('page-home.php') ) {
    
    remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
    remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
    add_action( 'genesis_header', 'genesis_entry_header_markup_open', 11 );
    add_action( 'genesis_header', 'genesis_do_post_title', 12 );
    add_action( 'genesis_header', 'genesis_entry_header_markup_close', 17 );
    
    }
    
}

// Output menu toggle
add_filter( 'genesis_header', 'output_menu_toggle', 12 );
function output_menu_toggle(){

		echo '<button class="menu-toggle" id="menu-toggle"></button>';
	
}

// Output header cta
add_filter( 'genesis_header', 'output_home_header_cta', 13 );
function output_home_header_cta(){
	if ( is_page_template('page-home.php') ) {
		echo '<a href="#" class="cta cta--cta-3 txt-4">Our Approach</a>';
	}
}

// Projects Landing page - Remove the default entry header markup
add_action( 'genesis_before', 'prefix_remove_entry_header' );
function prefix_remove_entry_header(){
	if ( is_page_template('projects-landing.php') ) {
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 4 );
	}
}

// Ouput head image in Homepage
add_filter( 'genesis_header', 'output_head_image_home', 15 );
function output_head_image_home(){
	if ( is_page_template('page-home.php') ) {
		echo '<style> .site-header {background-image: url(' . types_render_field( 'home-header-image', array('url' => 'true', 'size' => 'header-image-small') ) .'); } @media screen and (min-width: 768px) { .site-header { background-image: url(' . types_render_field( 'home-header-image', array( "size" => "header-image", "url" => "true" ) ) .');}} </style>';
	}	
}

// Ouput head image in Projects Landing page
add_filter( 'genesis_header', 'output_head_image_proj_landing', 10 );
function output_head_image_proj_landing(){
	if ( is_page_template('projects-landing.php') ) {
		echo '<style> .site-header {background-image: url(' . types_render_field( 'projects-landing-header-image', array('url' => 'true') ) .')}; </style>';
	}	
}

// Ouput head image in Contact page
add_filter( 'genesis_header', 'output_head_image_contact', 10 );
function output_head_image_contact(){
	if ( is_page_template('page-contact.php') ) {
		echo '<style> .site-header {background-image: url(' . types_render_field( 'contact-header-image', array('url' => 'true') ) .')}; </style>';
	}	
}

// Ouput contact page content
add_filter( 'genesis_entry_content', 'contact_page', 10 );
function contact_page(){
	if ( is_page_template('page-contact.php') ) {
		echo types_render_field( 'contact-content', array() );
		/*
		echo '<div class="dflex dflex--wrap dflex--between contact-map-form">' . do_shortcode('[contact-form-7 id="228" title="Contact form 1"]') . '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2242.787957867692!2d-4.300739784097412!3d55.796919780565226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x488847bf75497a9d%3A0xa7068263edf8afc5!2s295+Fenwick+Rd%2C+Giffnock%2C+Glasgow+G46+6QA!5e0!3m2!1sen!2suk!4v1551189330741" frameborder="0" allowfullscreen></iframe></div>';
		*/
		echo '<div class="dflex dflex--wrap dflex--between contact-map-form">' . do_shortcode('[contact-form-7 id="228" title="Contact form 1"]') . '</div>';
	}	
}

// Ouput head image in Project single
add_filter( 'genesis_header', 'output_head_image_projects', 10 );
function output_head_image_projects(){
	if ( is_singular( 'projects' ) ) {
		echo '<style> .site-header { background-image: url(' . types_render_field( 'header-image-projects', array( "size" => "header-image-small", "url" => "true" ) ) .'); } @media screen and (min-width: 768px) { .site-header { background-image: url(' . types_render_field( 'header-image-projects', array( "size" => "header-image", "url" => "true" ) ) .');}} </style>';
	}	
}

// Ouput head image in Service
add_filter( 'genesis_header', 'output_head_image_services', 10 );
function output_head_image_services(){
	if ( is_singular( 'services' ) ) {
		echo '<style> .site-header {background-image: url(' . types_render_field( 'services-header-image', array('url' => 'true') ) .')}; </style>';
	}	
}

//* Output footer content
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = '<p><span style="position:relative; left:-5px;">Designed by <a href="https://orbit.scot" target="_blank" style="color:#fff;">Orbit Communications</a>.</span> Copyright ' . do_shortcode('[footer_copyright]') . ' RDRL</p><nav class="menu-footer" itemscope="" itemtype="https://schema.org/SiteNavigationElement"><ul class="menu-footer"><li class="menu-footer__item"><a href="' . home_url() . '/privacy-policy/" class="menu-footer__lnk">Privacy, Cookies &amp; Legal </a></li class="menu-footer__item"><li class="menu-footer__item"><a href="' . home_url() . '/terms-conditions/" class="menu-footer__lnk">Terms and Conditions</a></li><li class="menu-footer__item"><a href="#" target="_blank" class="menu-footer__lnk">Follow us on Twitter</a></li></ul></nav>';

	return $creds;
}

// Custom menu shortcode
add_action( 'init', 'my_custom_menus' );
function my_custom_menus() {
    register_nav_menus(
        array(
        //    'primary-menu' => __( 'Primary Menu' ),
  		//'secondary-menu' => __( 'Secondary Menu' ),
         //   'footer-left' => __( 'Footer Left' ),
		//	'footer-right' => __( 'Footer Right' ),
		//	'sitemap' => __( 'Sitemap' )
			'services-menu' => __( 'Services' )
        )
    );
}

function print_menu_shortcode($atts, $content = null) {
extract(shortcode_atts(array( 'name' => null, ), $atts));
return wp_nav_menu( array( 'menu' => $name, 'echo' => false ) );
}
add_shortcode('menu', 'print_menu_shortcode');


//* Output Homepage services menu

/*
add_action('genesis_header', 'home_services_menu', 11 );
function home_services_menu(){

	if ( is_page_template('page-home.php') ) {
		echo do_shortcode('[menu name="services-menu"]');
	}
}
*/


//* Output Projects single page title & location
add_action('genesis_header', 'output_project_title', 11 );
function output_project_title(){

	if ( is_singular( 'projects' ) ) {
		echo '<div class="head-title"><h1 class="entry-title txt-1" itemprop="headline">' . do_shortcode('[wpv-post-title]') . '</h1>';
		echo '<p class="txt-2 mb-0"><span class="head-title__prop">Location:</span> ' . types_render_field( 'project-location-2', array() ) . '</p></div>';
	}
}

//*---------------- Build the primary nav from CPTs - About, Services, Projects -----------------*

// About
add_action('genesis_header', 'output_about_menu', 13 );
function output_about_menu(){

// Define the WP query
$args = array(
    'post_type' => 'about-us',//Swap in your CPT
    'posts_per_page' => -1,
);

$query = new WP_Query( $args );

	if ($query->have_posts()) {
     
    // Output the post titles in a list
    echo '<nav class="nav-primary genesis-responsive-menu" aria-label="Main" itemscope="" itemtype="https://schema.org/SiteNavigationElement" id="genesis-nav-primary">';
    	echo '<ul id="menu-main-nav" class="menu genesis-nav-menu menu-primary">';
    		echo '<li class="menu-item menu-item-type-post_type"><a href="' . home_url() .'/about-us/what-we-do/">About</a>';
    			echo '<ul class="sub-menu">';
     
       			 // Start the Loop
        		while ( $query->have_posts() ) : $query->the_post(); ?>
 
        		<li class="menu-item menu-item-type-post_type" id="post-<?php the_ID(); ?>">
           		 <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        		</li>
         
        		<?php endwhile;
         
        		echo '</ul>';   
        	echo '</li>';   
	}
     
// Reset the WP Query
wp_reset_postdata();

}

// Services
/*
add_action('genesis_header', 'output_services_menu', 14 );
function output_services_menu(){

// Define the WP query
$args = array(
    'post_type' => 'services',//Swap in your CPT
    'posts_per_page' => -1,
);

$query = new WP_Query( $args );

	if ($query->have_posts()) {
     
    // Output the post titles in a list
    echo '<li class="menu-item menu-item-type-post_type"><a href="' . home_url() .'/services/renewables/">Services</a>';
    echo '<ul class="sub-menu" id="services-menu">';
     
        // Start the Loop
        while ( $query->have_posts() ) : $query->the_post(); ?>
 
        <li  class="menu-item menu-item-type-post_type" id="post-<?php the_ID(); ?>">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
         
        <?php endwhile;
         
        echo '</ul></li>';      
	}
     
	// Reset the WP Query

	wp_reset_postdata();

}
*/

// Projects
add_action('genesis_header', 'output_projects_menu', 14 );
function output_projects_menu(){

// Define the WP query
$args = array(
    'post_type' => 'projects',//Swap in your CPT
    'posts_per_page' => -1,
);

$query = new WP_Query( $args );

	if ($query->have_posts()) {
     
    // Output the post titles in a list
    echo '<li class="menu-item menu-item-type-post_type"><a href="' . home_url() .'/projects/">Projects</a>';
    	echo '<ul class="sub-menu" id="projects-menu">';
     
        // Start the Loop
        while ( $query->have_posts() ) : $query->the_post(); ?>
 
        <li  class="menu-item menu-item-type-post_type" id="post-<?php the_ID(); ?>">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
         
        <?php endwhile;
        
        echo '</ul></li>';
            
	}
     
	// Reset the WP Query
	wp_reset_postdata();

}


// And finally add the Contact menu item
add_action('genesis_header', 'output_contact_menu', 14 );
function output_contact_menu(){

		echo '<li  class="menu-item menu-item-type-post_type"><a href="' . home_url() . '/contact/">Contact</a></li>';
	echo '</ul></nav>'; 
}

//* -------------------- Homepage output ------------------------

// Service menu for homepage header
/*
add_action('genesis_entry_content', 'output_home_services', 10 );
function output_home_services(){
	if ( is_page_template('page-home.php') ) {
	// Define the WP query
	$args = array(
    	'post_type' => 'services',
    	'posts_per_page' => -1,
	);

	$query = new WP_Query( $args );

	if ($query->have_posts()) {
     
    // Output the post titles in a list
    echo '<nav id="services-menu--home" class="services-menu services-menu--home genesis-responsive-menu" itemscope="" itemtype="https://schema.org/SiteNavigationElement">';
    	echo '<ul class="menu genesis-nav-menu">';
     
        // Start the Loop
        while ( $query->have_posts() ) : $query->the_post(); ?>
 
        <li  class="menu-item menu-item-type-post_type" id="post-<?php the_ID(); ?>">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
         
        <?php endwhile;
         
        echo '</ul>';     
     echo '</nav>';   
	}
     
	// Reset the WP Query
	wp_reset_postdata();
	}
}
*/

//* Row 1
add_action('genesis_entry_content', 'output_home_10', 10 );
function output_home_10(){
	if ( is_page_template('page-home.php') ) {
		echo '<div class="row row--p-0"><div class="wrap"><div class="block-1 block-1--first clearfix">';
			echo types_render_field( 'home-row-1-first-image', array("size" => "thumbnail-large", "class" => "block-1__img block-1__img--left h-blue", 'alt' => '%%ALT%%') );
			echo types_render_field( 'home-row-1-second-image', array("size" => "thumbnail-large", "class" => "block-1__img block-1__img--right h-green", 'alt' => '%%ALT%%') );
		echo '</div></div></div>';
	}
}

//* Row 2
add_action('genesis_entry_content', 'output_home_11', 11 );
function output_home_11(){
	if ( is_page_template('page-home.php') ) {
		echo '<div class="row row--p-1"><div class="wrap"><div class="block-1 block-1--first clearfix">';
			//echo '';
			echo '<div class="block-1__img block-1__img--left h-pink"><h2 class="txt-6 h-pink">' . types_render_field( 'home-row-2-text-header', array("output" => "raw") ) . '</h2><p>' . types_render_field( 'home-row-2-text', array("output" => "raw") ) . '</p><a href="' . home_url() . '/projects/" class="cta txt-4 fr">Our projects</a></div>';
			echo '<div class="block-1__img block-1__img--right h-aquamarine"><blockquote class="quote quote--stat"><p class="quote__quoted txt-2">' . types_render_field( 'home-row-2-quote', array("output" => "raw") ) . '</p>' . types_render_field( 'home-row-2-quote-source', array("output" => "raw") ) . '</blockquote></div>';
		echo '</div></div></div>';
	}
}

//* Row 3
add_action('genesis_entry_content', 'output_home_12', 12 );
function output_home_12(){
	if ( is_page_template('page-home.php') ) {
		echo '<div class="row"><div class="wrap">';
			echo types_render_field( 'home-row-3-image', array("size" => "letterbox", 'alt' => '%%ALT%%', 'class' => 'h-orange') );
		echo '</div></div>';
	}
}

//* Row 4
add_action('genesis_entry_content', 'output_home_13', 13 );
function output_home_13(){
	if ( is_page_template('page-home.php') ) {
		echo '<div class="row row--p-1"><div class="wrap"><div class="block-1 block-1--first clearfix">';		
			echo '<div class="block-1__img block-1__img--left block-1__img--v-mid">' . types_render_field( 'row-4-image', array('size' => 'thumbnail-large', 'alt' => '%%ALT%%', 'class' => 'h-fuchsia' ) ) . '</div>';
			echo '<div class="block-1__img block-1__text--right block-1__img--v-mid h-chocolate"><h2 class="txt-6">' . types_render_field( 'home-row-4-text-header', array() ) . '</h2><p>' . types_render_field( 'home-row-4-text-below-header', array() ) . '</p><a href="' . home_url() . '/projects/" class="cta txt-4 fr">Our projects</a></div>';
		echo '</div></div></div>';
	}
}

//* -------------------- end Homepage output ------------------------


// Service menu for single service
add_action('genesis_entry_content', 'output_services_menu_content', 9 );
function output_services_menu_content(){
	if ( is_singular( 'services' ) ) {
	// Define the WP query
	$args = array(
    	'post_type' => 'services',//Swap in your CPT
    	'posts_per_page' => -1,
	);

	$query = new WP_Query( $args );

	if ($query->have_posts()) {
     
    // Output the post titles in a list
    echo '<nav class="services-menu genesis-responsive-menu" itemscope="" itemtype="https://schema.org/SiteNavigationElement">';
    	echo '<ul class="menu genesis-nav-menu dflex dflex--center">';
     
        // Start the Loop
        while ( $query->have_posts() ) : $query->the_post(); ?>
 
        <li  class="menu-item menu-item-type-post_type" id="post-<?php the_ID(); ?>">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
         
        <?php endwhile;
         
        echo '</ul>';     
     echo '</nav>';   
	}
     
	// Reset the WP Query
	wp_reset_postdata();
	}
}

// About menu for single About
add_action('genesis_entry_content', 'output_about_menu_content', 9 );
function output_about_menu_content(){
	if ( is_singular( 'about-us' ) ) {
	// Define the WP query
	$args = array(
    	'post_type' => 'about-us',//Swap in your CPT
    	'posts_per_page' => -1,
	);

	$query = new WP_Query( $args );

	if ($query->have_posts()) {
     
    // Output the post titles in a list
    echo '<nav class="about-menu genesis-responsive-menu" itemscope="" itemtype="https://schema.org/SiteNavigationElement">';
    	echo '<ul class="menu genesis-nav-menu dflex">';
     
        // Start the Loop
        while ( $query->have_posts() ) : $query->the_post(); ?>
 
        <li  class="menu-item menu-item-type-post_type" id="post-<?php the_ID(); ?>">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
         
        <?php endwhile;
         
        echo '</ul>';     
     echo '</nav>';   
	}
     
	// Reset the WP Query
	wp_reset_postdata();
	}
}

// Ouput entry header in Service single
add_filter( 'genesis_entry_content', 'output_entry_header_services', 8 );
function output_entry_header_services(){
	if ( is_singular( 'services' ) ) {
		echo '<header class="entry-header dflex dflex--between"><h1 class="entry-title" itemprop="headline">Services</h1>
  <p class="strapline txt-2"><span>We approach every project with an holistic view</span></p>
</header>';
	}	
}

// Ouput entry header in About single
add_filter( 'genesis_entry_content', 'output_entry_header_about', 8 );
function output_entry_header_about(){
	if ( is_singular( 'about-us' ) ) {
		echo '<header class="entry-header dflex dflex--between"><h1 class="entry-title" itemprop="headline">About</h1>
  <p class="strapline txt-2"><span>Our people are the heart of our buisness</span></p></header>';
	}	
}

// Ouput head image in About page
add_filter( 'genesis_header', 'output_head_image_about', 10 );
function output_head_image_about(){
	if ( is_singular( 'about-us' ) ) {
		echo '<style> .site-header {background-image: url(' . types_render_field( 'about-header-image', array('url' => 'true') ) .')}; </style>';
	}	
}

// Ouput head image in Generic page
add_filter( 'genesis_header', 'output_head_image_generic', 10 );
function output_head_image_generic(){
	if ( is_page_template('page-generic.php') ) {
		echo '<style> .site-header {background-image: url(' . types_render_field( 'generic-header-image', array('url' => 'true') ) .')}; </style>';
	}	
}
// Ouput Generic page content
add_filter( 'genesis_entry_content', 'output_generic_page', 10 );
function output_generic_page(){
	if ( is_page_template('page-generic.php') ) {

		echo types_render_field( 'generic-page-content', array() );

	}
}

// Add search hide/show

add_filter( 'genesis_header', 'search_hide_show', 11 );
function search_hide_show(){

		echo '<a href="#" id="search-icon" class="search-toggle"></a>';

}

// Contact us cta tab
add_filter( 'genesis_footer', 'footer_tab', 13 );
function footer_tab(){

		echo '<a href="' .home_url() .'/contact/" class="footer-cta-tab">Contact us</a>';

}