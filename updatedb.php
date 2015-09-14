<?php
include "functions.php";
setcookie("test_cookie", "test", time() + 3600, '/');
if(count($_COOKIE) > 0){
	if (isset($_COOKIE["tierappcookie6"])){
		echo "You can't vote more than once a day.";
	}
	else if (!isset($_COOKIE["tierappcookie6"])){
		UpdateMatchupTable($_GET["input"]);
		setcookie("tierappcookie6", "set", time()+86400, "/");
	}
}
else {
    echo "Cookies are disabled, please enable them for your vote to count.";
}
?>
<html><body><script>
	window.location.href = "index.php";
</script></body></html>