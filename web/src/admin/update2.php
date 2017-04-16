<?php
  
include 'dbh.php';
$strik_id=$_POST['element_1'];
$strik_role=2;

// select match id from m_atch table
$matchid;
$tossid;
$timid;

$sql="SELECT team_id FROM team";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row=$result->fetch_assoc())
	{
      $timid=$row["team_id"];
	}
}

$sql="SELECT match_id FROM m_atch";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row=$result->fetch_assoc())
	{
      $matchid=$row["match_id"];
	}
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

if($timid==$tossid)
{
	$tossid=$timid-1;
}
else
{
	$tossid=$timid;
}


    $sql="INSERT INTO status (player_id,match_id,toss)
   VALUES ($strik_id,$matchid,$tossid)";
mysqli_query($conn,$sql) or die(mysqli_error($conn));

$stdid;
$sql="SELECT status_id FROM status";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row=$result->fetch_assoc())
	{
		$stdid=$row["status_id"];
	}
	$sql="UPDATE  status SET stricking_role=2 WHERE status_id=$stdid";
     $result=$conn->query($sql);
}

header("Location:ballbyball.php");
        exit; 
?>
