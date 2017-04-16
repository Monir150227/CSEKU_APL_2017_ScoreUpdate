<?php
include 'dbh.php';

$stricker=$_POST['element_1'];
$nonstricker=$_POST['element_2'];
// select match id from m_atch table
$matchid;
$tossid;
$sql="SELECT match_id FROM m_atch";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row=$result->fetch_assoc())
	{
      $matchid=$row["match_id"];
	}
}
else
{
	echo "result 0";
}

$sql="SELECT toss FROM m_atch";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row=$result->fetch_assoc())
	{
      $tossid=$row["toss"];
	}
}
else
{
	echo "result 0";
}

// select stricker batsman
$sql="INSERT INTO status (player_id,match_id,toss,out_type)
VALUES ($stricker,$matchid,$tossid,'Not out')";
 $result=$conn->query($sql);

// select non stricker batsman

$sql="INSERT INTO status (player_id,match_id,toss,out_type)
   VALUES ($nonstricker,$matchid,$tossid,'Not out')";
$result=$conn->query($sql);

// select team id from team table
$id;
$sql="SELECT team_id FROM team";
$result=$conn->query($sql);

if($result->num_rows>0)
{
	while ($row=$result->fetch_assoc()) 
	{
		$id=$row["team_id"];
	}
}
else
{
	echo "result 0";
}

$stid;
$sql="SELECT status_id FROM status";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row=$result->fetch_assoc())
	{
		$stdid=$row["status_id"];
	}
	$sql="UPDATE  status SET stricking_role=0 WHERE status_id=$stdid";
     $result=$conn->query($sql);
    $stdid=$stdid-1;
    $sql="UPDATE  status SET stricking_role=1 WHERE status_id=$stdid";
     $result=$conn->query($sql);
}


$team_1id=$id;
$team_2id=$id-1;

//select which team is on the bat

$sql="SELECT toss FROM m_atch";
$result=$conn->query($sql);

if($result->num_rows>0)
{
	while ($row=$result->fetch_assoc()) 
	{
		$id=$row["toss"];
	}
}
else
{
	echo "result 0";
}

// if team id not equal toss id this team is on the bat

if($team_1id!=$id)
{
	$name2="SELECT * FROM players WHERE tem_id=$team_1id";
    $result3=mysqli_query($conn,$name2);
}
else
{
	$name2="SELECT * FROM players WHERE tem_id=$team_2id";
   $result3=mysqli_query($conn,$name2);
}
  

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Bowler</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Bowler</a></h1>
		<form id="index3" class="appnitro"  method="post" action="update2.php">
					<div class="form_description">
			<h2>Bowler</h2>
			<p></p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Bowler </label>
		<div>
		<select class="element select medium" id="element_1" name="element_1" required="required"> 
	
<?php while($column=mysqli_fetch_array($result3)):; ?>
    <option value="<?php echo $column[0];?>"> <?php echo $column[1];?> </option>
<?php endwhile; ?>


		</select>
		</div> 
		</li>		<li class="buttons">
			    <input type="hidden" name="bowler"/>
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
		
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>