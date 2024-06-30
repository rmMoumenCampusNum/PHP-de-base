<?php
$page = $_GET['page'];

switch ($page) {
    case 'GwenStacy':
        include 'GwenStacy.php';
        break;
    case 'Accueil':
        include 'Accueil.php';
        break;
    case 'MilesMorales':
        include 'MilesMorales.php';
        break;
    default:
        include('notfound.php');
        break;
}

if (empty($page)) {
    $page = 'Accueil';
}