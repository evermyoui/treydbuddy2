<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config.php';
if (!in_array($_SERVER['REQUEST_METHOD'], ['POST','GET'], true)) { http_response_code(405); exit('Method Not Allowed'); }
$_SESSION = [];
if (ini_get('session.use_cookies')) {
  $p = session_get_cookie_params();
  setcookie(session_name(), '', time()-42000, $p['path'],$p['domain'],$p['secure'],$p['httponly']);
}
session_destroy();
header('Location: /treydbuddy2/auth/login.php');
exit;
?>


