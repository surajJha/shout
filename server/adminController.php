<?php
/**
 * Created by PhpStorm.
 * User: rishabh
 * Date: 07-01-2015
 * Time: 10:56
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
        /**
         * Cannot access POST data as usual
         * we need to use file_get_contents as
         * done below
         */
        $data = json_decode(file_get_contents("php://input"));
        print_r($data);
        $data->event_hashtags = $this->generateHashtag($data->hash1, $data->hash2, $data->hash3);

//        $data = array();
//        $data['venue_name'] = $_POST['venue_name'];
//        $data['event_name'] = $_POST['event_name'];
//        $data['event_overview'] = $_POST['event_overview'];
//        $data['event_hashtags'] = $_POST['event_hashtags'];
//        $data['event_date'] = $_POST['event_date'];
//        $data['event_start_time'] = $_POST['event_start_time'];
//        $data['event_end_time'] = $_POST['event_end_time'];
//        $data['event_location'] = $_POST['event_location'];
//        $data['event_area'] = $_POST['event_area'];
//        $data['event_cost'] = $_POST['event_cost'];
//        $data['category_name'] = $_POST['category_name'];
//        $data['event_organizer_id'] = 1;

        $model = new AdminModel();
      $result = $model->addEvent($data);
       // var_dump('result : '.$result);
        echo $result;
      //  var_dump($data);
    }

    function generateHashtag($hash1, $hash2, $hash3){
        $hashtag[0] = $hash1;
        $hashtag[1] = $hash2;
        $hashtag[2] = $hash3;
        $final_hash_string = implode('',$hashtag);
        return $final_hash_string;

    }

    function editEvent(){
        $data = array();
        $data['event_schedule_id'] = $_POST['event_schedule_id'];
        $data['event_detail_id'] = $_POST['event_detail_id'];
        $data['venue_name'] = $_POST['venue_name'];
        $data['event_name'] = $_POST['event_name'];
        $data['event_overview'] = $_POST['event_overview'];
        $data['event_hashtags'] = $_POST['event_hashtags'];
        $data['event_date'] = $_POST['event_date'];
        $data['event_start_time'] = $_POST['event_start_time'];
        $data['event_end_time'] = $_POST['event_end_time'];
        $data['event_location'] = $_POST['event_location'];
        $data['event_area'] = $_POST['event_area'];
        $data['event_cost'] = $_POST['event_cost'];
        $data['category_name'] = $_POST['category_name'];
        $data['event_organizer_id'] = 1;

        $model = new AdminModel();
        $result = $model->editEvent($data);
    }

    function viewAllEvents(){
        $event_organizer_id = 1; // $_session se ayega baad mein
        $model = new AdminModel();
        $result = $model->viewAllEvents($event_organizer_id);

    }

    function deleteEvent(){
        $event_detail_id = $_POST['event_detail_id'];
        $model = new AdminModel();
        $result =  $model->deleteEvent($event_detail_id);

    }

    function showExistingImage(){

    }
}

$ob = new AdminController();
