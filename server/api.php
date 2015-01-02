<?php
class Api {
	public function getDetails($name) {
		$con=mysqli_connect("localhost","root","root","mytest");
// Check connection
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }
	$query = "SELECT place FROM users where name='{$name}'";
	$result = $con->query($query);
	if (!$result) {
	  printf("Query failed: %s\n", $con->error);
	  exit;
	}
	$rows = array();
	while($row = $result->fetch_row()) {
	  $rows[]=$row;
	}
	$result->close();
	$con->close();
	return $rows[0][0];
	}



public function changeName($name) {
	  $con=mysqli_connect("localhost","root","root","mytest");
    // Check connection
    	if (mysqli_connect_errno())
    	  {
    	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
    	  }
    	  if($name){
    	  $query = "update users set place = '{$name}' where name='suraj'";
            	$result = $con->query($query);
            	if (!$result) {
            	  echo("Query failed: %s\n". $con->error);
            	  exit;
            	}
            	echo 'success';
    	  }
    	  else{
    	    echo 'failure';
    	  }


	}
}
