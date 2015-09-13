<?php
//controller for createLabOrder.html
//get details for order, get product Id

//test_session

//getOrderDetails for order in $_GET['orderId'];

//Twig render --> createLabOrder.html'


require_once '../../Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);

function getSingleOrder($db,$collection,$orderId){

  //get the stuff from the database (api, collection pstuff)
  $m = new MongoClient();
  $db = $m->$db;
  $coll = $db->$collection;

  $query = array('id'=>$orderId);

  //var_dump($query);

  //$query = array('id'=> 492920705);

  return $order = $coll->findOne($query); //returns cursor



}
//
  if (isset($_GET['orderId'])) {

    $orderId = $_GET['orderId'];

    settype($orderId, "integer"); //boy this has to be done

    echo $orderId;

    $order  = getSingleOrder(api,pstuff,$orderId);

    //var_dump($order);

    //get shipping address in one line, saves headache later.

    $ship = $order['shipping_address'];

    //echo $address = $ship['phone'] .'&#13;&#10;' . $ship['address1'] .'&#13;&#10;' . $ship['address2'] .'&#13;&#10;' . $ship['city'] .',' . $ship['zip'] .'&#13;&#10;' . $ship['country'];

    $prods = $order['line_items'];

    $p = array();

    foreach ($prods as $product) {
      $p_id = $product['sku'];
      array_push($p,$p_id);
    }

    $products = array("sku" =>$p, "itemsCount" =>count($p));

    //var_dump($products);

    echo $twig->render('test_pavan_2.html', array("order" => $order, "items" => $products, "ship" => $ship)); //items.sku | first,

  }

  else {
    $e = "try again";
    header("Location: http://www.example.com/home.php"); /* Redirect browser */

    /* Make sure that code below does not get executed when we redirect. */

    exit;

  }


?>
