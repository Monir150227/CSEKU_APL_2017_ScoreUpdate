<?php

include 'dbh.php';
$id;
//select team b id from team table
$sql="SELECT team_id FROM team";
$result=$conn->query($sql);

if($result->num_rows>0)
{
	while($row=$result->fetch_assoc())
	{
		$id=$row["team_id"];
	}
}
else
{
	echo "result 0";
}

//insert team b player name into player table
$name=$_POST["p_name1"];
$sql="INSERT INTO players(player_name,tem_id)
VALUES('$name',$id)";
$result=$conn->query($sql);

$name=$_POST["p_name2"];
$sql="INSERT INTO players(player_name,tem_id)
VALUES('$name',$id)";
$result=$conn->query($sql);

$name=$_POST["p_name3"];
$sql="INSERT INTO players(player_name,tem_id)
VALUES('$name',$id)";
$result=$conn->query($sql);

$name=$_POST["p_name4"];
$sql="INSERT INTO players(player_name,tem_id)
VALUES('$name',$id)";
$result=$conn->query($sql);

$name=$_POST["p_name5"];
$sql="INSERT INTO players(player_name,tem_id)
VALUES('$name',$id)";
$result=$conn->query($sql);

$name=$_POST["p_name6"];
$sql="INSERT INTO players(player_name,tem_id)
VALUES('$name',$id)";
$result=$conn->query($sql);

$name=$_POST["p_name7"];
$sql="INSERT INTO players(player_name,tem_id)
VALUES('$name',$id)";
$result=$conn->query($sql);

$name=$_POST["p_name8"];
$sql="INSERT INTO players(player_name,tem_id)
VALUES('$name',$id)";
$result=$conn->query($sql);

$name=$_POST["p_name9"];
$sql="INSERT INTO players(player_name,tem_id)
VALUES('$name',$id)";
$result=$conn->query($sql);

$name=$_POST["p_name10"];
$sql="INSERT INTO players(player_name,tem_id)
VALUES('$name',$id)";
$result=$conn->query($sql);

$name=$_POST["p_name11"];

$sql="INSERT INTO players(player_name,tem_id)
VALUES('$name',$id)";
$result=$conn->query($sql);

$name=$_POST["p_name12"];
$sql="INSERT INTO players(player_name,tem_id)
VALUES('$name',$id)";
$result=$conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Toss Details</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>


</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Toss Details</a></h1>
		<form id="index2" class="appnitro"  method="post" action="batsmen.php">
					<div class="form_description">
			<h2>Toss Details</h2>
			<p>Please enter the proper info below:</p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Bat </label>
		<div>
		<select class="element select medium" id="element_1" name="element_1"> 
			<option value="" selected="selected"></option>
<option value="1" >Team A</option>
<option value="2" >Team B</option>

		</select>
		</div>
		</li>		<li id="li_2" >
		<label class="description" for="over">Overs</label>
		<div>
			<input id="over" name="over" class="element text medium" type="text" maxlength="255" value="" required /> 
		</div> 
		</li>		<li class="buttons">
			    <input type="hidden" name="index2"/>
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>