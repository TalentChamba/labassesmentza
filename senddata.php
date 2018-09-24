
<?php

//API URL
//Change it your desired path
$url = 'http://localhost/task/api.php/score';

//create a new cURL resource
$ch = curl_init($url);

//setup request to send json via POST
$data = array(
    'ID' => 1,
    'Title' => 'Titlefirst',
	'Score' => 2.08,
	'Timestamp'=>time()
);
$payload = json_encode($data);
echo $payload;

//attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

//set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

//return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute the POST request
$result = curl_exec($ch);

print_r($result);

//close cURL resource
curl_close($ch);

?>