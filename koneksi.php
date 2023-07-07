<?php
$username = '065024';
$password = 'atmipddikti';
$data = array('act' => 'GetToken', 'username' => $username, 'password' => $password);
$result_string = runWS($data, $ctype);
$result = json_decode($result_string, true);

$token = $result['data']['token'];

$_SESSION['token'] = $token;
return $token;
?>