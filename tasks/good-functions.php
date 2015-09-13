<?php

function getRecentOrderId($db, $collection) {

  ###query $db,and coll to get the id of the most recent order id (should be the only value) ##

  $m = new MongoClient();
  $db = $m->$db;
  $coll = $db->$collection;
  $cursor = $coll->findOne(array('title' => 'recent_id'),array('id'));
  //findOne method returns one document so its directly available in php arraye

  return $recentId = $cursor['id'];

  //usage $e = getRecentOrderId('api','rid');

}


function getShopOrderSinceId($recentId) // getShopOrderSinceId('492908353');492747585 for 3 record. getShopOrderSinceId('492747585');

  ###returns the orders from shop in php associative array ##
{

//setURL
$jurl = "https://b9f4093d734dade3859306e0c753c08d:ce377163f4675074b3760f86e4c703dc@eyes.myshopify.com/admin/orders.json?since_id=".$recentId;

//curl stuff here
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $jurl);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$response = curl_exec($curl);
$status = curl_getinfo($curl);
curl_close($curl);
#var_dump($response);
$orderData = json_decode($response, true);
return $orderData;

/*
//shopify will return empty array if there was no new order since last time. so ...better to check whether it's empty first.
  if !empty($orderData['orders']) {
    return $orderData;
  }
  else{
    return $orderData = 'none';
  }
*/
}

function createDbOrders($orderData) {

  ###creates the order database, value of db and collections are hard coded##

  $chain = $orderData['orders'];

  foreach ($chain as $order ){

    $attributes = $order['note_attributes'];

    $a = array(); #initialize an empty array to push names values later on.
    $b = array(); #initialize another array to push values of the names later on

    echo "inner foreach for attributes starting now" ;

        foreach ($attributes as $inner) {

        $name = $inner['name'];
        array_push($a,$name); ## add the names stuff to the array $a

        $value = $inner['value'];
        array_push($b,$value);

      } //forloop attributes closes

        if (!empty($a)) {
          $new= array_combine($a,$b); //this has new attributes in key->value pairs
        }

        else
        {
          $new =array(); //$new an empty array, array_combine would have thrown an error.
        }


    echo "combine array done" ;

    if (array_key_exists('originOrder',$new) ) { //is this order is payment for a previous order , array_key returns boolean?
          $payment = "yes";
          $original = "no";
          $originOrder = $new['originOrder'];
          }
    else {
          $payment = "no";
          $original = "yes";
          $originOrder ="";
    }
    //$m_order = array_merge($order,$new_attr); //this has the stuff.

    //If (array_key_exists('uploadFile',$new) ? :$fileUploaded = 'yes', $fileUploaded = 'no';

    /**** Note ****** determine how prescription is sent

    just look up the value of the key =  optionSelector.

    /**will be good to know that upload was sucessfull ..setting cooking ajaxUpload = "yes" after ajax response.  - onclick checkout --> $('#idOfCheckoutButton').submit(function() { ...set the attribute value ...}



    if ($new['optionSelector'] == "prescriptionUpload") {

        if ($new['ajaxUpoad'] !== "yes") {

        $notice = "badUplaod"; //there is some problem with the upload. check oci_free_descriptor

        array_push($new, "notice" =>$notice) ;


      }

        //get file location
        $prescriptionFile = $new['UploadAttributes'] //Note: change this to lowercasce in liquid file

      }



    if key optionSelector ='' // -->old test orders.do not have this key.


    *****/


    $new_attr = array('dd_attributes'=>$new); //Save all this under dd_attributes
    
    $additionalData = array(
                              "isRefunded" =>"",
                              "refundedAmount" =>"",
                              "isPayment"=>$payment,
                              "isOriginOrder"=>$original,
                              "paymentFor"=>$originOrder,
                              "labOrderPdf"=> "", //changelog June 10th
                        );


  $m_order = array_merge($order,$new_attr,$additionalData); //this is to be inserted into the database.

  echo "m_orderCreated";


  //$arr = array_push($m,$m_order);


  $m = new MongoClient();
  $db =$m->api;
  $collection =$db->pstuff;
  $collection->insert($m_order); //or save($m_order)

  echo "saved orders";

  $recentArray = array();
  $id = $order['id'];
  array_push($recentArray, $id);

  echo "saved ids";


  }//foreach 'chain' loop closer

  $maxId = max($recentArray);

  $db =$m->api;
  $collection =$db->rid;

  $collection->update(
        array('title' => 'recent_id'),
    array('$set'    => array('id'   => $maxId))
    );

    echo "updated";
  //return $arr;
}

?>
