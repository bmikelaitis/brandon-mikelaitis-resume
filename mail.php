<?php


require 'vendor/autoload.php';
$secret = getenv('RECAP_KEY');

$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
  $responseData = json_decode($verifyResponse);
  if($responseData->success) {
  
    $name = $_POST['name'];
    $email = $_POST['email']; 
    $subject = $_POST['subject']; 
    $message = pg_escape_string($_POST['message']);

    $request_body = json_decode('{
      "personalizations": [
        {
          "to": [
            {
              "email": "brandonmikelaitis@gmail.com"
            }
          ],
          "subject": "Contact from website"
        }
      ],
      "from": {
        "email": "brandonmikelaitis@gmail.com"
      },
      "content": [
        {
          "type": "text/plain",
          "value": "Name: '.$name.' <br> Email: '.$email.' <br> Subject:  '.$subject.' <br> Phone:  '.$message.'" 
        }
      ]
    }');

    $apiKey = getenv('SENDGRID_KEY');
    $sg = new \SendGrid($apiKey);

    $response = $sg->client->mail()->send()->post($request_body);
    echo $response->statusCode();
    echo $response->body();
    echo $response->headers();

    header('Location: home.php?status=success');
    
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } 
    else {
      echo $response;
    }
  }

  else {
    header('Location: home.php?status=failed#five');
  }

?>