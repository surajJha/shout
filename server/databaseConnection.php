<?php
/**
 * Created by PhpStorm.
 * User: rishabh
 * Date: 07-01-2015
 * Time: 10:59
 */
class DatabaseConnection{
    protected $servername;
    protected $username;
    protected $password;
    protected $dbname ;

    function __construct(){
       // return new mysqli($this->servername, $this->username, $this->password, $this->dbname);
//        $this->servername = 'localhost';
//        $this->username = 'root';
//        $this->password = 'root';
//        $this->dbname = 'shout';

        $this->servername = '43.225.55.205';
        $this->username = 'rollik3i_shout';
        $this->password = 'shaktiman';
        $this->dbname = 'rollik3i_roll';
    }

    function getConnection(){
        static $instance = null;
        if (null === $instance) {

        }
        $instance = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $instance;
    }
}
