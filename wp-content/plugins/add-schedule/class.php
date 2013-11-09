<?php
class Schedule {
	var $meta_fields = array( 'hora', 'tema' );

	function __construct(){
		// Registrar custom post types - http://codex.wordpress.org/Function_Reference/register_post_type
		$labels = array(
			'name' => 'Programação',
			'singular_name' => 'Palestra',
			'add_new' => 'Adicionar novo',
			'add_new_item' => 'Adicionar nova palestra',
			'edit_item' => 'Editar Palestra',
			'new_item' => 'Nova Palestra',
			'all_items' => 'Todas as Palestras',
			'view_item' => 'Ver Palestra',
			'search_items' => 'Pesquisar Palestra',
			'not_found' =>  'Nenhuma palestra encontrada',
			'not_found_in_trash' => 'Nenhuma palestra encontrada na lixeira',
			'parent_item_colon' => 'Palestra pai',
			'menu_name' => 'Programação'
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
				'slug' => 'programacao',
				'with_front' => true,
				'feeds' => true,
				'pages' => true,
			),
			'taxonomies' => array(
			),
			'query_var' => 'programacao',
			'can_export' => true,
			'show_in_nav_menus' => false,
			'capability_type' => 'post',
		);
		register_post_type('programacao',$args);
		
		// Inicializar a interface administrativa
		// filters
		add_filter( 'posts_where', array( &$this, 'filter_where' ), 10, 2 );
		add_filter( 'posts_orderby', array( &$this, 'filter_orderby' ), 10, 2 );

		// actions
		add_action("template_include", array(&$this, 'template_include'));
		add_action( 'pre_get_posts', array(&$this, 'pre_get_posts') );
		add_action("admin_init", array(&$this, "admin_init"));
		add_action("wp_insert_post", array(&$this, "wp_insert_post"), 10, 2);

		flush_rewrite_rules();
	}

	function pre_get_posts($query){
		if (isset($query->query_vars["post_type"]) && $query->query_vars["post_type"] == "programacao" && !is_admin()){
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
		if ($post->post_type == "programacao"){
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
		add_meta_box("data", "Tema e Hora", array(&$this, "data_options"), "programacao", "normal", "high");
	}

	// Administrar conteúdo do post meta
	function data_options(){
		global $post;
		$custom = get_post_custom($post->ID);
		$hora = isset($custom["hora"]) ? $custom["hora"][0] : '';
		$tema = isset($custom["tema"]) ? $custom["tema"][0] : '';
		?>
		<label>Hora (Ex: 08:00):</label><br /> <input type="text" name="hora" value="<?php echo $hora; ?>" style="width:100%;" /><br />
		<label>Tema:</label><br /> <input type="text" name="tema" value="<?php echo $tema; ?>" style="width:100%;" /><br />
		<?php
	}

	
	// Seleção de template
	function template_include($template){
		global $wp;
		if (isset($wp->query_vars["post_type"]) && $wp->query_vars["post_type"] == "programacao" && is_single()){
			if (file_exists(TEMPLATEPATH . "/single-programacao.php")) {
				return TEMPLATEPATH . "/single-programacao.php";
			}
		}elseif(is_post_type_archive('programacao') && !is_feed() ){
			if (file_exists(TEMPLATEPATH . "/programacao.php")) {
				return TEMPLATEPATH . "/programacao.php";
			}
		}
		return $template;
	}
}
