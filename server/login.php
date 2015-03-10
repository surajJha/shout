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
        $query = "select event_organizer_name, event_organizer_password from event_organizer where event_organizer_name = '{$data->username}' and event_organizer_password = '{$data->password}'";

        $temp = $db->query($query);
        if($temp->num_rows == 1)
        {
            echo "success";
        }
        else
        {
            echo "failure";
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
$a = new Login();