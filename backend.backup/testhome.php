<?php


  //get the stuff from the database (api, collection pstuff)
  $m = new MongoClient();
  $db = $m->api;
  $coll = $db->pstuff;

  $cursor = $coll->find(); //returns cursor

  $orderData = array();

      foreach ($cursor as $doc) {

        array_push ($orderData, $doc);

      }


  //now $orderData array is php array with all the orders.
  
  require_once '../../Twig/lib/Twig/Autoloader.php';
  Twig_Autoloader::register();

  $loader = new Twig_Loader_Filesystem('../views');
  $twig = new Twig_Environment($loader);

  echo $twig->render('home_test.html', array("orders" => $orderData, "somethingelse"=> "something"));//

//echo $twig->render('login.html', array('name' => 'Fabien', "error" => $e));//



?>
