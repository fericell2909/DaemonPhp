<?php


$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "http://10.0.0.95/firmadigital/daemon.php",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 10000,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"Cookie: PHPSESSID=8gpr2kq41kuc06k61kegv79ho5"
	),
));

$response = curl_exec($curl);

curl_close($curl);
