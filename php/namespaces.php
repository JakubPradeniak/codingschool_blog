<?php

declare(strict_types=1);

require 'App/autoloader.php';

use App\Models\UserModel;
use App\Utils\Email;
use App\Utils\EncodeImage;


$connection = new PDO(
    'mysql:dbname=blog;host=127.0.0.1',
    'root',
    '',
    array(
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
);

$userModel = new UserModel($connection);

$user = $userModel->findOne(1);

if ($user) {
    echo json_encode($user);
}


$encodedImage = EncodeImage::dataUri('./hory.jpg', 'jpg');

$massage = "Testování emailů 😃<br><img src='$encodedImage'>";

// Email::send("admin@nasserver.com", "nekdo@mail.com", "Test 😁", $massage);
