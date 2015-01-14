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
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once 'databaseConnection.php';
class AdminModel {
    private $event_organiser_id;


    public function __construct(){
      //  echo 'inside construtor';
        $this->event_organiser_id =1;

    }

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

    /**
     * @param $data
     */
   public function addEvent($data) {
       $db = $this->getDatabaseObject();
      $venue_name = $db->real_escape_string($data->venue_name);
       $event_name = $db->real_escape_string($data->event_name);
      $event_overview =  $db->real_escape_string( $data->event_overview);
      $event_hashtags =  $db->real_escape_string($data->event_hashtags);
       $event_location =  $db->real_escape_string( $data->event_location);
      $event_area =  $db->real_escape_string( $data->event_area);
      $event_cost =  $db->real_escape_string( $data->event_cost);
      $category_name =  $db->real_escape_string( $data->event_category);
     // $event_organizer_id = 1; // $db->real_escape_string($data->event_organizer_id);
       /**
        * before firing the query , check if all the NO NULLABLE coloumns
        * have some value. only then should the query be fired
        */



       $query = "insert into event_detail (venue_name,event_name,event_overview,event_hashtags,event_location,event_area,event_cost,category_name,event_organizer_id) VALUES ('{$venue_name}','{$event_name}','{$event_overview}','{$event_hashtags}','{$event_location}','{$event_area}','{$event_cost}','{$category_name}','{$this->event_organiser_id}')";
      $res1 = $db->query($query);
       if($res1) {
           /**
            * if first query is true then insert data into event
            * schedule
            * getting id of last inserted row
            */

           $event_detail_id = $db->insert_id;
           for($i = 0;$i<count($data->datetime);$i++) {

               $event_date = $data->datetime[$i]->date;
               $event_start_time = $data->datetime[$i]->starttime;
               $event_end_time = $data->datetime[$i]->endtime;

               $query = "insert into event_schedule (event_detail_id,event_date,event_start_time,event_end_time) VALUES ('{$event_detail_id}','{$event_date}','{$event_start_time}','{$event_end_time}')";
               $res2 =  $db->query($query);
           }
           //     return $res1;
           if($res2){
                   $result = array();
               $result['status'] = 'success';
               $result['organiser_id'] = $this->event_organiser_id;

               return $result;
           }
           else {
               return 'Error in running the second query, during inserting data in the schedule table '.$db->error;
           }
       }
       else {
           return 'Error in running the first query to insert data in details table '.$db->error;
       }


       /**
        *  ccheck if res2 is true i.e query executed succesfullu
        * otherwise send appropriate error
        */
   }

    /**
     * @param $data
     */
    public function editEvent($data) {
        $db = $this->getDatabaseObject();
        $event_schedule_id = $db->real_escape_string($data['event_schedule_id']);
        $event_detail_id = $db->real_escape_string($data['event_detail_id']);
        $venue_name = $db->real_escape_string($data['venue_name']);
        $event_name = $db->real_escape_string($data['event_name']);
        $event_overview =  $db->real_escape_string( $data['event_overview']);
        $event_hashtags =  $db->real_escape_string($data['event_hashtags']);
        $event_date =  $db->real_escape_string($data['event_date']);
        $event_start_time =  $db->real_escape_string($data['event_start_time']);
        $event_end_time =  $db->real_escape_string( $data['event_end_time']);
        $event_location =  $db->real_escape_string( $data['event_location']);
        $event_area =  $db->real_escape_string( $data['event_area']);
        $event_cost =  $db->real_escape_string( $data['event_cost']);
        $category_name =  $db->real_escape_string( $data['category_name']);
        $event_organizer_id =  $db->real_escape_string($data['event_organizer_id']);

        $query = "UPDATE event_detail set venue_name='{$venue_name}', event_name='{$event_name}', event_overview='{$event_overview}', event_hashtags='{$event_hashtags}', event_location='{event_location}', event_area='{$event_area}', event_cost='{$event_cost}', category_name='{$category_name}', event_organizer_id='{$event_organizer_id}' WHERE event_detail_id='{$event_detail_id}'";

        $res1 = $db->query($query);
        /**
         * getting id of last inserted row
         */
        $event_detail_id = $db->insert_id;
        $query = "UPDATE event_schedule set event_date='{$event_date}', event_start_time='{$event_start_time}', event_end_time = '{$event_end_time}' WHERE event_schedule_id='{$event_schedule_id}'";
        $res2 =  $db->query($query);
        /**
         *  check if res2 is true i.e query executed succesfullu
         * otherwise send appropriate error
         */
    }

    /**
     * @param $event_detail_id
     */
    public function deleteEvent($event_detail_id) {
        $db = $this->getDatabaseObject();
        $query = "Delete from event_detail WHERE event_detail_id='{$event_detail_id}'";
        $res1 = $db->query($query);
        $query = "Delete from event_schedule WHERE event_detail_id='{$event_detail_id}'";
        $res2 = $db->query($query);
    }

    /**
     * @param $event_organizer_id
     * @return bool|mysqli_result
     */
    public function viewAllEvents($event_organizer_id) {
        $db = $this->getDatabaseObject();
        $event_organizer_id = $db->real_escape_string($event_organizer_id);
        $query = "select * FROM event_detail as ed,event_schedule as es WHERE ed.event_detail_id = es.event_detail_id AND ed.event_organizer_id='{$event_organizer_id}'";
        $result = $db->query($query);
        return $result;
    }


}


