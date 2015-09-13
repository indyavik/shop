<?php

##store db connection info.

#use function as needed. pass dbname and collection and retrieve the object.

function dbconn($dbname,$collection) {

  $m = new MongoClient();
  $db = $m->$dbname;
  $coll = $db->$collection;

  return array("db"=>$db,"coll"=>$coll);

}

#change parameter here as needed

$mongoConn = dbconn('api','pstuff') ;# -> use db and collection what you gonna need later.

$coll = $mongoConn['coll'];

/*

#####Some most used commands
$coll->findOne(array('id'=>806188225)); // find record matching id = 806....
$coll->update(array('id' =>492898561),$query); // update document with id = 49..., with $query
$query = array('$set' => array("dd_attributes"=>array("newInfoAdd_upsert" => "this is upserted Smith Lane", "field2" => "something")));

###find a document(order) where a particular field exists
$query= array("lab_attributes" => array('$exists' => true)); //
$query= array("lab_attributes.labId" => array('$exists' => true)); // finds documents where lab_attributes array has a filed called "labId" exists.
$coll->findOne($query) or $coll->find($query); // find() returns a cursor object that needs be iterated.

### find orders after a certain date
$coll->findOne(array("created_at" => array('$gt' => "2015-05-08T00:00:00-00:00")));

*/

?>
