<?php

require 'vendor/autoload.php';
$my_cap_key = getenv('RECAP_KEY');

$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=.$my_cap_key.&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
if($response['success'] == false){
    echo '<h2>You are spammer ! Get the @$%K out</h2>';
    header('Location: index.html#five');
}
else {
  $curl = curl_init();
  $name = $_POST['name']; 
  $email = $_POST['email']; 
  $subject = $_POST['subject']; 
  $message = $_POST['message'];
  $my_env_var = getenv('SENDGRID_KEY');
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n  \"personalizations\": [\n    {\n      \"to\": [\n        {\n          \"email\": \"BrandonMikelaitis@gmail.com\"\n        }\n      ],\n      \"subject\": \"New Contact\"\n    }\n  ],\n  \"from\": {\n    \"email\": \"brandonmikelaitis@gmail.com\"\n  },\n  \"content\": [\n    {\n      \"type\": \"text/html\",\n      \"value\": \"$name<br>$email<br>$subject<br>$message\"\n    }\n  ]\n}",
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer $my_env_var",
      "cache-control: no-cache",
      "content-type: application/json"
    ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  header('Location: index.html');
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }
}




?>