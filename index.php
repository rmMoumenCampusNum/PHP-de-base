<?php   
$page = $_GET['page'];

if (empty($page)) {
    $page = 'Accueil';
}

 switch ($page){
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
        include ('notfound.php');
        break;
}
?>