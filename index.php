<?php   
$page = $_GET['page'];
 switch ($page){
    case 'GwenStacy':
        include 'GwenStacy.php';
        break;
    case 'Accueil':
        include 'Accueil.php';
        break;  
    default:
        include 'notfound.php';
        break;
}

if (($page=='MilesMorales')) {
    include('MilesMorales.php');
} else {
    $page = 'Accueil';
}

route($page);

?>