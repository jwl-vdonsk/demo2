<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];

if (! Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}

if (! Validator::string($password, 3, 255)) {
    $errors['password'] = 'Please provide a valid password.';
}

if (!empty($errors)) {
    return view("/registration/create.view.php", [
        'heading' => 'Create user',
        'errors' => $errors,
    ]);
}

$db = App::resolve(Database::class);

$result = $db->query('select * from users where email = :email', [
   'email'=>$email
])->find();



if ($user) {
    header('location: /');
    exit();
} else {
    $db->query('insert into users(email, password) values(:email, :password)',[
        'email' => $email,
        'password' => $password,
    ]);

    $_SESSION['user'] = [
        'email' => $email
    ];

    header('location: /');
    exit();
}