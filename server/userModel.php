<?php
/**
 * Created by PhpStorm.
 * User: neha
 * Date: 28/1/15
 * Time: 12:29 PM
 */
ini_set('display_errors', '1');
include_once 'databaseConnection.php';
class UserModel
{
    protected $event_organiser_id;

    public function __construct()
    {

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
     * This function takes category_name as input and based on this it fires a SELECT query to
     * fetch data of all the events under particular category.
     * The date and time is stored as arrays in an outer array.
     * Thus the entire result is sent back as a multidimensional array.
     */



    public function getEventsByCategory($category_name){
        $db = $this->getDatabaseObject();
        $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, ed.event_area, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  ei.event_image_name as image from event_detail ed, event_schedule es, event_image ei where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ei.primary_image = 1 and ed.is_active = 1 and ed.category_name = '{$category_name}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count";

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
                $rows[$i]['image'] = $row['image'];
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
            }

            $result['status'] = 'success';
            $result['message'] = 'Event Details successfully fetched';
            $result['data'] = $rows;
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
     * This function takes cuurent_date as input and based on this it fires a SELECT query to
     * fetch data of all the events under particular category.
     * The date and time is stored as arrays in an outer array.
     * Thus the entire result is sent back as a multidimensional array.
     */

    public function getTodaysEvents($current_date)
    {
        $db = $this->getDatabaseObject();
        $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, ed.event_area, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  ei.event_image_name as image from event_detail ed, event_schedule es, event_image ei where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ei.primary_image = 1 and ed.is_active = 1 and es.event_date = '{$current_date}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count";
        $temp = $db->query($query);
        $result = array();
        if ($temp->num_rows > 0) {
            $i = 0;
            while ($row = $temp->fetch_assoc()) {
                $rows[$i]['category_name'] = $row['category_name'];
                $rows[$i]['event_area'] = $row['event_area'];
                $rows[$i]['event_cost'] = $row['event_cost'];
                $rows[$i]['event_detail_id'] = $row['event_detail_id'];
                $rows[$i]['event_location'] = $row['event_location'];
                $rows[$i]['event_name'] = $row['event_name'];
                $rows[$i]['event_overview'] = $row['event_overview'];
                $rows[$i]['venue_name'] = $row['venue_name'];
                $rows[$i]['datetime'] = array();
                $rows[$i]['image'] = $row['image'];
                $rows[$i]['event_hashtags'] = explode(' ', $row['event_hashtags']);
                if ($row['schedule']) {
                    $temp_date_array = explode(',', $row['schedule']);
                    $y = array();
                    foreach ($temp_date_array as $x) {
                        $y = explode('=', $x);
                        $z = array();
                        $z['date'] = $y[0];
                        $z['start_time'] = $y[1];
                        $z['end_time'] = $y[2];
                        array_push($rows[$i]['datetime'], $z);
                    }
                } else {
                    $result['status'] = 'failure';
                    $result['message'] = 'Event Schedule not fetched properly';
                    return $result;
                }
            }

            $result['status'] = 'success';
            $result['message'] = 'Event Details successfully fetched';
            $result['data'] = $rows;
            return $result;
        } else {
            $result['status'] = "failure";
            $result['message'] = 'All the event details were not fetched properly. Please check database errors or database LOG file for more information';
            $result['data'] = '';
            return $result;

        }
    }

        /**
         * This function takes current_date (which is tomorrow's date) as input and based on this it fires a SELECT query to
         * fetch data of all the events under particular category.
         * The date and time is stored as arrays in an outer array.
         * Thus the entire result is sent back as a multidimensional array.
         */

        public function getTomorrowsEvents($current_date){
            $db = $this->getDatabaseObject();
            $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, ed.event_area, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  ei.event_image_name as image from event_detail ed, event_schedule es, event_image ei where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ei.primary_image = 1 and ed.is_active = 1 and es.event_date = '{$current_date}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count";
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
                    $rows[$i]['image'] = $row['image'];
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
                }

                $result['status'] = 'success';
                $result['message'] = 'Event Details successfully fetched';
                $result['data'] = $rows;
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
     * This function takes from_date and to_date as input and based on this it fires a SELECT query to
     * fetch data of all the events under particular category.
     * The date and time is stored as arrays in an outer array.
     * Thus the entire result is sent back as a multidimensional array.
     */

    public function getLatersEvents($from_date,$to_date){
        $db = $this->getDatabaseObject();
        $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, ed.event_area, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  ei.event_image_name as image from event_detail ed, event_schedule es, event_image ei where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ei.primary_image = 1 and ed.is_active = 1 and es.event_date between '{$from_date}' and '{$to_date}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count";
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
                $rows[$i]['image'] = $row['image'];
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
            }

            $result['status'] = 'success';
            $result['message'] = 'Event Details successfully fetched';
            $result['data'] = $rows;
            return $result;
        }
        else {
            $result['status'] = "failure";
            $result['message'] = 'All the event details were not fetched properly. Please check database errors or database LOG file for more information';
            $result['data'] = '';
            return $result;

        }

    }



}
