<?php

$token = "BACKENDAT102SERVER";

echo "X is good";

//this works as URL?token=BACKENDAT102SERVER

function showHome($db,$collection){

  //get the stuff from the database (api, collection pstuff)
  $m = new MongoClient();
  $db = $m->$db;
  $coll = $db->$collection;

  $cursor = $coll->find(); //returns cursor

  $orderData = array();
  $paymentOrders = array();
  $originalOrders = array();

      foreach ($cursor as $doc) {

        array_push ($orderData, $doc);

        /* snippet to get orders that are actually a payments   */


        if ($doc['isPayment'] == "yes" ) {

        array_push ($paymentOrders, $doc);

        }


        /* snippet to get orders are prescription related and needed to be processed.  */


        if ($doc['isPayment'] == "no" ) {

        array_push ($originalOrders, $doc);

        }

      }


  //now $orderData array is php array with all the orders.

  require_once '../../Twig/lib/Twig/Autoloader.php';
  Twig_Autoloader::register();

  $loader = new Twig_Loader_Filesystem('../views');
  $twig = new Twig_Environment($loader);


  echo $twig->render('home_table_test.html', array("orders" => $originalOrders, "payments" => $paymentOrders, "ordersAll" => $orderData));//


}

if ($_GET['token'] !==$token) {
  exit();
  //echo "existing stil";
}
else {
  //echo "running load";
  showHome('api','pstuff');
}

?>
