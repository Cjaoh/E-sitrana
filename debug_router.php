<?php
echo "Debug Router\n";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";

$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = explode('?', $request_uri)[0];

$base_path = str_replace('/router.php', '', $_SERVER['SCRIPT_NAME']);
if (strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}

echo "Processed URI: '$request_uri'\n";
echo "Is API: " . (strpos($request_uri, '/api/') === 0 ? 'YES' : 'NO') . "\n";
echo "Is Admin: " . (strpos($request_uri, '/admin') === 0 ? 'YES' : 'NO') . "\n";
echo "Is Static: " . (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/', $request_uri) ? 'YES' : 'NO') . "\n";
?>
