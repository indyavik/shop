<?php

require_once '../../Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);


//check session
//usage: if !(ddsession() == 'ok') { //redirect to somewhere. }

function ddSession(){

  session_start();

    if ( !isset($_SESSION['username']) ) {

       if(!isset($_POST['email']) || !isset($_POST['password'])) {

         $e = "Please Login First. Correct email or password is required";
         echo $twig->render('login.html', array("error" => $e));

       }
       elseif (isset($_POST['email']) && isset($_POST['password']))  {

         //lets authenticate the user.
         $email = $_POST['email'];
         $password = $_POST['password'];

         return $e =array("authenticate_me"=>'true',"user"=>$email,"password"=>$password) ;

            }
      //send over to the login page

      $e = "Please Login First";
      echo $twig->render('login.html', array("error" => $e));

    }

    else {

      //user has a session ..just go show him the goodies.

      return $dd_session ="ok";

      }

}

function showHome($db,$collection){

  //get the stuff from the database (api, collection pstuff)
  $m = new MongoClient();
  $db = $m->$db;
  $coll = $db->$collection;

  $cursor = $coll->find(); //returns cursor

  $orderData = array();

      foreach ($cursor as $doc) {

        array_push ($orderData, $doc);

      }


  //now $orderData array is php array with all the orders.

echo $load =  $twig->render('home.html', array("orders" => $orderData, "somethingelse"=> 'something'));//

}

if (!isset($_SESSION['username'])) {

//header('Location: index.php');

//check if something came in the post

      if(isset($_POST['email']) && isset($_POST['password'])) {

        //check for id and pw
        $email = $_POST['email'];
        $password = $_POST['password']

        //check in the database (mongo about id and pass)

        $check = authlogin($email,$password);

          if ($check = "ok") {

            //set the session
            session_start();
            $_SESSION['username'] = $email;

            //cookie later

            //then load the stuff
                $load = showHome($db,$collection);
                echo $load;

                }

                else {
                  $e = "something is not right, try again ..";
                  echo $twig->render('login.html', array("error" => $e));
                }


      }

      //else simply load the account.html
      else {

        $e ="Please Login first";
        echo $twig->render('login.html', array("error" => $e));

      }

}

//$orders = getOrdersFromDb() //

//$template = $twig->loadTemplate('index.html');
//user has a session, send to home.html
//echo $twig->render('home.html');

$load = showHome($db,$collection);
echo $load;

?>
