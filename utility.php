<?php

define('MY_LOCAL_SYSTEM_ROOT', '/Users/aking/Dropbox/Dev/www/');

function pp($var) {
	echo '<pre>'.print_r($var, true).'</pre>';
}

function d($var) {
	header('Content-type: text/plain');
	print_r($var);
	die();
}

function l($var, $level = 3, $args = false) {
	$indent = 6;
	$trace = debug_backtrace();
	$msg = '##[LOG] '.(is_scalar($var) ? $var : print_r($var, true));
	error_log($msg);
	for ($i = 0; $i < $level && $i < count($trace); $i++) {
		$indent_level = $i * $indent;
		$caller = '| caller: ';
// check for object
		if (!empty($trace[$i]['class'])) {
			$caller .= $trace[$i]['class']
				. (!empty($trace[$i]['type']) ? $trace[$i]['type'] : '->');
		}
		$caller .= $trace[$i]['function'].'()';
		error_log(str_pad_left($caller, $indent_level));
		if (!empty($trace[$i]['file'])) {
			error_log(str_pad_left('| file:   '.str_replace(MY_LOCAL_SYSTEM_ROOT, '', $trace[$i]['file']), $indent_level));
		}
		if (!empty($trace[$i]['line'])) {
			error_log(str_pad_left('| line:   '.$trace[$i]['line'], $indent_level));
		}
		if ($args && !empty($trace[$i]['args'])) {
			error_log(str_pad_left('| args:   '.print_r($trace[$i]['args'], true), $indent_level));
		}
	}
	error_log(' ');
}

function str_pad_left($str, $len) {
	return str_pad($str, strlen($str) + $len, ' ', STR_PAD_LEFT);
}
