<?php
/*
Plugin Name: Alagoas Dev Day - Palestrantes
Plugin URI: http://www.gmmcal.com.br
Description: Módulo de Palestrantes customizado para Alagoas Dev Day
Author: Gustavo Cunha
Version: 1.0
Author URI: http://www.gmmcal.com.br
*/
include_once('class.php');
include_once('query.php');

// Inicializar o plugin
add_action("init", "speakersInit");
function speakersInit() {
	new Speakers();
}
