<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/3/15
 * Time: 10:41 AM
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once 'databaseConnection.php';

class Login {
    protected $func = '';
    public function __construct()
    {
        $func = $_GET['func'];
        $this->$func();

    }

    protected function getDatabaseObject()
    {
        $db = new DatabaseConnection();
        return $db->getConnection();
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"));
        $data->username = (isset($data->username) && $data->username!=null )?$this->custom_filter_input($data->username):'';
        $data->password = (isset($data->password) && $data->password!=null )?$this->custom_filter_input($data->password):'';

        $db = $this->getDatabaseObject();
        $query = "select event_organizer_id from event_organizer where event_organizer_name = '{$data->username}' and event_organizer_password = '{$data->password}'";

        $temp = $db->query($query);
        $result = array();
        if($temp->num_rows == 1)
        {
            session_start();
            $result['message'] = 'success';
            while ($row = $temp->fetch_assoc()) {
                $_SESSION['organiser_id'] = $row['event_organizer_id'];
                $result['data'] = $_SESSION['organiser_id'];
//                $_SESSION['organiser_id'] = $row['event_organizer_id'];
            }


            echo json_encode($result);
        }
        else
        {
            $result['message'] = 'failure';
            $result['data'] = '';
            echo json_encode($result);
        }

    }

    public function logout() {
        session_start();
        if(isset($_SESSION['organiser_id'])){
            unset($_SESSION['organiser_id']);
        }
        session_unset();
        session_destroy();
        session_write_close();
        $result = array();
        $result['message'] = 'success';
        echo json_encode($result);
    }

    function custom_filter_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
$a = new Login();