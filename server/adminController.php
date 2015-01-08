<?php
/**
 * Created by PhpStorm.
 * User: rishabh
 * Date: 07-01-2015
 * Time: 10:56
 */

header("Access-Control-Allow-Origin: *");
include_once 'adminModel.php';

class AdminController{
    protected $func = '';
    protected $response_code = array(
        '10' => 'Success',
        '11' => 'Missing Arguments',
        '12' => 'Failed to connect to the database',
        '13' => 'Database query failed'
    );


    public function __construct() {
        $func = $_GET['func'];
        $this->$func();
    }

    function addEvent(){

    }

    function editEvent(){

    }

    function viewAllEvent(){

    }

    function deleteEvent(){

    }

    function showExistingImage(){

    }
}