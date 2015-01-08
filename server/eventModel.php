<?php
/**
 * Created by PhpStorm.
 * User: rishabh
 * Date: 07-01-2015
 * Time: 10:57
 */
include_once 'databaseConnection.php';
class EventModel{
    protected $db;
    function __contruct(){
        $this->db = new DatabaseConnection();
    }
}