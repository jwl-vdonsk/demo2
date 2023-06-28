<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(\Core\Database::class);

$currentUserId = 1;

// находим соответствующую заметку

$note = $db->query('select * from notes where id = :id', [
    'id' => $_POST['id']
])->findOrFail();

// проверяем авторизацию пользователя

authorize($note['user_id'] === $currentUserId);

// валидируем форму

$errors = [];

if (! Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = "A body of no more than 1,000 characters is required";

}

// если нет ошибок валидации - обновляем запись в базе данных

if (count($errors)) {
    return view("/notes/edit.view.php", [
        'heading' => 'Create Note',
        'errors' => $errors,
        'note'=> $note,
        ]);
}

$db->query('update notes set body = :body where id = :id', [
    'body' => $_POST['body'],
    'id' => $_POST['id']
]);

header('location: /notes');
die();