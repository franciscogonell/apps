<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, 'https://script.google.com/macros/s/AKfycbycwJEbq3y-lzm431xpl8UUahUsDswjYfOHcNBNubrFdT7ZPyQ/exec?apiKey=123457&operation=GetTickers');
$result = curl_exec($ch);
curl_close($ch);

$obj = json_decode($result);
echo $result;

?>

