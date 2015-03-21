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

class AdminController
{
    protected $func = '';
    protected $response_code = array(
        '10' => 'Success',
        '11' => 'Missing Arguments',
        '12' => 'Failed to connect to the database',
        '13' => 'Database query failed'
    );


    public function __construct() {
        session_start();
        $func = $_GET['func'];
        $this->$func();

    }

    /**
     * Add event takes the form inputs via post
     * and then use custom_filter_input to filter
     * the incoming data and the nuse it.
     * and returns success message on success else
     * return a custom message and not the actual
     * error message as database errors should not
     * be shown to the user EVER ! BEWARE OF THIS
     * else I WILL KILL YOU
     */
    function addEvent()
    {
        $data = json_decode(file_get_contents("php://input"));
        $data->organiser_id = (isset($data->organiser_id) && $data->organiser_id!=null )?$this->custom_filter_input($data->organiser_id):'';
//        $data->organiser_id = (isset($_SESSION['organiser_id']) && $_SESSION['organiser_id']!=null )?$this->custom_filter_input($_SESSION['organiser_id']):'';
        $data->event_name = (isset($data->event_name) && $data->event_name!=null )?$this->custom_filter_input($data->event_name):'';
        $data->venue_name = (isset($data->venue_name) && $data->venue_name!=null )?$this->custom_filter_input($data->venue_name):'';
        $data->event_overview =  (isset($data->event_overview) && $data->event_overview!=null )?$this->custom_filter_input( $data->event_overview):'';
        $data->event_location = (isset($data->event_location) && $data->event_location!=null )?$this->custom_filter_input( $data->event_location):'';
        $data->event_area =  (isset($data->event_area) && $data->event_area!=null )?$this->custom_filter_input( $data->event_area):'';
        $data->event_cost =  (isset($data->event_cost) && $data->event_cost!=null )?$this->custom_filter_input( $data->event_cost):'';
        $data->event_category =  (isset($data->event_category) && $data->event_category!=null )?$this->custom_filter_input( $data->event_category):'';
        $data->hash1 =  (isset($data->hash1) && $data->hash1!=null )?$this->custom_filter_input( $data->hash1):'';
        $data->hash2 =  (isset($data->hash2) && $data->hash2!=null )?$this->custom_filter_input( $data->hash2):'';
        $data->hash3 =  (isset($data->hash3) && $data->hash3!=null )?$this->custom_filter_input( $data->hash3):'';
        $data->event_hashtags = $this->generateHashtag($data->hash1, $data->hash2, $data->hash3);

        $model = new AdminModel();
        $result = $model->addEvent($data);
        if($result['status'] == "success")
        {
            echo json_encode($result);
        }
        else
        {
            echo $result['message'];
        }
    }


    /**
     * function takes the post data as input from the
     * model form (and also applies custom_filter_input function)
     * and updates the database with new
     * data filled by the user.
     * It calls generageHashtags function to merge the
     * hashtags into one single string.
     * It finally calls the updateEventDetails model
     * function and recieves the result
     * THe result contains a status and it's corresponding
     * message(either positive or negative message)
     * returns an array with status and message
     */
    function updateEventDetails()
    {
        $data = json_decode(file_get_contents("php://input"));
        $data->event_name = (isset($data->event_name) && $data->event_name!=null )?$this->custom_filter_input($data->event_name):'';
        $data->venue_name = (isset($data->venue_name) && $data->venue_name!=null )?$this->custom_filter_input($data->venue_name):'';
        $data->event_overview =  (isset($data->event_overview) && $data->event_overview!=null )?$this->custom_filter_input( $data->event_overview):'';
        $data->event_location = (isset($data->event_location) && $data->event_location!=null )?$this->custom_filter_input( $data->event_location):'';
        $data->event_area =  (isset($data->event_area) && $data->event_area!=null )?$this->custom_filter_input( $data->event_area):'';
        $data->event_cost =  (isset($data->event_cost) && $data->event_cost!=null )?$this->custom_filter_input( $data->event_cost):'';
        $data->event_category =  (isset($data->event_category) && $data->event_category!=null )?$this->custom_filter_input( $data->event_category):'';
        $data-> hash1 =  (isset($data->hash1) && $data->hash1!=null )?$this->custom_filter_input( $data->hash1):'';
        $data-> hash2 =  (isset($data->hash2) && $data->hash2!=null )?$this->custom_filter_input( $data->hash2):'';
        $data-> hash3 =  (isset($data->hash3) && $data->hash3!=null )?$this->custom_filter_input( $data->hash3):'';
        $data->event_hashtags = $this->generateHashtag($data->hash1, $data->hash2, $data->hash3);
        $model = new AdminModel();
        $result = $model->updateEventDetails($data);
        if($result['status'] == 'success')
        {
            echo json_encode($result);
        }
        else
        {
            echo $result['message'];
        }

    }


    /**
     * This function takes as input the event_detail_id
     * of an event thats needs to be deleted.
     * No actual deletion happens. Only the active field or state
     * of the event is set to false. i.e the event becomes
     * inactive
     */
    function deleteEvent()
    {
        $event_detail_id = $_GET['event_detail_id'];
        $model = new AdminModel();
        $result =  $model->deleteEvent($event_detail_id);
        var_dump($result);

    }


    /**This funtion takes 3 inputs from the $_GET array
     * creates a directory if not already present and
     * then uploads the image in the newly created
     * directory or the already existing one.
     * It checks for the file validations such as max
     * file size etc and then uploads the file to
     * a directory. The directory name is just the name of
     * the organiser ID.
     */
    function uploadImages()
    {
//        $organiser_id = (isset($_SESSION['organiser_id']) && $_SESSION['organiser_id']!=null )?$this->custom_filter_input($_SESSION['organiser_id']):'';
        $organiser_id = $_GET['organiser_id'];
        $event_detail_id = $_GET['event_detail_id'];
        $primary_image = $_GET['primary_image'];
//        if(!is_dir($organiser_id))
//        {
//            mkdir('client_images/'.$organiser_id);
//        }
//        if(php_uname('s') != 'Linux' && !is_dir($organiser_id))
//        {
//            mkdir('client_images/' .$organiser_id);
//        }
        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $file_base = basename($filename,$ext);
        $filename = $file_base.microtime().'.'.$ext;
        $destination = 'client_images/' . $filename;
        if(php_uname('s') != 'Linux')
        {
            $destination = 'client_images/' . $filename;
        }
        if(move_uploaded_file( $_FILES['file']['tmp_name'] , $destination ))
        {
            $model = new AdminModel();
            $imageUploaded = $model->addImageUrlToDatabase($destination, $event_detail_id, $primary_image);
           if($imageUploaded)
           {
               echo json_encode($imageUploaded);

           }
           else
           {
                echo json_encode($imageUploaded['message']);
           }
        }
    }


    /**This funtion takes 2 inputs from the $_GET array
     *  uploads the image in the directory
     * It checks for the file validations such as max
     * file size etc and then uploads the file to
     * a directory. The directoy name is just the name of
     * the organiser ID.
     */
    function uploadUpdatedImages()
    {
//        $organiser_id = (isset($_SESSION['organiser_id']) && $_SESSION['organiser_id']!=null )?$this->custom_filter_input($_SESSION['organiser_id']):'';
        $organiser_id = $_GET['organiser_id'];
        $event_image_id = $_GET['event_image_id'];
        $image_path_old = $_GET['image_path_old'];
        if(unlink($image_path_old)){
            $filename = $_FILES['file']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $file_base = basename($filename,$ext);
            $filename = $file_base.microtime().'.'.$ext;
            $destination = 'client_images/' .$organiser_id.'/'. $filename;
            if(php_uname('s') != 'Linux')
            {
                $destination = 'client_images/' .$organiser_id.'/'. $filename;
            }
            if(move_uploaded_file( $_FILES['file']['tmp_name'] , $destination ))
            {
                $model = new AdminModel();
                $imageUploaded = $model->addUpdatedImageUrlToDatabase($destination, $event_image_id);
                if($imageUploaded)
                {
                    echo json_encode($imageUploaded);

                }
                else
                {
                    echo json_encode($imageUploaded['message']);
                }
            }
        }
        else{
            echo 'Deletion of previous file failed';
        }

    }

    /**
     * @param $hash1
     * @param $hash2
     * @param $hash3
     * @return string
     * takes as input a number of hashtags (currently 3)
     * Merge all the hashtags and return it as a string
     */
    function generateHashtag($hash1, $hash2, $hash3)
    {
        $hashtag[0] = $hash1;
        $hashtag[1] = $hash2;
        $hashtag[2] = $hash3;
        $final_hash_string = implode(' ',$hashtag);
        return $final_hash_string;

    }

    /** this function does not take any input
     * returns an array of event categories from the database
     * If there are no categories in the database or any other
     * database error occurs then appropriate message with status
     * is returned.
     */
    function getEventCategory()
    {
        $model = new AdminModel();
        $result = $model->getEventCategory();
        if($result['status'] == 'success')
        {
            echo json_encode($result);
        }
        else
        {
            echo $result['message'];
        }
    }

    /** this function does not take any input
     * returns an array of event areas from the database
     * If there are no areas in the database or any other
     * database error occurs then appropriate message with status
     * is returned.
     */
    function getEventArea()
    {
        $model = new AdminModel();
        $city = $_GET['city'];
        $result = $model->getEventArea($city);
        if($result['status'] == 'success')
        {
            echo json_encode($result);
        }
        else
        {
            echo $result['message'];
        }
    }

    /** this function does not take any input
     * returns an array of event cities from the database
     * If there are no cities in the database or any other
     * database error occurs then appropriate message with status
     * is returned.
     */
    function getEventCity()
    {
        $model = new AdminModel();
        $result = $model->getEventCity();
        if($result['status'] == 'success')
        {
            echo json_encode($result);
        }
        else
        {
            echo $result['message'];
        }
    }

    /**
     * This function takes as input the organiser_id
     * and returns an array of data corresponding to
     * all the events existing for the particular
     * organiser
     */
    function getAllEvents()
    {
        $organiser_id = (isset($_SESSION['organiser_id']) && $_SESSION['organiser_id']!=null )?$this->custom_filter_input($_SESSION['organiser_id']):'';
        $model = new AdminModel();
        $result = $model->getAllEvents($organiser_id);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            echo "There are no existing events. Please contact the administrator for further enquiry";
        }

    }

    function custom_filter_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$ob = new AdminController();
