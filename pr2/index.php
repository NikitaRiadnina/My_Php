<?php
// !!!TODO 1: ваш код обробки GET запиту; виконання запиту через cURL у пошукову систему; підготовка даних для малювання
$target = 'php';
if (isset($_GET['search'])) { $target = $_GET['search'];}
$cx = '205c1fcf769bb4263';
$apiKey = 'AIzaSyBFW2Z1UTOiGf4OMRj0-hNqXF485I9ktmuI';
$url = "https://www.googleapis.com/customsearch/v1?key={$apiKey}&cx={$cx}&q={$target}";
$curlC = curl_init();
curl_setopt($curlC, CURLOPT_URL, $url);
curl_setopt($curlC, CURLOPT_RETURNTRANSFER, true);
$getJson = curl_exec($curlC);
curl_close($curlC);
$transferJson = json_decode($getJson, true)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h2>My Browser</h2>
<form method="GET" action="/index.php">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" value=""><br><br>
    <input type="submit" value="Submit">
</ form >
<?php
// !!! TODO 2: код відображення відповіді
foreach ($transferJson['items'] as $items) {
    echo "<a href={$items['link']}>";
    echo "<p>{$items['title']}</p>";
}
?>
</body>
</html>