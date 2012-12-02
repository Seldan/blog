<?php
	function fortune($fortunes) {
		/*returns a random fortune*/
		$ret = $fortunes[rand(0, count($fortunes)-1)];
		return $ret;
	}
?>