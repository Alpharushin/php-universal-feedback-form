<?php 

$adminEmail = $_POST['adminEmail'];
$emailSubject = $_POST['emailSubject'];
$emailFrom = $_POST['emailFrom'];
$projectName = $_POST['projectName'];

//print_r($_POST);

$message = "Вам поступило письмо с сайта. <br> <table style='width:100%;'>";
$counter = true ;

foreach ($_POST as $key => $value) {
  if ($key != 'adminEmail' && $key != 'emailSubject' && $key != 'emailFrom' && $key != 'projectName' && $value != "" ) {
    
      if ($counter) {
        $message .= "<tr style='background-color:#BAD7DF;'>";
      } else {
        $message .= "</tr>";
      }

    
    $message .= "<td>$key </td><td>$value </td>";
    $message .= "</tr>";

    $counter = !$counter;
  }
  
}

$message .= "</table>";

function adopt($text) {
	return '=?UTF-8?B?'.base64_encode($text).'?=';
}

$headers = "MIME-Version: 1.0" . PHP_EOL . 
           "Content-Type: text/html; charset=utf-8" . PHP_EOL . 
           "From:" . adopt($projectName) . "<". adopt($emailFrom) .">" . PHP_EOL .
           "Replay-To:" . adopt($adminEmail);

/*$message = "Вам поступило письмо с сайта. <br>" . 
           "Пользователь <b>" . $_POST['name'] . "</b><br>" .
           "Email <b>" . $_POST['email'] . "</b><br>" .
           "Skype <b>" . $_POST['skype'] . "</b><br>" .
           "Указал сайт: <b>" . $_POST['website'] . "</b><br>" .
           "Отправил сообщение <br>" . $_POST['message'] . "<br>";*/

           


$result = mail($adminEmail, $emailSubject, $message, $headers );

function saveUserData($text) {
  $f = fopen('form-fill.html' , 'a+');
  fwrite($f, date('Y-m-d H:i:s') . "\n" );
  fwrite($f, $text . "\n \n \n" );
}

saveUserData($message);

if ($_POST) {
  header('location: ../success.html ');
} else {
  echo "Отправка не удалась! Попробуйте позднее";
}


?>