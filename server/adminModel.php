<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once 'databaseConnection.php';
class AdminModel
{
    private $event_organiser_id;
    public function __construct()
    {
        $this->event_organiser_id =1;
    }

    /**
     * @return mysqli
     * function creates a new DatabaseConnection object
     * and calls the getCOnntection() and returns
     * a mysqli object
     */
    protected function getDatabaseObject()
    {
        $db = new DatabaseConnection();
         return $db->getConnection();
    }


   public function addEvent($data)
   {
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

       $query = "insert into event_detail (venue_name,event_name,event_overview,event_hashtags,event_location,event_area,event_cost,category_name,event_organizer_id) VALUES ('{$venue_name}','{$event_name}','{$event_overview}','{$event_hashtags}','{$event_location}','{$event_area}','{$event_cost}','{$category_name}','{$this->event_organiser_id}')";
       $eventDetailInserted = $db->query($query);
       if($eventDetailInserted)
       {
           // getting id of last inserted row
           $event_detail_id = $db->insert_id;
           $this->addHashToDatabase($hash1, $hash2, $hash3);
           $eventScheduleInserted = $this->addEventScheduleToDatabase($event_detail_id, $repeatType, $repeatEvent,$no_of_months, $no_of_weeks, $data->datetime);
           if($eventScheduleInserted)
           {
               $result = array();
               $result['status'] = 'success';
               $result['organiser_id'] = $this->event_organiser_id;
               $result['event_detail_id'] = $event_detail_id;
               return $result;
           }
           else
           {
               return 'Error in running the second query, during inserting data in the schedule table '.$db->error;
           }
       }
       else
       {
           return 'Error in running the first query to insert data in details table '.$db->error;
       }
   }


    public function updateEventDetails($data)
    {
        $db = $this->getDatabaseObject();
        // $event_schedule_id = $db->real_escape_string($data['event_schedule_id']);
        $event_detail_id = $db->real_escape_string($data->event_detail_id);
        $venue_name = $db->real_escape_string($data->venue_name);
        $event_name = $db->real_escape_string($data->event_name);
        $event_overview =  $db->real_escape_string( $data->event_overview);
        $event_hashtags =  $db->real_escape_string($data->event_hashtags);
        $event_location =  $db->real_escape_string( $data->event_location);
        $event_area =  $db->real_escape_string( $data->event_area);
        $event_cost =  $db->real_escape_string( $data->event_cost);
        $category_name =  $db->real_escape_string( $data->event_category);
        $change_event_schedule_flag = $db->real_escape_string( $data->change_event_schedule_flag);
        $repeatEvent = $db->real_escape_string( $data->repeatEventCheckbox);
        $repeatType = $db->real_escape_string( $data->repeatType);
        $no_of_weeks = $db->real_escape_string( $data->no_of_weeks);
        $no_of_months = $db->real_escape_string( $data->no_of_months);
        $datetime =  $data->updated_date_time_array;
        $hash1 = $db->real_escape_string($data->hash1);
        $hash2 = $db->real_escape_string($data->hash2);
        $hash3 = $db->real_escape_string($data->hash3);
       // $changed_image_details = $data->changedImageDetails;
       // $eventImageInserted = '';
      //  $changed_image_path = $data->changedImageFilePath;
        $final_result = [];
     //   $event_organizer_id =  $db->real_escape_string($data->event_organizer_id);
        $query = "UPDATE event_detail set venue_name='{$venue_name}', event_name='{$event_name}', event_overview='{$event_overview}', event_hashtags='{$event_hashtags}', event_location='{$event_location}', event_area='{$event_area}', event_cost='{$event_cost}', category_name='{$category_name}' WHERE event_detail_id='{$event_detail_id}'";
        $eventDetailsInserted = $db->query($query);
        if($eventDetailsInserted)
        {
            $this->addHashToDatabase($hash1, $hash2, $hash3);
            if($change_event_schedule_flag)
            {
                // event schedule has been updated
                $this->deletePreviousEventSchedule($event_detail_id);
                $eventScheduleInserted = $this->addEventScheduleToDatabase($event_detail_id, $repeatType, $repeatEvent,$no_of_months, $no_of_weeks, $datetime);
                if($eventScheduleInserted)
                {

                        $final_result['status'] = 'success';
                        $final_result['message'] = 'Event Updated Successfully';
                        return $final_result;

                }
                else
                {
                        $final_result['status'] = 'failure';
                      $final_result['message'] = 'Event Details were updated but event schedule updation failed. Please try again properly';
                      return $final_result;
                }
            }
//            else if(count($changed_image_details) != 0){
//                for($i=0; $i<count($changed_image_details);$i++){
//                    if($changed_image_details[$i] != ''){
//                     //   $this->deletePreviousEventImage($changed_image_details[$i]);
//                       $eventImageInserted = $this->addEventImageToDatabase($changed_image_details[$i]);
//                    }
//                }
//
//                if($eventImageInserted){
//                    $final_result['status'] = 'success';
//                    $final_result['message'] = 'Image and event details were updated successfully';
//                }
//                else{
//                    $final_result['status'] = 'failure';
//                    $final_result['message'] = 'event details was updated successfully but image updation failed. Please try again';
//                }
//            }
            else
            {
                     $final_result['status'] = 'success';
                     $final_result['message'] = 'Event Updated Successfully';
                     return $final_result;
            }
         }
        else
        {
                 $final_result['status'] = 'failure';
                 $final_result['message'] = 'Updation failed. Nothing was Updated';
                 return $final_result;
        }
    }

    /**
     * @param $event_detail_id
     */
    public function deleteEvent($event_detail_id)
    {
        $db = $this->getDatabaseObject();
        $query = "Delete from event_detail WHERE event_detail_id='{$event_detail_id}'";
        $res1 = $db->query($query);
        $query = "Delete from event_schedule WHERE event_detail_id='{$event_detail_id}'";
        $res2 = $db->query($query);
    }

    public function getAllEvents($organiser_id)
    {
        $db = $this->getDatabaseObject();
        $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, ed.event_area, ed.event_cost, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image,ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_organizer_id = '{$organiser_id}' group by ed.event_detail_id";
        $temp = $db->query($query);
        $result =array();
        if($temp->num_rows>0)
        {
            $i = 0;
            while($row = $temp->fetch_assoc())
            {
                $rows[$i]['category_name'] = $row['category_name'];
                $rows[$i]['event_area'] = $row['event_area'];
                $rows[$i]['event_cost'] = $row['event_cost'];
                $rows[$i]['event_detail_id'] = $row['event_detail_id'];
                $rows[$i]['event_location'] = $row['event_location'];
                $rows[$i]['event_name'] = $row['event_name'];
                $rows[$i]['event_overview'] = $row['event_overview'];
                $rows[$i]['venue_name'] = $row['venue_name'];
                $rows[$i]['datetime'] = array();
                $rows[$i]['image'] = array();
                $rows[$i]['event_hashtags'] = explode(' ',$row['event_hashtags']);
                if($row['schedule'])
                {
                    $temp_date_array = explode(',',$row['schedule']);
                    $y = array();
                    foreach ($temp_date_array as $x)
                    {
                        $y = explode('=',$x);
                        $z = array();
                        $z['date'] = $y[0];
                        $z['start_time'] = $y[1];
                        $z['end_time'] = $y[2];
                        array_push($rows[$i]['datetime'] , $z);
                    }
                }
                $temp_image_array = explode(',',$row['image']);
                $y = array();
                foreach ($temp_image_array as $x)
                {
                    $y = explode('=',$x);
                    $z = array();
                    $z['image_path'] = $y[0];
                    $z['primary'] = $y[1];
                    $z['event_image_id'] = $y[2];
                    array_push($rows[$i]['image'] , $z);
                }


                $i++;
            }
            $result['status'] = 'success';
            $result['data'] =$rows;
           return $result;
        }
        else {
            $result['status'] = "failure";
            $result['data'] = '';

        }
    }
    /**
     * *******************************Utility Functions*******************************
     */

    /**
     * Add the image URL to the event_image table in the database
     */
    public function addImageUrlToDatabase($destination, $event_detail_id, $primary_image)
    {
        $db = $this->getDatabaseObject();
        $query = "insert into event_image (event_detail_id, event_image_name, primary_image) VALUES ('{$event_detail_id}', '{$destination}','{$primary_image}')";
        $result = $db->query($query);
        return $result;
    }

    public function  addHashToDatabase($hash1, $hash2, $hash3)
    {
        $db = $this->getDatabaseObject();
        for($k=1; $k<=3; $k++)
        {
            if($k==1)
            {
                $hash = $hash1;
            }
            elseif($k==2)
            {
                $hash = $hash2;
            }
            elseif($k==3)
            {
                $hash = $hash3;
            }
            $query = "select * from hashtag where hashtag_name= '{$hash}'";
            $temp = $db->query($query);

            if($temp->num_rows == 0)
            {
                $query = "insert into hashtag (hashtag_name) VALUES ('{$hash}')";
                //   var_dump($query);
            }
            else
            {
                $row[][] = $temp->fetch_row();
                $row = intval($row[0][2]);
                $query = "update hashtag set hashtag_count = '{$row}' + 1  where hashtag_name = '{$hash}' ";

            }
            $db->query($query);
        }
    }

    public function addEventScheduleToDatabase($event_detail_id, $repeatType, $repeatEvent,$no_of_months, $no_of_weeks, $datetime)
    {
        $db = $this->getDatabaseObject();
        if($repeatEvent)
        {
            // repititive event, hence  a set of rows of datetime will be inserted
            if($repeatType =='weekly')
            {
                for($i = 0;$i<count($datetime);$i++)
                {
                    $event_date = $datetime[$i]->date;
                    $event_start_time = $datetime[$i]->starttime;
                    $event_end_time = $datetime[$i]->endtime;
                    for ($j = 0; $j < $no_of_weeks; $j++)
                    {
                        $query = "insert into event_schedule (event_detail_id,event_date,event_start_time,event_end_time) VALUES ('{$event_detail_id}','{$event_date}','{$event_start_time}','{$event_end_time}')";
                        $result = $db->query($query);
                        $date = new DateTime($event_date);
                        $date->add(new DateInterval('P1W'));
                        $event_date = $date->format('Y-m-d');
                    }
                }
            }
            else if($repeatType == 'monthly')
            {
                for($i = 0;$i<count($datetime);$i++)
                {
                    $event_date = $datetime[$i]->date;
                    $event_start_time = $datetime[$i]->starttime;
                    $event_end_time = $datetime[$i]->endtime;
                    for ($j = 0; $j < $no_of_months; $j++)
                    {
                        $query = "insert into event_schedule (event_detail_id,event_date,event_start_time,event_end_time) VALUES ('{$event_detail_id}','{$event_date}','{$event_start_time}','{$event_end_time}')";
                        $result = $db->query($query);
                        $date = new DateTime($event_date);
                        $date->add(new DateInterval('P1M'));
                        $event_date = $date->format('Y-m-d');
                    }
                }
            }


        }
        else
        {
            // non-repititive event hence only on set of datetime will be inserted
            for($i = 0;$i<count($datetime);$i++)
            {
                $event_date = $datetime[$i]->date;
                $event_start_time = $datetime[$i]->starttime;
                $event_end_time = $datetime[$i]->endtime;
                $query = "insert into event_schedule (event_detail_id,event_date,event_start_time,event_end_time) VALUES ('{$event_detail_id}','{$event_date}','{$event_start_time}','{$event_end_time}')";
                $result = $db->query($query);
            }
        }
        return $result;
    }

    public function getEventCategory()
    {
        $db = $this->getDatabaseObject();
        $query = "select category_name from category";
        $temp = $db->query($query);
        $result =array();
        if($temp->num_rows>0)
        {
            while($row = $temp->fetch_row())
            {
                $rows[] = $row;
            }
            $result['status'] = 'success';
            $result['data'] = $rows;
            return $result;
        }
        else
        {
            $result['status'] = "failure";
        }
    }

    public function getEventArea()
    {
        $db = $this->getDatabaseObject();
        $query = "SELECT area_name from area";
        $temp = $db->query($query);
        $result =array();
        if($temp->num_rows>0){
            while($row = $temp->fetch_row())
            {
                $rows[] = $row;
            }
            $result['status'] = 'success';
            $result['data'] = $rows;
            return $result;
        }
        else
        {
            $result['status'] = "failure";
            $result['data'] = '';
        }
    }

    public function deletePreviousEventSchedule($event_detail_id)
    {
        $db = $this->getDatabaseObject();
        $query = "delete from event_schedule WHERE event_detail_id='{$event_detail_id}'";
        $deleted = $db->query($query);
        return $deleted;
    }

}


