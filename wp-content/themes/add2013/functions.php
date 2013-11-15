<?php

function add_setup() {
  add_theme_support('automatic-feed-links');

  add_theme_support('post-thumbnails');
  add_image_size( 'sponsor', '171', '83', false );
}
add_action( 'after_setup_theme', 'add_setup' );

function add_init_scripts() {
  if(!is_admin()){
    wp_register_script( 'modernizr', get_bloginfo('template_url') . '/assets/js/vendor/modernizr-2.6.2.min.js', array(), '2.6.2', false );
    wp_register_script( 'main', get_bloginfo('template_url') . '/assets/js/main.min.js', array('jquery'), '1.0', true );
  }
}
add_action( 'init', 'add_init_scripts' );

function add_scripts() {
  // JS
  wp_enqueue_script( 'modernizr' );
  wp_enqueue_script( 'main' );

  // CSS
  wp_enqueue_style( 'add-gumby', get_stylesheet_directory_uri() . '/assets/css/gumby.css' );
  wp_enqueue_style( 'add-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'add_scripts' );

function add_stylesheet_uri($stylesheet_uri, $stylesheet_dir_uri) {
  $stylesheet_dir_uri = get_stylesheet_directory_uri();
  return $stylesheet_dir_uri . '/assets/css/style.css';
}
add_filter( 'stylesheet_uri', 'add_stylesheet_uri', 10, 2);

function add_wp_title( $title, $sep ) {
  global $paged, $page;

  if ( is_feed() )
    return $title;

  // Add the site name.
  $title .= get_bloginfo( 'name' );

  // Add the site description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    $title = "$title $sep $site_description";

  // Add a page number if necessary.
  if ( $paged >= 2 || $page >= 2 )
    $title = "$title $sep " . sprintf( __( 'Page %s', 'add' ), max( $paged, $page ) );

  return $title;
}
add_filter( 'wp_title', 'add_wp_title', 10, 2 );

// function add_register_sidebars() {
//   register_sidebar(array(
//     'id' => 'blog',
//     'name' => 'Blog',
//     'description' => '',
//     'before_widget' => '<aside id="recent-posts-" class="widget widget_recent_entries">',
//     'after_widget' => '</aside>',
//     'before_title' => '<h3 class="widget-title">',
//     'after_title' => '</h3>',
//   ));
//   register_sidebar(array(
//     'id' => 'instagram',
//     'name' => 'Instagram',
//     'description' => '',
//     'before_widget' => '<div class="carousel_index"><div id="foo2">',
//     'after_widget' => '</div><div class="clearfix"></div><a class="prev" id="foo2_prev" href="#"><span></span></a> <a class="next" id="foo2_next" href="#"><span></span></a><div class="pagination" id="pagination"></div></div>',
//     'before_title' => '',
//     'after_title' => '',
//   ));
// }
// add_action( 'widgets_init', 'add_register_sidebars' );
