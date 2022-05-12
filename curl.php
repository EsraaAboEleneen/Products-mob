<?php
$url = 'https://jsonplaceholder.typicode.com/users';
//$resource = curl_init($url);
//curl_setopt($resource , CURLOPT_SSL_VERIFYPEER,false);
//$result = curl_exec($resource);
//$code = curl_getinfo($resource,CURLINFO_HTTP_CODE);
//var_dump($code);
//curl_close($resource);
//var_dump($result);
//$request = curl_init();
//curl_setopt($request,CURLOPT_URL , 'https://jsonplaceholder.typicode.com/users');
//curl_setopt($request,CURLOPT_SSL_VERIFYPEER,false);
//curl_exec($request);
//$CODE = curl_getinfo($request,CURLINFO_HTTP_CODE);
//var_dump($CODE);
// post
$resource = curl_init($url);
$user = [
     "id" => 1,
     "name" => "Leanne Graham",
     "username" => "Bret",
     "email" => "Sincere@april.biz"
];
curl_setopt_array($resource,
[
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['content-type : application/json'],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($user)

]
);
$resualt =  curl_exec($resource);
curl_close($resource);
echo $resualt;