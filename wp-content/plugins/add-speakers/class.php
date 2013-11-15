<?php
class Speakers {
	var $meta_fields = array( 'bio', 'empresa', 'twitter', 'facebook', 'linkedin', 'hidden' );

	function __construct(){
		// Registrar custom post types - http://codex.wordpress.org/Function_Reference/register_post_type
		$labels = array(
			'name' => 'Palestrantes',
			'singular_name' => 'Palestrante',
			'add_new' => 'Adicionar novo',
			'add_new_item' => 'Adicionar novo palestrante',
			'edit_item' => 'Editar Palestrante',
			'new_item' => 'Novo Palestrante',
			'all_items' => 'Todos os Palestrantes',
			'view_item' => 'Ver Palestrante',
			'search_items' => 'Pesquisar Palestrante',
			'not_found' =>  'Nenhum palestrante encontrado',
			'not_found_in_trash' => 'Nenhum palestrante encontrado na lixeira',
			'parent_item_colon' => 'Palestrante pai',
			'menu_name' => 'Palestrantes'
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
				'slug' => 'palestrante',
				'with_front' => true,
				'feeds' => true,
				'pages' => true,
			),
			'taxonomies' => array(
			),
			'query_var' => 'palestrante',
			'can_export' => true,
			'show_in_nav_menus' => false,
			'capability_type' => 'post',
		);
		register_post_type('palestrante',$args);
		
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
		if (isset($query->query_vars["post_type"]) && $query->query_vars["post_type"] == "palestrante" && !is_admin()){
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
		if ($post->post_type == "palestrante"){
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
		add_meta_box("data", "Tema e Hora", array(&$this, "data_options"), "palestrante", "normal", "high");
	}

	// Administrar conteúdo do post meta
	function data_options(){
		global $post;
		$custom = get_post_custom($post->ID);
		$bio = isset($custom["bio"]) ? $custom["bio"][0] : '';
		$empresa = isset($custom["empresa"]) ? $custom["empresa"][0] : '';
		$twitter = isset($custom["twitter"]) ? $custom["twitter"][0] : '';
		$facebook = isset($custom["facebook"]) ? $custom["facebook"][0] : '';
		$linkedin = isset($custom["linkedin"]) ? $custom["linkedin"][0] : '';
		$hidden = isset($custom["hidden"]) ? $custom["hidden"][0] : '';
		?>
		<label>Bio:</label><br /> <textarea name="bio" style="width:100%;"><?php echo $bio; ?></textarea><br />
		<label>Empresa:</label><br /> <input type="text" name="empresa" value="<?php echo $empresa; ?>" style="width:100%;" /><br />
		<label>Twitter (URL completa):</label><br /> <input type="text" name="twitter" value="<?php echo $twitter; ?>" style="width:100%;" /><br />
		<label>Facebook (URL completa):</label><br /> <input type="text" name="facebook" value="<?php echo $facebook; ?>" style="width:100%;" /><br />
		<label>LinkedIn (URL completa):</label><br /> <input type="text" name="linkedin" value="<?php echo $linkedin; ?>" style="width:100%;" /><br />
		<label>Esconder palestrante:</label><br /> <input type="checkbox" name="hidden" value="1"<?php echo ($hidden == 1 ? ' checked="checked"' : '')?>><br />
		<?php
	}

	
	// Seleção de template
	function template_include($template){
		global $wp;
		if (isset($wp->query_vars["post_type"]) && $wp->query_vars["post_type"] == "palestrante" && is_single()){
			if (file_exists(TEMPLATEPATH . "/single-palestrante.php")) {
				return TEMPLATEPATH . "/single-palestrante.php";
			}
		}elseif(is_post_type_archive('palestrante') && !is_feed() ){
			if (file_exists(TEMPLATEPATH . "/palestrante.php")) {
				return TEMPLATEPATH . "/palestrante.php";
			}
		}
		return $template;
	}
}
