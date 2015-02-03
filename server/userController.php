<?php
/**
 * Created by PhpStorm.
 * User: neha
 * Date: 28/1/15
 * Time: 12:29 PM
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once 'userModel.php';

class UserController
{
    protected $func = '';
    protected $response_code = array(
        '10' => 'Success',
        '11' => 'Missing Arguments',
        '12' => 'Failed to connect to the database',
        '13' => 'Database query failed'
    );


    public function __construct()
    {
       // $func = $_GET['func'];
        $this->getLatersEvents();

    }

    /**
     * This function takes as input the category_name
     * and returns an array of data corresponding to
     * all the events of particular category
     */

    public function getEventsByCategory(){
        $category_name = $_GET['category_name'];
        $model = new UserModel();
        $result = $model->getEventsByCategory($category_name);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            echo "There are no existing events.";
        }
    }

    /**
     * This function calculates today's date
     * and returns an array of data corresponding to
     * all the events happening today
     */

    public function getTodaysEvents(){
        $current_date = date("Y-m-d");
        $model = new UserModel();
        $result = $model->getTodaysEvents($current_date);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            echo "There are no existing events.";
        }
    }

    /**
     * This function calculates tomorrow's date
     * and returns an array of data corresponding to
     * all the events happening today
     */

    public function getTomorrowsEvents(){
         //1 Day = 24*60*60 = 86400

        $current_date = date("Y-m-d", time()+86400);
        $model = new UserModel();
        $result = $model->getTomorrowsEvents($current_date);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            echo "There are no existing events.";
        }
    }

    /**
     * This function calculates 7 days later date
     * and 2 days later date and sends it as parameter
     * and returns an array of data corresponding to
     * all the events happening today
     */

    public function getLatersEvents(){
        $from_date = date('Y-m-d', strtotime("+2 days"));
        $to_date = date('Y-m-d', strtotime("+7 days"));
        $model = new UserModel();
        $result = $model->getLatersEvents($from_date, $to_date);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            echo "There are no existing events.";
        }
    }

}

$model1 = new UserController();