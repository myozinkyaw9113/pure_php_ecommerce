<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //csrf protection
    if (!hash_equals($_SESSION['csrf_token'], $_POST['_token'])) {
        echo 'Invalid CSRF Token';
        die();
    } else {
        unset($_SESSION['csrf_token']);
    }
}

if (empty($_SESSION['csrf_token'])) {
	if (function_exists('random_bytes')) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	} else {
		$_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
	}
}



/**
 * Escapes HTML for output
 *
 */

function escape($html) {
	return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

?>