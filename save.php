<?php
/**
 * Travis Sanders			June 4, 2014
 * CS494 Final Assignment
 */
ini_set('display_errors', 'On');
include 'storedInfo.php';

session_start();
if ($_POST) {
	if (array_key_exists("userIn", $_REQUEST) && array_key_exists("arrayIn", $_REQUEST)) {

		$username = htmlspecialchars($_REQUEST["userIn"]);
		$array = $_REQUEST["arrayIn"];	

		$con = mysqli_connect("oniddb.cws.oregonstate.edu", "sandetra-db", $mypassword, "sandetra-db"); 
		if (mysqli_connect_errno()) {
		    echo "Failed to connect to MySQL: " . mysqli_connect_error();
		} else {
	    	$res = $con->query("SELECT username, array FROM members WHERE username='$username'");
	    	//There should only ever be 1 result.
    		if($res->num_rows == 1) {
    			//Insert the array into the database.
		        $result = mysqli_query($con, "UPDATE members SET array='$array' WHERE username='$username'");
		        $_SESSION['array'] = $array;		//save the array in session as well in case user refreshes.
		        echo "SUCCESS";
		    } else {
		    	echo "You should never see this error. DUMPING EVERYTHING:";
		    	echo $username;
		    	echo $array;
		    }
		    $res->free();
	    }
	} else {
	    echo "ERROR!: Username or array data missing from POST.";
	    //return false;
	}
} else {
	header("Location: index.php");	//return user to account.html if no post
}

?>