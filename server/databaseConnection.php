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
        $this->servername = 'localhost';
        $this->username = 'root';
        $this->password = '';
        $this->dbname = 'shout';
    }

    function getConnection(){
        static $instance = null;
        if (null === $instance) {

        }
        $instance = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $instance;
    }
}
