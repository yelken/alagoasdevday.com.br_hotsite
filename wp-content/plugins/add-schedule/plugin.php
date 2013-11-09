<?php
/*
Plugin Name: Alagoas Dev Day - Programação
Plugin URI: http://www.gmmcal.com.br
Description: Módulo de Programação customizado para Alagoas Dev Day
Author: Gustavo Cunha
Version: 1.0
Author URI: http://www.gmmcal.com.br
*/
include_once('class.php');
include_once('query.php');

// Inicializar o plugin
add_action("init", "scheduleInit");
function scheduleInit() {
	new Schedule();
}
