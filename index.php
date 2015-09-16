<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<center>
<h1><img src=header-logo.png></img><br>Community Tiers (Version 1372)</h1>
<div id=app>
	<div id=output>
		<h3>Number Of Votes: <span id=numov>0</span></h3>
		<h2>
		<?php
		if (isset($_COOKIE["tierappcookie6"])){
			echo "<div id=cantvote>you can't vote more than once a day, sorry</div>";
		}
		else {
			echo "<span class=button id=cont onclick=ShowInput()>Contribute!</span>";
		}
		?>
		</h2>
		<h3>Current Standings</h3>
		<div id=curs>

		</div>
		<h3>Current Tier List</h3>
		<div id=curt>

		</div>
		<h3 id=pych>Older Tiers</h3>
		<span class=pycchar onclick=OlderVersion("1341.jpg")>1341</span>
	</div>
	<div id=input>
		<h3 id=pych>Pick Your Main</h3>
		<div id=pyc>

		</div>
	<div id=input2>
		<h3>Rate Your Matchups</h3>
		<div id=rym>

		</div>
		<h2><span class=button id=sub onclick=Submit()>Submit!</span></h2>
		<script>
		function OlderVersion(version){
			window.location.href = version;
		}
		</script>
		<script src=functions.js>
		</script>
		<script src=indexscript.js>
		</script>
	</div>
	</div>
</div>
</body>
</html>