<?php

function add_setup() {
  add_theme_support('automatic-feed-links');

  add_theme_support('post-thumbnails');
  add_image_size( 'speaker', '376', '222', true );
  add_image_size( 'schedule', '70', '70', true );
  add_image_size( 'sponsor', '171', '83', false );
}
add_action( 'after_setup_theme', 'add_setup' );

function add_init_scripts() {
  if(!is_admin()){
    wp_register_script( 'modernizr', get_bloginfo('template_url') . '/assets/js/vendor/modernizr-2.6.2.min.js', array(), '2.6.2', false );
    wp_register_script( 'main', get_bloginfo('template_url') . '/assets/js/main.min.js', array('jquery'), '1.0', true );
  }
new AddBackgroundSettings();
}
add_action( 'init', 'add_init_scripts' );

function add_scripts() {
  // JS
  wp_enqueue_script( 'modernizr' );
  wp_enqueue_script( 'main' );

  // CSS
  // wp_enqueue_style( 'add-gumby', get_stylesheet_directory_uri() . '/assets/css/gumby.css' );
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

class AddBackgroundSettings {
  public function __construct(){
    add_action( 'admin_menu', array( &$this, 'menu' ) );
    add_action( 'admin_init', array( &$this, 'admin' ) );
  }

  public function menu() {
    add_options_page( 'Inscrições Confirmadas', 'Inscrições', 'manage_options', 'add', array( &$this, 'page' ) );
  }

  public static function getSettings() {
    $defaults = array(
      'inscritos' => '0',
    );
    return wp_parse_args( get_option( 'add' ), $defaults );
  }

  public function page() {
    global $title;
    ?>
    <div class="wrap">
      <h2><?php echo $title; ?></h2>
      <form action="options.php" method="POST">
        <?php settings_fields( 'add-group' ); ?>
        <?php do_settings_sections( 'add' ); ?>
        <?php submit_button(); ?>
      </form>
    </div>
    <?php
  }

  public function admin() {
    $settings = AddBackgroundSettings::getSettings();
    register_setting( 'add-group', 'add', array( &$this, 'add_validate' ) );
    add_settings_section( 'add_section', 'Dados do PagSeguro', array( &$this, 'add_section' ), 'add' );
    add_settings_field( 'add_inscritos', 'Quantidade de inscritos', array( &$this, 'text_input' ), 'add', 'add_section', array(
        'name' => 'inscritos',
        'type' => 'number',
        'value' => $settings['inscritos'],
      )
    );
  }

  public function add_section() {
    ?>
    <p>Preencha a quantidade de inscritos confirmados para pintar o background da capa</p>
    <?php
  }

  public function add_validate( $input ) {
    $output = get_option( 'add' );
    if ( !empty( $input['inscritos'] ) ) {
      $output['inscritos'] = $input['inscritos'];
    } else { 
      add_settings_error( 'add', 'invalid-inscritos', 'Preencha a quantidade de inscritos confirmados do evento' );
    }
    return $output;
  }

  public function text_input( $args ) {
    $defaults = array(
      'type' => 'text',
    );
    $args = wp_parse_args( $args, $defaults );
    $name = esc_attr( $args['name'] );
    $value = esc_attr( $args['value'] );
    $type = esc_attr( $args['type'] );
    echo '<input type="' . $type . '" class="widefat" name="add[' . $name . ']" value="' . $value . '" />';
  }
}
