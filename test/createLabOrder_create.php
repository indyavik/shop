<?php

/*
-get _POST variables
-insert in mongodb db = labOrders (should we create a new collection for this or not ?)
-update the laborder file name and status = 'labOrderCreated' in mongodb db = psftuff (location )

ob_start();

-render the pdf output

$content = ob_get_clean();

-use the html2pdf to save the pdf file

-ifeverything is ok

header("location:viewLabOrder.php?id=OrderId"); /// ---> show options . pavan's "http://manager.digbydukeeyewear.com/view.php?id=HL2014-1401_193246.pdf"

          -once the email is sent, update the status again =
*/

//get post variables


//echo "oh yeah";



if(!isset($_POST['checkpost'])) {

  header('Location: http://www.example.com/');  //somethig is wrong.

}

$roid = $_POST['roid'] ; // this is real digbyduke order id ...nothing hapens without it.
$oid = isset($_POST['oid'])?$_POST['oid']:''; //lab order id that is usually digbyduke product.name
$pid = isset($_POST['pid'])?$_POST['pid']:''; //product id
$labId = isset($_POST['labid'])?$_POST['labid']:''; //id of the lab. lab01 is the lab in wales.

$cname = isset($_POST['custName'])?$_POST['custName']:'';
//$lname = isset($_POST['lname'])?$_POST['lname']:'';
//$nircno = isset($_POST['nric_no'])?$_POST['nric_no']:'';
$phoneno = isset($_POST['custPhone'])?$_POST['custPhone']:'';

//$emailid = isset($_POST['emailid'])?$_POST['emailid']:'';
$address1 = isset($_POST['address1'])?$_POST['address1']:'';
$address2 = isset($_POST['address2'])?$_POST['address2']:'';
$city = isset($_POST['city'])?$_POST['city']:'';
$zip = isset($_POST['zip'])?$_POST['zip']:'';
$country= isset($_POST['country'])?$_POST['country']:'';
$province= isset($_POST['province'])?$_POST['province']:'';

//$refine_refraction = isset($_POST['refine_refraction'])?$_POST['refine_refraction']:'0';
//$prescribe_glasses = isset($_POST['prescribe_glasses'])?$_POST['prescribe_glasses']:'0';
//$patient_glasses = isset($_POST['patient_glasses'])?$_POST['patient_glasses']:'0';
$od_sph = isset($_POST['od_sph'])?$_POST['od_sph']:'';
$od_cyl = isset($_POST['od_cyl'])?$_POST['od_cyl']:'';
$od_axis = isset($_POST['od_axis'])?$_POST['od_axis']:'';
$od_add = isset($_POST['od_add'])?$_POST['od_add']:'';
$os_sph = isset($_POST['os_sph'])?$_POST['os_sph']:'';
$os_cyl = isset($_POST['os_cyl'])?$_POST['os_cyl']:'';
$os_axis = isset($_POST['os_axis'])?$_POST['os_axis']:'';
$os_add = isset($_POST['os_add'])?$_POST['os_add']:'';
$pd_sph = isset($_POST['pd_sph'])?$_POST['pd_sph']:'';

$orderdate = isset($_POST['orderdate'])?$_POST['orderdate']:'';
$reqorderdate = isset($_POST['reqorderdate'])?$_POST['reqorderdate']:'';
//$frameinfo = isset($_POST['frameinfo'])?$_POST['frameinfo']:'';
$comment = isset($_POST['comment'])?$_POST['comment']:'';
//$opticianname = isset($_POST['opticianname'])?$_POST['opticianname']:'';

//$orderCreateDate = date("d-m-Y");

date_default_timezone_set('Europe/Copenhagen');

$labOrderCreateDate = date(DATE_ATOM);

//$orderStatus = "orderCreated";

##consider entering this to database ...

$data =  array(
              "labOrderId" => $oid,
              "productId" => $pid,
              "labId" => $labId,
              "customerName" => $cname,
              "customerPhone" => $phoneno,
              "address1" => $address1,
              "address2" => $address2,
              "city" => $city,
              "zip" => $zip,
              "province" => $province,
              "country" => $country,
              "od_sph" => $od_sph,
              "od_cyl" => $od_cyl,
              "od_axis" => $od_axis,
              "od_add" => $od_add,
              "os_sph" => $os_sph,
              "os_cyl" => $os_cyl,
              "os_axis" => $os_axis,
              "os_add" => $os_add,
              "pd" => $pd_sph,
              "date_created" => $labOrderCreateDate,
              "comment" =>$comment,
              "customer_order_date" => $orderdate,
              "requested_date" =>$reqorderdate,
              "orderStatus" =>'pdfFileCreated'//blank, this will only change the status when the order pdf is really successfully created --> $orderStatus,
            );



require_once('html2pdf/html2pdf.class.php');
ob_start();

include ('snippet-labOrderTemplate.php');

$content = ob_get_clean();

$temp_dir = $_SERVER['DOCUMENT_ROOT']."/labPdf"; // change path whereever need to save pdf file
//$temp_dir = "/var/www/html/ddbackend/new/pdf"; //whole path to accomododate ip based access

  if(!$temp_dir || !file_exists($temp_dir)) return false;

    $filename = $roid .'.pdf';

      $pdf_file_path =  $temp_dir . DIRECTORY_SEPARATOR . $filename;

      try
      {

          $html2pdf = new HTML2PDF('P', 'A4', 'en');
          $html2pdf->pdf->SetDisplayMode('fullpage');

    //  $html2pdf->pdf->SetProtection(array('print'), 'spipu');

          $html2pdf->writeHTML($content);
          $html2pdf->Output($pdf_file_path, 'F');

          //header("Location:labPdf/".$filename);

          require_once '../../Twig/lib/Twig/Autoloader.php';
          Twig_Autoloader::register();

          $loader = new Twig_Loader_Filesystem('../views');
          $twig = new Twig_Environment($loader);

          ##update order status in the database

          require 'mongoConn.php';

          //echo "included file";

            $orderId = $roid;
            settype($orderId, "integer"); //boy this has to be done
            $labComment = $comment;


/*
#put all the stuff in database
#.notation way to access and set key value pairs doesn't work if the
initial array is set to empty in mongodb. so best to check if empty..and if yes..set it to something else.

#reference: http://stackoverflow.com/questions/11261521/mongodb-update-nested-array

         $order = $coll->findOne(array('id'=>$orderId)); //$coll->findOne(array('id'=>492898561));

         //echo "order id is". $order['id'];

         if ($order['dd_attributes'] == NULL) {
           echo "yes it is null";

           $query1 = array('$set' => array("dd_attributes"=>array("placeholder" => "placeholder")));

           $coll->update(array('id' => $orderId ),$query1); // $coll->update(array('id' =>492898561),$query1);

          // echo "done";
         }

         $query = array('$set'=> array(
                                  "dd_attributes.orderStatus" => "orderFileCreated",
                                  "dd_attributes.labOrderComment" => $labComment,
                                  "dd_attributes.labOrderDate" => $labOrderCreateDate,
                                  "dd_attributes.fileLocation" => $pdf_file_path
                                ));

                    
*/

            $data['pdfFilePath'] = $pdf_file_path;

            $query = array('$set' => array("lab_attributes"=>$data));


            try {
              $coll->update(array('id' =>$orderId),$query); // $coll->update(array('id' =>492920705),$query);

              echo "MONGO SPEAKING";



            }

            catch (MongoResultException $e) {

             //$e->getCode(), " : ", $e->getMessage(), "\n";

             $error = $e->getMessage();

             echo "MONGO Error";

            }


          ###

          echo $twig->render('pavan_email.html', array("filename" => $filename, "orderId" => $roid, "order" => $oid));//


      }

      catch(HTML2PDF_exception $e) {
          echo $e;
          //exit;
      }




?>
