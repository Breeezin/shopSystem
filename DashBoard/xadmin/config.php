<?php

// this is an example only
// write your own config and name it as config.php

// detected by browser
// $lang = 'en-us';

$charset = "UTF-8";

// developers only
$show_todo_strings = false;

// this function is detected by xcache.tpl.php, and enabled if function_exists
// this ob filter is applied for the cache list, not the whole page
function ob_filter_path_nicer($o)
{
	$sep = DIRECTORY_SEPARATOR;
	$o = str_replace($_SERVER['DOCUMENT_ROOT'],  "{DOCROOT}$sep", $o);
	$xcachedir = realpath(dirname(__FILE__) . "$sep..$sep");
	$o = str_replace($xcachedir . $sep, "{XCache}$sep", $o);
	if ($sep == '/') {
		$o = str_replace("/home/", "{H}/", $o);
	}
	return $o;
}

// you can simply let xcache to do the http auth
// but if you have your home made login/permission system, you can implement the following
// {{{ home made login example
// this is an example only, it's won't work for you without your implemention.
function check_admin_and_by_pass_xcache_http_auth()
{

	// user is trusted after permission checks above.
	// tell XCache about it (the only way to by pass XCache http auth)
	$_SERVER["PHP_AUTH_USER"] = "rex";
	$_SERVER["PHP_AUTH_PW"] = "ZZ";
	return true;
}

// uncomment:
check_admin_and_by_pass_xcache_http_auth();
// }}}

?>
