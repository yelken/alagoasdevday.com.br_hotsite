<?php
class WP_Query_Speakers extends WP_Query {
	function __construct($query = '') {
		$query["post_type"] = "palestrante";
		$this->query($query);
	}
}