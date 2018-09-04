<?PHP

// This function is used to encrypt data.
// The key is below
// Try to keep it a bit long
// Use something like http://textmechanic.com/text-tools/randomization-tools/random-string-generator/
// to generate good strings
// And make sure they are valid strings!!

global $key;
$key = "CMrVbBe,t)xZJBqfuX{EHRE_FK!3N6X,rzsDKW)GA<Um^U)`[A~Nt]_zQQ+YB>Pxj-afvZ,v,y[jCE+gN<A~`+3eE3m)0[";
//echo "Key is $key<br><br><br>";


// This is salt included to prevent short string known plaintext attacks on the function, should it come to that. Keep it shorter than key, maybe 25 bytes. Remember the length of salt since it is necessary for decrypt garbage removal
global $salt;
$salt = "eCM2fqKXRp8I0wMoTxa3RkzU5";

function encrypt67JL9RBDBv($str, $time){
	//echo "Received string is ".$str.", and received time is ".$time.".<br>";
	global $salt;
	$salt = str_shuffle($salt);
	$str = $salt.$time.$str;
	global $key;
	//echo "$key is the key<br>";
	$result = "";
	for($i=0; $i<strlen($str); $i++) {
		$char = substr($str, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)+ord($keychar));
		$result.=$char;
	}
	return urlencode(base64_encode($result));
}


function decryptYRVCeMzkni($str){
	//echo "Received string is ".$str.".<br>";
	global $key;
	$str = base64_decode(urldecode($str));
	$result = '';
	for($i=0; $i<strlen($str); $i++) {
		$char = substr($str, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	$result = substr($result, 25);
	//echo "Result is ".$result.".<br>";
	return $result;
}
 
?>