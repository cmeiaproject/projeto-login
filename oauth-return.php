<?php
// Vercel callback pass-through for Google OAuth.
// Recebe o redirect do Google em /api/oauth-return.php e redireciona para /oauth-return
// no mesmo host ou em OAUTH_APP_ORIGIN se definido.

$host = getenv('OAUTH_APP_ORIGIN');
if (!$host) {
  $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
  $host = $scheme . '://' . $_SERVER['HTTP_HOST'];
}

$query = $_SERVER['QUERY_STRING'] ?? '';
$redirectTo = rtrim($host, '/') . '/oauth-return';
if ($query !== '') {
  $redirectTo .= '?' . $query;
}

header('Location: ' . $redirectTo, true, 302);
exit;
