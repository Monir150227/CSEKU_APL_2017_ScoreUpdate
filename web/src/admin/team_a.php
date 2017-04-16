<?php

include 'dbh.php';
// store value from html box for 1st team
$team1=$_POST["team_name1"];
$manager1=$_POST["manager_name1"];
$coach1=$_POST["coach_name1"];

// store value from html box for 2nd team
$team2=$_POST["team_name2"];
$manager2=$_POST["manager_name2"];
$coach2=$_POST["coach_name2"];



//insert into team A
$sql="INSERT INTO team(team_name,manager_name,coach_name)
    VALUES('$team1','$manager1','$coach1')";
$result=$conn->query($sql);
//insert into team B
$sql="INSERT INTO team(team_name,manager_name,coach_name)
    VALUES('$team2','$manager2','$coach2')";
$result=$conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Team A Player Details</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Team A Player Details</a></h1>
		<form id="index1" class="appnitro"  method="post" action="team_b.php">
					<div class="form_description">
			<h2>Team A Player Details</h2>
			<p>Please enter the proper info below:</p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="p_name1">Player 1 Name </label>
		<div>
			<input id="p_name1" name="p_name1" class="element text medium" type="text" maxlength="255" value="" required /> 
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="p_name2">Player 2 Name </label>
		<div>
			<input id="p_name2" name="p_name2" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_3" >
		<label class="description" for="p_name3">Player 3 Name </label>
		<div>
			<input id="p_name3" name="p_name3" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_4" >
		<label class="description" for="p_name4">Player 4 Name </label>
		<div>
			<input id="p_name4" name="p_name4" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_5" >
		<label class="description" for="p_name5">Player 5 Name </label>
		<div>
			<input id="p_name5" name="p_name5" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_6" >
		<label class="description" for="p_name6">Player 6 Name </label>
		<div>
			<input id="p_name6" name="p_name6" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_7" >
		<label class="description" for="p_name7">Player 7 Name </label>
		<div>
			<input id="p_name7" name="p_name7" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_8" >
		<label class="description" for="p_name8">Player 8 Name </label>
		<div>
			<input id="p_name8" name="p_name8" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_9" >
		<label class="description" for="p_name9">Player 9 Name </label>
		<div>
			<input id="p_name9" name="p_name9" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_10" >
		<label class="description" for="p_name10">Player 10 Name </label>
		<div>
			<input id="p_name10" name="p_name10" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_11" >
		<label class="description" for="p_name11">Player 11 Name </label>
		<div>
			<input id="p_name11" name="p_name11" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_12" >
		<label class="description" for="p_name12">Substitute Player Name </label>
		<div>
			<input id="p_name12" name="p_name12" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="index1"/>
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>