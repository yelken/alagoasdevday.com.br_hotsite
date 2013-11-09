<?php
class WP_Query_Schedule extends WP_Query {
	function __construct($query = '') {
		$query["post_type"] = "programacao";
		$this->query($query);
	}
}