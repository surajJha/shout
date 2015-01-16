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
       $repeatEvent = $db->real_escape_string( $data->repeatEventCheckbox);
       $repeatType = $db->real_escape_string( $data->repeatType);
       $no_of_weeks = $db->real_escape_string( $data->no_of_weeks);
       $no_of_months = $db->real_escape_string( $data->no_of_months);
       $hash1 = $db->real_escape_string($data->hash1);
       $hash2 = $db->real_escape_string($data->hash2);
       $hash3 = $db->real_escape_string($data->hash3);
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

           /**
            * after the event is added into the
            * database the hashtag table is updated
            * or added with the hashtag names
            */

           for($k=1; $k<=3; $k++){
               if($k==1){
                   $hash = $hash1;
               }
               elseif($k==2){
                   $hash = $hash2;
               }
               elseif($k==3){
                   $hash = $hash3;
               }
               $query = "select * from hashtag where hashtag_name= '{$hash}'";
               $temp = $db->query($query);
             //  var_dump($query);
               if($temp->num_rows == 0){
                   $query = "insert into hashtag (hashtag_name) VALUES ('{$hash}')";
                //   var_dump($query);
               }
               else{
                   $row[] = $temp->fetch_row();
                   $row = intval($row[0][2]);
                   $query = "update hashtag set hashtag_count = '{$row}' + 1  where hashtag_name = '{$hash}' ";
              //     var_dump($query);
               }
               $db->query($query);
           }





           if($repeatEvent) {
               /**
                * THe event is repetitive
                */
               if($repeatType =='weekly'){
                   for($i = 0;$i<count($data->datetime);$i++) {
                       $event_date = $data->datetime[$i]->date;
                       $event_start_time = $data->datetime[$i]->starttime;
                       $event_end_time = $data->datetime[$i]->endtime;
                       for ($j = 0; $j < $no_of_weeks; $j++) {
                           $query = "insert into event_schedule (event_detail_id,event_date,event_start_time,event_end_time) VALUES ('{$event_detail_id}','{$event_date}','{$event_start_time}','{$event_end_time}')";
                           $res2 = $db->query($query);
                           $date = new DateTime($event_date);
                           $date->add(new DateInterval('P1W'));
                           $event_date = $date->format('Y-m-d');
                       }
                   }
                  }
                   else if($repeatType == 'monthly') {
                       for($i = 0;$i<count($data->datetime);$i++) {
                           $event_date = $data->datetime[$i]->date;
                           $event_start_time = $data->datetime[$i]->starttime;
                           $event_end_time = $data->datetime[$i]->endtime;
                           for ($j = 0; $j < $no_of_months; $j++) {
                               $query = "insert into event_schedule (event_detail_id,event_date,event_start_time,event_end_time) VALUES ('{$event_detail_id}','{$event_date}','{$event_start_time}','{$event_end_time}')";
                               $res2 = $db->query($query);
                               $date = new DateTime($event_date);
                               $date->add(new DateInterval('P1M'));
                               $event_date = $date->format('Y-m-d');
                           }
                       }
                   }


           }
           else {
               /**
                * THe event is non-repetitive
                */
               for($i = 0;$i<count($data->datetime);$i++) {
                   $event_date = $data->datetime[$i]->date;
                   $event_start_time = $data->datetime[$i]->starttime;
                   $event_end_time = $data->datetime[$i]->endtime;
                   $query = "insert into event_schedule (event_detail_id,event_date,event_start_time,event_end_time) VALUES ('{$event_detail_id}','{$event_date}','{$event_start_time}','{$event_end_time}')";
                   $res2 = $db->query($query);

               }

           }

           if($res2){
                   $result = array();
               $result['status'] = 'success';
               $result['organiser_id'] = $this->event_organiser_id;
               $result['event_detail_id'] = $event_detail_id;

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
     * Add the image URL to the event_image table in the database
     */
    public function addImageUrlToDatabase($destination, $event_detail_id, $primary_image) {
        $db = $this->getDatabaseObject();
        $query = "insert into event_image (event_detail_id, event_image_name, primary_image) VALUES ('{$event_detail_id}', '{$destination}','{$primary_image}')";
        $result = $db->query($query);
        return $result;
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

    public function getEventCategory() {
        $db = $this->getDatabaseObject();
        $query = "select category_name from category";
        $temp = $db->query($query);
        $result =array();
        if($temp->num_rows>0){
            while($row = $temp->fetch_row()){
                $rows[] = $row;
            }
            $result['status'] = 'success';
            $result['data'] = $rows;
            return $result;
        }
        else {
           $result['status'] = "failure";

        }

    }

    public function getEventArea() {
        $db = $this->getDatabaseObject();
        $query = "SELECT area_name from area";
        $temp = $db->query($query);
        $result =array();
        if($temp->num_rows>0){
            while($row = $temp->fetch_row()){
                $rows[] = $row;
            }
            $result['status'] = 'success';
            $result['data'] = $rows;
            return $result;
        }
        else {
            $result['status'] = "failure";

        }

    }

    public function getAllEvents($organiser_id) {
        $db = $this->getDatabaseObject();
        $query = "select * from event_detail as e, event_schedule as es, event_image as ei where e.event_detail_id = es.event_detail_id and e.event_detail_id = ei.event_detail_id and e.event_organizer_id = '{$organiser_id}';";
       $temp = $db->query($query);
        $result =array();
        if($temp->num_rows>0){
            while($row = $temp->fetch_assoc()){
                $rows[] = $row;
            }
            $result['status'] = 'success';
            $result['data'] = $rows;
           return $result;
        }
        else {
            $result['status'] = "failure";

        }
    }


}


