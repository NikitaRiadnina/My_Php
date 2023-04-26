<?php


$subject = 'MY TEST EMAIL';
echo '============' . "\n";
echo $subject . "\n";
echo '============' . "\n";

$firstName = 'Mykyta';
$lastName = 'Riadnyna';
$age = '20';
$country = 'Ukraine';
$doYouLikeDogs = 'Yeach';
$cats = 'meow';

$text1 = "firstName : {$firstName}" . "\n";
$text2 = "lastName : {$lastName}" . "\n";
$text3 = "age : {$age}" . "\n";
$text4 = "country : {$country}" . "\n";
$text5 = "doYouLikeDogs : {$doYouLikeDogs}" . "\n";
$text6 = "cats : {$cats}" . "\n";

$to = "myfriend@hotmail.com";
$body = "Це тестове повідомлення з PHP скрипту\n";

echo "Кому: " . $to . "<br>";
echo "Тема: " . $subject . "<br>";
echo "Тіло повідомлення: " . $body . "<br>";

$message = $text1 . $text2 . $text3 . $text4 . $text5 . $text6;
echo $message;

$headers = 'From: m.d.riadnyna@student.khai.edu';
mail($to, $subject, $message, $headers);
echo "Email відправлено!";