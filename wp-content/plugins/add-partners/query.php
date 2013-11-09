<?php
class WP_Query_Partners extends WP_Query {
	function __construct($query = '') {
		$query["post_type"] = "patrocinador";
		$this->query($query);
	}
}