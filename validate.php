<?php
/**
 * Travis Sanders			June 2, 2014
 * CS494 Final Assignment
 */
ini_set('display_errors', 'On');
include 'storedInfo.php';
require("phpass-0.3/PasswordHash.php");

session_start();
if ($_POST) {
	if (array_key_exists("userIn", $_REQUEST) && array_key_exists("passwordIn", $_REQUEST)) {

		// Following code modified heavily from http://web.engr.oregonstate.edu/~debruynm/tutorial/
		$hasher = new PasswordHash(8, false);

		$un = htmlspecialchars($_REQUEST["userIn"]);
		$password = htmlspecialchars($_REQUEST["passwordIn"]);

		//revalidate username and password sizes.
		if (strlen($password) > 72) {
		    die("Password must be 72 characters or less");
		} else if (strlen($password) < 8) {
			die("You spoony bard! Password must be greater than 8 characters.");
		} else if (strlen($un) < 4) {
			die("Username must be at least 4 characters.");
		} else if (strlen($un) > 72) {
			die("That username is WAY too big.");
		}

	    $con = mysqli_connect("oniddb.cws.oregonstate.edu", "sandetra-db", $mypassword, "sandetra-db"); 
	    if (mysqli_connect_errno()) {
	        echo "Failed to connect to MySQL: " . mysqli_connect_error();
	    } else {
	    	//ADD VERIFICATION THAT USERNAME IS IN THE DB AND PASSWORD MATCHES.
	    	$res = $con->query("SELECT username, password, array FROM members WHERE username='$un'");
	    	if($res->num_rows > 0) {
	    		$res->data_seek(0);
	 				$row = $res->fetch_assoc();
	 				$stored_hash = $row['password'];
	 				$check = $hasher->CheckPassword($password, $stored_hash);
	 				if ($check) {
		        		$_SESSION['username'] = $row['username'];
		        		$_SESSION['array'] = $row['array'];
		        		echo("SUCCESS");
		        		//header("Location: home.php");
		        	} else echo("Incorrect password.");
	        } else {
	        	echo("Username does not exist.");
	        }
	    }
	}
} else {
	echo("FAIL");
}

?>