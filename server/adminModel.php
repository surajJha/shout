<?php

//error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once 'databaseConnection.php';
class AdminModel
{
    protected $event_organiser_id;
    public function __construct()
    {
        $this->event_organiser_id =1;
    }

    /**
     * @return mysqli
     * function creates a new DatabaseConnection object
     * and calls the getConntection() and returns
     * a mysqli object
     */
    protected function getDatabaseObject()
    {
        $db = new DatabaseConnection();
         return $db->getConnection();
    }

    /**
     * @param $data
     * @return array|string
     * This function takes as input the post form variables
     * from the controller and applies real escape string to
     * make it safe for database insertion.
     * It also takes event_organiser_id from the session
     * variable (not implemented yet).
     * It then fires an insert query to the event_Detail
     * table, if it is successful , then it inserts the
     * hashtags to the hashtag table if hashtags are available(from user)
     * hence this query is optional.
     * It then inserts the date information into the event_schedule
     * table . If event schedule is inserted properly then this
     * function returns a succes message status and organiser_id
     * and event_detail id. Else it returns failure status and appropriate
     * failure message.
     *
     */
   public function addEvent($data)
   {
       $db = $this->getDatabaseObject();

       $venue_name = (isset($data->venue_name) && $data->venue_name!=null )?$db->real_escape_string($data->venue_name):'';
       $event_name = (isset($data->event_name) && $data->event_name!=null )?$db->real_escape_string($data->event_name):'';
       $event_overview =  (isset($data->event_overview) && $data->event_overview!=null )?$db->real_escape_string( $data->event_overview):'';
       $event_hashtags = (isset($data->event_hashtags) && $data->event_hashtags!=null )?$db->real_escape_string($data->event_hashtags):'';
       $event_location =  (isset($data->event_location) && $data->event_location!=null )?$db->real_escape_string( $data->event_location):'';
       $event_area =  (isset($data->event_area) && $data->event_area!=null )?$db->real_escape_string( $data->event_area):'';
       $event_cost =  (isset($data->event_cost) && $data->event_cost!=null )?$db->real_escape_string( $data->event_cost):'';
       $category_name =  (isset($data->event_category) && $data->event_category!=null )?$db->real_escape_string( $data->event_category):'';
       $repeatEvent = (isset($data->repeatEventCheckbox) && $data->repeatEventCheckbox!=null )?$db->real_escape_string( $data->repeatEventCheckbox):'';
       $repeatType = (isset($data->repeatType) && $data->repeatType!=null )?$db->real_escape_string( $data->repeatType):'';
       $no_of_weeks = (isset($data->no_of_weeks) && $data->no_of_weeks!=null )?$db->real_escape_string( $data->no_of_weeks):'';
       $no_of_months = (isset($data->no_of_months) && $data->no_of_months!=null )?$db->real_escape_string( $data->no_of_months):'';
       $hash1 = (isset($data->hash1) && $data->hash1!=null )?$db->real_escape_string($data->hash1):'';
       $hash2 = (isset($data->hash2) && $data->hash2!=null )?$db->real_escape_string($data->hash2):'';
       $hash3 = (isset($data->hash3) && $data->hash3!=null )?$db->real_escape_string($data->hash3):'';
     //$event_organizer_id = 1; // $db->real_escape_string($data->event_organizer_id);

       if($venue_name!='' && $event_name!='' && $event_overview!='' && $event_location!='' && $event_area!='' && $event_cost!='' && $category_name!=''){
           $query = "insert into event_detail (venue_name,event_name,event_overview,event_hashtags,event_location,event_area_id,event_cost,category_name,event_organizer_id) VALUES ('{$venue_name}','{$event_name}','{$event_overview}','{$event_hashtags}','{$event_location}','{$event_area}','{$event_cost}','{$category_name}','{$this->event_organiser_id}')";
           $eventDetailInserted = $db->query($query);
           $result = array();
           if($eventDetailInserted)
           {
               $event_detail_id = $db->insert_id;
               $this->addHashToDatabase($hash1, $hash2, $hash3);
                   $eventScheduleInserted = $this->addEventScheduleToDatabase($event_detail_id, $repeatType, $repeatEvent,$no_of_months, $no_of_weeks, $data->datetime);
                   if($eventScheduleInserted)
                   {

                       $result['status'] = 'success';
                       $result['organiser_id'] = $this->event_organiser_id;
                       $result['event_detail_id'] = $event_detail_id;
                       $result['message'] = 'Event details added successfully';
                       return $result;
                   }
                   else
                   {
                       $result['status'] = 'failure';
                       $result['message'] = 'Error in running the second query, during inserting data in the schedule table '.$db->error;
                       return $result;
                   }
           }
           else
           {
               $result['status'] = 'failure';
               $result['message'] = 'Error in running the first query to insert data in details table '.$db->error;
               return $result;
           }
       }
       else{
           $result['status'] = 'failure';
           $result['message'] = 'Some fields are empty';
           return $result;
       }

   }

    /**
     * @param $data
     * @return array
     * This function takes as input the form details as $data array and cleans the
     * data using real_escape_String for use in the datbase .
     * It then fires the UPDATE query to update the event_Details.
     * If event details are updated then it fire UPDATE query to update hashtags
     * which is optional. After that an UPDATE query is fired to update event schedule
     * which is also optional. If everything executes then success status is returned with
     * the result array and also a success messae is sent. ELSE failure status with failure
     * message is returned
     *
     */
    public function updateEventDetails($data)
    {
        $db = $this->getDatabaseObject();
        // $event_schedule_id = $db->real_escape_string($data['event_schedule_id']);
        $event_detail_id = (isset($data->event_detail_id) && $data->event_detail_id!=null )?$db->real_escape_string($data->event_detail_id):'';
        $venue_name = (isset($data->venue_name) && $data->venue_name!=null )?$db->real_escape_string($data->venue_name):'';
        $event_name = (isset($data->event_name) && $data->event_name!=null )?$db->real_escape_string($data->event_name):'';
        $event_overview =  (isset($data->event_overview) && $data->event_overview!=null )?$db->real_escape_string( $data->event_overview):'';
        $event_hashtags =  (isset($data->event_hashtags) && $data->event_hashtags!=null )?$db->real_escape_string($data->event_hashtags):'';
        $event_location =  (isset($data->event_location) && $data->event_location!=null )?$db->real_escape_string( $data->event_location):'';
        $event_area =  (isset($data->event_area) && $data->event_area!=null )?$db->real_escape_string( $data->event_area):'';
        $event_cost =  (isset($data->event_cost) && $data->event_cost!=null )?$db->real_escape_string( $data->event_cost):'';
        $category_name =  (isset($data->event_category) && $data->event_category!=null )?$db->real_escape_string( $data->event_category):'';
        $change_event_schedule_flag = (isset($data->change_event_schedule_flag) && $data->change_event_schedule_flag!=null )?$db->real_escape_string( $data->change_event_schedule_flag):'';

        $hash1 = (isset($data->hash1) && $data->hash1!=null )?$db->real_escape_string($data->hash1):'';
        $hash2 = (isset($data->hash2) && $data->hash2!=null )?$db->real_escape_string($data->hash2):'';
        $hash3 = (isset($data->hash3) && $data->hash3!=null )?$db->real_escape_string($data->hash3):'';
        $final_result = [];
     //   $event_organizer_id =  $db->real_escape_string($data->event_organizer_id);
        if($venue_name!='' && $event_name!='' && $event_overview!='' && $event_location!='' && $event_area!='' && $event_cost!='' && $category_name!=''){
            $query = "UPDATE event_detail set venue_name='{$venue_name}', event_name='{$event_name}', event_overview='{$event_overview}', event_hashtags='{$event_hashtags}', event_location='{$event_location}', event_area_id='{$event_area}', event_cost='{$event_cost}', category_name='{$category_name}' WHERE event_detail_id='{$event_detail_id}'";
            $eventDetailsInserted = $db->query($query);
            if($eventDetailsInserted)
            {
                $this->addHashToDatabase($hash1, $hash2, $hash3);
                if($change_event_schedule_flag)
                {
                    $repeatEvent = (isset($data->repeatEventCheckbox) && $data->repeatEventCheckbox!=null )?$db->real_escape_string( $data->repeatEventCheckbox):'';
                    $repeatType = (isset($data->repeatType) && $data->repeatType!=null )?$db->real_escape_string( $data->repeatType):'';
                    $no_of_weeks = (isset($data->no_of_weeks) && $data->no_of_weeks!=null )?$db->real_escape_string( $data->no_of_weeks):'';
                    $no_of_months = (isset($data->no_of_months) && $data->no_of_months!=null )?$db->real_escape_string( $data->no_of_months):'';
                    $datetime =  (isset($data->updated_date_time_array) && $data->updated_date_time_array!=null )?$data->updated_date_time_array:'';
                   // if($repeatEvent != '' && $repeatType != '' && ($no_of_weeks!='' || $no_of_months!='')){
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
//                    }
//                    else
//                    {
//                        $final_result['status'] = 'failure';
//                        $final_result['message'] = 'Some fields in schedule are empty';
//                        return $final_result;
//                    }
                }
                else{
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
        else{
            $result['status'] = 'failure';
            $result['message'] = 'Some fields are empty';
            return $result;
        }

    }

    /**
     * @param $event_detail_id
     * Takes event_Detail_id as input and deactivates the corresponding event
     * by setting the ACTIVE flag to inactive.
     * It then deletes the image URL's from the event_image table and also deletes
     * the images stored in the FILESYSTEM. The funtion returns success status if deletion
     * is done else returns failure .
     */
    public function deleteEvent($event_detail_id)
    {
        $db = $this->getDatabaseObject();
        $query = "update event_detail set is_active= 0 where event_detail_id='{$event_detail_id}'";
        $isDeleted = $db->query($query);
        if($isDeleted)
        {
            $result['status'] = 'success';
            $result['message'] = 'Events details deleted successfully';
            return $result;
        }
        else
        {
            $result['status'] = 'failure';
            $result['message'] = 'Events details were not deleted properly.';
            return $result;
        }


    }

     /**
     * This function takes organiser_id as input and based on this it fires a SELECT query to
     * fetch data of all the events belonging to the particular Organiser.
     * The date and time is stored as arrays in an outer array. Same is done for storing the
     * Image URL's.Thus the entire result is sent back as a multidimensional array.
     */

    public function getAllEvents($organiser_id)
    {
        $db = $this->getDatabaseObject();
        $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, ed.event_area_id, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.is_active = 1 and ed.event_organizer_id = '{$organiser_id}' group by ed.event_detail_id";
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
                $rows[$i]['event_organizer_id'] = $row['event_organizer_id'];
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
                else
                {
                    $result['status'] = 'failure';
                    $result['message'] = 'Event Schedule not fetched properly';
                    return $result;
                }
                if($row['image'])
                {
                    $temp_image_array = explode(',',$row['image']);
                    $y = array();
                    foreach ($temp_image_array as $x)
                    {
                        $y = explode('=',$x);
                        $z = array();
                        $z['image_path'] = $y[0];
                        $z['primary'] = $y[1];
                        $z['image_id'] = $y[2];
                        array_push($rows[$i]['image'] , $z);
                    }
                    $i++;
                }
                else
                {
                    $result['status'] = 'failure';
                    $result['message'] = 'Event Image URL\'s not fetched Properly';
                    return $result;
                }
            }

            $result['status'] = 'success';
            $result['message'] = 'Event Details successfully fetched';
            $result['data'] =$rows;
            return $result;
        }
        else {
            $result['status'] = "failure";
            $result['message'] = 'All the event details were not fetched properly. Please check database errors or database LOG file for more information';
            $result['data'] = '';
            return $result;

        }
    }
    /**
     * *******************************Utility Functions*******************************
     */

    /**
     * @param $destination
     * @param $event_detail_id
     * @param $primary_image
     * @return bool|mysqli_result
     * THis function takes as input destination for the image i.e. the file path in the
     * file system , the event_detail_ud and the primary image flag(1 or 0).
     * It then stores the image URL and other data in the event_image Table
     */
    public function addImageUrlToDatabase($destination, $event_detail_id, $primary_image)
    {
        $db = $this->getDatabaseObject();
        $query = "insert into event_image (event_detail_id, event_image_name, primary_image) VALUES ('{$event_detail_id}', '{$destination}','{$primary_image}')";
        $imageUrlInserted = $db->query($query);
        $result = array();
        if($imageUrlInserted)
        {
            $result['status'] = 'success';
            $result['message'] = 'image Url\'s were successfully inserted into the database';
            return $result;
        }
        else
        {
            $result['status'] = 'failure';
            $result['message'] = 'image Url\'s were Not properly inserted into the database '.$db->error;
            return $result;
        }
    }

    /**
     * @param $hash1
     * @param $hash2
     * @param $hash3
     * This function takes as input 3 or more hash strings and checks if the hash
     * is already present in the table. IF the hash string is already present, then
     * its count is incremented else it is inserted as a new hash string in the table.
     * It returns true is successful else false.
     */
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
            }
            else
            {
                $row = $temp->fetch_row();
                $row = intval($row[2]);
                $query = "update hashtag set hashtag_count = '{$row}' + 1  where hashtag_name = '{$hash}' ";

            }
            $hashtagInserted = $db->query($query);
            $result = array();
            if($hashtagInserted)
            {
                $result['status'] = 'success';
                $result['message'] = 'hashtags inserted/updated properly';
            }
            else
            {
                $result['status'] = 'failure';
                $result['message'] = 'hashtags NOT inserted/updated properly '.$db->error;
            }
        }
    }

    /**
     * @param $event_detail_id
     * @param $repeatType
     * @param $repeatEvent
     * @param $no_of_months
     * @param $no_of_weeks
     * @param $datetime
     * @return bool|mysqli_result
     * THis function inserts the event schedule in the datbase. It first checks if event needs to be
     * repeated or not. For repititive event it checks weekly or monthly type and inserts multiple rows
     * in the database. FOr non-repititive event only one set of rows are inserted.It returns true if
     * query is successful else returns false.
     */
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
                        $eventScheduleInserted = $db->query($query);
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
                        $eventScheduleInserted = $db->query($query);
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
                $eventScheduleInserted = $db->query($query);
            }

        }
        $result = array();
        if($eventScheduleInserted)
        {
            $result['status'] = 'success';
            $result['message'] = 'Event schedule inserted successfully';
            return $result;
        }
        else
        {
            $result['status'] = 'failure';
            $result['message'] = 'Event schedule NOT  inserted successfully '.$db->error;
            return $result;
        }

    }

    /**
     * This function returns an array of categories of events from
     * the database. If NO CATEGORY exists then it returns failure message
     * with empty result data.
     */
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
            $result['message'] = 'Categories fetched successfully';
            $result['data'] = $rows;
            return $result;
        }
        else
        {
            $result['status'] = "failure";
            $result['message'] = 'Categories NOT fetched successfully '.$db->error;
            $result['data'] = '';
            return $result;
        }
    }

    /**
     * This function returns an array of Areas of events from
     * the database. If NO Areas exists then it returns failure message
     * with empty result data.
     */
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
            $result['message'] = 'Areas fetched successfully';
            $result['data'] = $rows;
            return $result;
        }
        else
        {
            $result['status'] = "failure";
            $result['message'] = 'Areas NOT fetched successfully '.$db->error;
            $result['data'] = '';
            return $result;
        }
    }

    /**
     * @param $event_detail_id
     * @return bool|mysqli_result
     * This event takes as input the event detail id and deletes the event schedule from
     * the databse. It returns true is successful, else false .
     */
    public function deletePreviousEventSchedule($event_detail_id)
    {
        $db = $this->getDatabaseObject();
        $query = "delete from event_schedule WHERE event_detail_id='{$event_detail_id}'";
        $deleted = $db->query($query);
        $result = array();
        if($deleted)
        {
            $result['status'] = 'success';
            $result['message'] = 'Previous Event Schedule details successfully deleted';
            return $result;
        }
        else
        {
            $result['status'] = "failure";
            $result['message'] = 'Previous Event details not deleted successfully'.$db->error;
            return $result;
        }
    }

    /**
     * @param $destination
     * @param $event_detail_id
     * @param $primary_image
     * @return bool|mysqli_result
     * THis function takes as input destination for the image i.e. the file path in the
     * file system , the event_detail_ud and the primary image flag(1 or 0).
     * It then stores the image URL and other data in the event_image Table
     */
    public function addUpdatedImageUrlToDatabase($destination, $event_image_id)
    {
        $db = $this->getDatabaseObject();
        $query = "update event_image set event_image_name = '{$destination}' where event_image_id = '{$event_image_id}' ";
        $imageUrlInserted = $db->query($query);
        $result = array();
        if($imageUrlInserted)
        {
            $result['status'] = 'success';
            $result['message'] = 'image Url\'s were successfully updated into the database';
            return $result;
        }
        else
        {
            $result['status'] = 'failure';
            $result['message'] = 'image Url\'s were Not properly updated into the database '.$db->error;
            return $result;
        }
    }


}


