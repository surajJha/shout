<?php
/**
 * Created by PhpStorm.
 * User: rishabh
 * Date: 07-01-2015
 * Time: 10:57
 */
//ini_set('display_startup_errors',1);
//ini_set('display_errors',1);
//error_reporting(-1);
include_once 'databaseConnection.php';
class AdminModel {

    function __contruct(){}

    /**
     * @return mysqli
     * function creates a new DatabaseConnection object
     * and calls the getCOnntection() and returns
     * a mysqli object
     */
    protected function getDatabaseObject() {
        $db = new DatabaseConnection();
         return $db->getConnection();
    }

    public  function tp(){

    $sql = $this->getDatabaseObject();
        var_dump($sql);


   }
}
$ob = new AdminModel();
$ob->tp();

