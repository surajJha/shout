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
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
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

    /**
     * Add event takes the form inputs via post
     * and returns success message on succes else
     * return a custom message and not the actual
     * error message as database errors should not
     * be shown to the user EVER ! BEWARE OF THIS
     * else I WILL KILL YOU
     */
    function addEvent(){
        /**
         * Cannot access POST data as usual
         * we need to use file_get_contents as
         * done below
         */
        $data = json_decode(file_get_contents("php://input"));
        $data->event_hashtags = $this->generateHashtag($data->hash1, $data->hash2, $data->hash3);

        $model = new AdminModel();

       $result = $model->addEvent($data);

        if($result['status'] == "success") {
            // echo actual response only when result is success and
            // not if result is a failure.
            echo json_encode($result);
        }
        else {
            // do not disclose the actual error message
            echo 'Sorry, The data couldn\'t be saved. Please try again.';
        }

    }

    /**
     * @param $hash1
     * @param $hash2
     * @param $hash3
     * @return string
     * Merge all the hashtags and return it as a string
     */
    function generateHashtag($hash1, $hash2, $hash3){
        $hashtag[0] = $hash1;
        $hashtag[1] = $hash2;
        $hashtag[2] = $hash3;
        $final_hash_string = implode(' ',$hashtag);
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

    /**
     * creates a directory if not already present and
     * then uploads the image in the newly created
     * directory or the already existing one
     */
    function uploadImages(){
        $organiser_id = $_GET['organiser_id'];
        $event_detail_id = $_GET['event_detail_id'];
        $primary_image = $_GET['primary_image'];
        if(!is_dir($organiser_id)) {
            /**
             *  the directory DOES NOT already exists
             * so make a new directory
             */
            mkdir('/var/www/html/shout/server/client_images/'.$organiser_id);
        }
        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $file_base = basename($filename,$ext);


        $filename = $file_base.microtime().'.'.$ext;

        $destination = '/var/www/html/shout/server/client_images/' .$organiser_id.'/'. $filename;

        if(move_uploaded_file( $_FILES['file']['tmp_name'] , $destination )){
            // when upload is done then make a database instertion of the
            // path to the image
            $model = new AdminModel();
            $imageresult = $model->addImageUrlToDatabase($destination, $event_detail_id, $primary_image);
           if($imageresult){
               echo $imageresult;

           }
            else {
                echo 'image URL was not saved properly.';
            }
        }


    }

    /**
     * returns an array of event categories from the database
     */
    function getEventCategory() {
        $model = new AdminModel();
        $result = $model->getEventCategory();
        if($result['status'] == 'success'){
            echo json_encode($result);
        }
        else {
            echo "no available categories";
        }
    }

    /**
     * returns an array of areas from the database
     */
    function getEventArea() {
        $model = new AdminModel();
        $result = $model->getEventArea();
        if($result['status'] == 'success'){
            echo json_encode($result);
        }
        else {
            echo "no available areas";
        }
    }

    function getAllEvents() {
        $organiser_id = $_GET['organiser_id'];
        $model = new AdminModel();
        $result = $model->getAllEvents($organiser_id);
        if($result['status'] == 'success'){
            echo json_encode($result['data']);
        }
        else {
            echo "No events for the client";
        }

    }
}

$ob = new AdminController();
