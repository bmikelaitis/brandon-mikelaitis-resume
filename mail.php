<?php

require 'vendor/autoload.php';
$secret = getenv('RECAP_KEY');

$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
$responseData = json_decode($verifyResponse);

if($responseData == false){
  echo 'Captcha was not verified, please resubmit form.  Redirecting in 5 seconds.';
  sleep(5);
  header('Location: index.html#five');
}
else {
  $curl = curl_init();
  $name = $_POST['name'];
  $name = "Name: " + $name;
  $email = $_POST['email']; 
  $email = "Email: " + $email;
  $subject = $_POST['subject']; 
  $subject = "Subject: " + $subject;
  $message = $_POST['message'];
  $message = "Message: " + $message;
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
  
  echo 'Message Sent! Your information has been sent. Redirect in 5 seconds.';
  echo $name;
  echo $email;
  echo $subject;
  echo $message;
  sleep(5);
  header('Location: index.html');
  
  
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }
}




?>