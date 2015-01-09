<?php
/**
 * Created by PhpStorm.
 * User: rishabh
 * Date: 07-01-2015
 * Time: 10:56
 */
header("Access-Control-Allow-Origin: *");
include_once 'adminModel.php';

class EventController{
    protected $func = '';
    protected $response_code = array(
        '10' => 'Success',
        '11' => 'Missing Arguments',
        '12' => 'Failed to connect to the database',
        '13' => 'Database query failed'
    );
    protected $model;
    public function __construct() {
        $this->model = new EventModel();
    }
}