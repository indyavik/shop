<?php

require_once '../../Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

$x ="creative";

//$orders = getOrdersFromDb() //

//$template = $twig->loadTemplate('index.html');

echo $twig->render('index.html', array('name' => 'Fabien', "x" => $x));//

?>
