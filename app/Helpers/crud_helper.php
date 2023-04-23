<?php
	function spark_parseFieldRules($rules=''){
		return implode(',', explode('-', $rules));
	}/*parseFieldRules*/