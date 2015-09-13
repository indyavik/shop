<?php

require_once '../../Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);

$e ="Please Login first";

//check session

if (!isset($_SESSION['username'])) {
//header('Location: index.php');
echo $twig->render('login.html', array('name' => 'Fabien', "error" => $e));//

}

//$orders = getOrdersFromDb() //

//$template = $twig->loadTemplate('index.html');
//user has a session, send to home.html
echo $twig->render('home.html');//

?>
