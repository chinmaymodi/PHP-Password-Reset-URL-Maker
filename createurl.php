<html>
<body>
<?php

//Connect to DB
include('dbconfig.php');

//include crypto functions file
include('functions.php');


if (!isset($_POST["nowyoumayobtaintheurl"])) {
	FormBegin:
	echo "Password reset utility for faculty, UHCL.
	<form action = 'createurl.php' method = 'POST'>
	<table>
		<tr>
			<td align='right'>UserID:</td>
			<td align='left'><input type='text' name='userid' /></td>
		</tr>
		<tr>
				<td align = 'right'></td>
				<td align = 'left'><input type='submit' name='nowyoumayobtaintheurl' value='Request Reset' /></td>
		</tr>
		</table>
	</form>";
}
else {
	$user = $_POST["userid"];
	
	//Verify that such a user actually exists
	$query = $mysqli->prepare('SELECT id FROM test.users WHERE id LIKE ?');
	if(!$query) {
		echo "1 This is the error:";
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	$query->bind_param('s', $user);
	$query->execute();
	$userExists = $query->fetch();
	$query->close();
	$mysqli = null;
	if (!$userExists) {
		echo "No such user found in database, please ensure the user name is correct.<br>";
		goto FormBegin;
		// No need to use die() and force page reload, we just recreate the form to enter username
		//die();
	}
	else {
		echo "$user is the username<br>";
		$timeval = time();
		echo "URL is created at time $timeval<br>";
		$encrypted = encrypt67JL9RBDBv($user, $timeval);
		$decrypted = decryptYRVCeMzkni($encrypted);
		//echo "Encrypted text is $encrypted<br>";
		$encurl = urlencode($encrypted);
		//echo "Encrypted text fit for url is $encurl<br>";
		//echo "Decrypted text is $decrypted<br>";
		
		$url = "resetpassword.php?reset=".$encurl;
		
		
		echo "<br><br>The URL to reset their password is: <a href=\"".$url."\"> ".$url."</a><br>";
		echo "<br><br>Please remind them that this link will only work for 24 hours, then it will expire.";
	}
}
?>
</body>
</html>