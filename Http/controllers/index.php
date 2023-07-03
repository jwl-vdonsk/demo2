<?php

$_SESSION['name'] = 'SomeName';

view("index.view.php", [
    'heading' => 'Home page'
]);

