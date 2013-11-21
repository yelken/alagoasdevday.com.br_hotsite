<?php
class Partners {
	var $meta_fields = array( 'url' );

	function __construct(){
		// Registrar custom post types - http://codex.wordpress.org/Function_Reference/register_post_type
		$labels = array(
			'name' => 'Patrocinadores',
			'singular_name' => 'Patrocinador',
			'add_new' => 'Adicionar novo',
			'add_new_item' => 'Adicionar novo patrocinador',
			'edit_item' => 'Editar Patrocinador',
			'new_item' => 'Novo Patrocinador',
			'all_items' => 'Todos os Patrocinadores',
			'view_item' => 'Ver Patrocinador',
			'search_items' => 'Pesquisar Patrocinador',
			'not_found' =>  'Nenhum patrocinador encontrado',
			'not_found_in_trash' => 'Nenhum patrocinador encontrado na lixeira',
			'parent_item_colon' => 'Patrocinador pai',
			'menu_name' => 'Patrocinadores'
		);
		$args = array(
			'labels' => $labels,
			'description' => '',
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => NULL,
			'menu_icon' => NULL,
			'hierarchical' => false,
			'supports' => array('title', 'thumbnail'),
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'patrocinador',
				'with_front' => true,
				'feeds' => true,
				'pages' => true,
			),
			'taxonomies' => array(
			),
			'query_var' => 'patrocinador',
			'can_export' => true,
			'show_in_nav_menus' => false,
			'capability_type' => 'post',
		);
		register_post_type('patrocinador',$args);
		
		$labels = array(
			'name'					=> 'Níveis',
			'singular_name'			=> 'Nível',
			'search_items'			=> 'Procurar por nível',
			'popular_items'			=> 'Níveis Populares',
			'all_items'				=> 'Todos os níveis',
			'parent_item'			=> 'Nível pai',
			'parent_item_colon'		=> 'Nível pai:',
			'edit_item'				=> 'Editar nível',
			'update_item'			=> 'Atualizar nível',
			'add_new_item'			=> 'Adicionar nível',
			'new_item_name'			=> 'Novo nível',
			'add_or_remove_items'	=> 'Adicionar ou remover níveis',
			'choose_from_most_used'	=> 'Escolher entre os mais usados',
			'menu_name'				=> 'Níveis',
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => false,
			'hierarchical'      => true,
			'show_tagcloud'     => false,
			'show_ui'           => true,
			'query_var'         => true,
			'rewrite'           => true,
			'query_var'         => true,
		);
		register_taxonomy( 'niveis', array( 'patrocinador' ), $args );
		
		// Inicializar a interface administrativa
		// filters
		add_filter( 'posts_where', array( &$this, 'filter_where' ), 10, 2 );
		add_filter( 'posts_orderby', array( &$this, 'filter_orderby' ), 10, 2 );
		add_filter( 'post_type_link', array( &$this, 'post_type_link' ), 10, 3 );

		// actions
		add_action("template_include", array(&$this, 'template_include'));
		add_action( 'pre_get_posts', array(&$this, 'pre_get_posts') );
		add_action("admin_init", array(&$this, "admin_init"));
		add_action("wp_insert_post", array(&$this, "wp_insert_post"), 10, 2);

		flush_rewrite_rules();
	}

	function post_type_link($permalink, $post, $leavename){
		if (isset($post->post_type) && $post->post_type == "patrocinador"){
			$custom = get_post_custom($post->ID);
			return isset($custom["url"]) ? $custom["url"][0] : '';
		}
		return $permalink;
	}

	function pre_get_posts($query){
		if (isset($query->query_vars["post_type"]) && $query->query_vars["post_type"] == "patrocinador" && !is_admin()){
			$query->query_vars['showposts'] = -1;
		}
	}

	function filter_where($where, $wp_query) {
		return $where;
	}
	
	function filter_orderby($order, $wp_query) {
		return $order;
	}

	// Quando um post é inserido ou atualizado
	function wp_insert_post($post_id, $post = null){
		if ($post->post_type == "patrocinador"){
			if(defined('DOING_AJAX') && DOING_AJAX) {
				return true;
				exit();
			}
			// Loop nos dados do POST
			foreach ($this->meta_fields as $key){
				$value = @$_POST[$key];
				if (empty($value)){
					delete_post_meta($post_id, $key);
					continue;
				}

				// Se o valor é uma string, ele deve ser único
				if (!is_array($value)){
					// Atualizar meta
					if (!update_post_meta($post_id, $key, $value))
					{
						// Ou inserir meta
						add_post_meta($post_id, $key, $value);
					}
				}else{
					// Se o valor passado for um array, devemos remover todos os dados anteriores
					delete_post_meta($post_id, $key);
					
					// Loop no array adicionando os valores ao post meta como entradas diferentes com o mesmo nome
					foreach ($value as $entry)
						add_post_meta($post_id, $key, $entry);
				}
			}
		}
	}

	function admin_init(){
		// Adicionando box de datas - http://codex.wordpress.org/Function_Reference/add_meta_box
		add_meta_box("data", "URL", array(&$this, "data_options"), "patrocinador", "normal", "high");
	}

	// Administrar conteúdo do post meta
	function data_options(){
		global $post;
		$custom = get_post_custom($post->ID);
		$url = isset($custom["url"]) ? $custom["url"][0] : '';
		?>
		<label>URL:</label><br /> <input type="text" name="url" value="<?php echo $url; ?>" style="width:100%;" /><br />
		<?php
	}

	
	// Seleção de template
	function template_include($template){
		global $wp;
		if (isset($wp->query_vars["post_type"]) && $wp->query_vars["post_type"] == "patrocinador" && is_single()){
			if (file_exists(TEMPLATEPATH . "/single-patrocinador.php")) {
				return TEMPLATEPATH . "/single-patrocinador.php";
			}
		}elseif(is_post_type_archive('patrocinador') && !is_feed() ){
			if (file_exists(TEMPLATEPATH . "/patrocinador.php")) {
				return TEMPLATEPATH . "/patrocinador.php";
			}
		}
		return $template;
	}
}
