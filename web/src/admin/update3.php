<?php
include 'dbh.php';

$strik_id=$_POST['element_1'];
$strik_role=$_POST['element_2'];
$tossid;
$matchid;
$bat1id;
$bat12id;
$sql="SELECT toss FROM m_atch";
    $result=$conn->query($sql);

    $tossid;
    if($result->num_rows>0)
    {
        while($rows=$result->fetch_assoc())
        {
            $tossid=$rows["toss"];
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

$sql="SELECT status_id FROM status WHERE stricking_role=1 AND match_id=$matchid AND toss=$tossid";
     $result=$conn->query($sql);
    if($result->num_rows>0)
     {
        while($row= $result->fetch_assoc())
        {
          $bat1id=$row["status_id"];
        }
    }

     $sql="SELECT status_id FROM status WHERE stricking_role=0 AND match_id=$matchid AND toss=$tossid";
     $result=$conn->query($sql);
    if($result->num_rows>0)
     {
        while($row= $result->fetch_assoc())
        {
          $bat12id=$row["status_id"];
        }
    }

 if ($strik_role==0){
	$sql="UPDATE status Set stricking_role=1 WHERE status_id=$bat12id";
        $result=$conn->query($sql);
    }
    else{
    $sql="UPDATE status Set stricking_role=0 WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    $sql="INSERT INTO status (player_id,match_id,toss,out_type)
   VALUES ($strik_id,$matchid,$tossid,'Not out')";
mysqli_query($conn,$sql) or die(mysqli_error($conn));

$stid;
$sql="SELECT status_id FROM status";
$result=$conn->query($sql);
if($result->num_rows>0)
{
    while($row=$result->fetch_assoc())
    {
        $stdid=$row["status_id"];
    }
    $sql="UPDATE  status SET stricking_role=$strik_role WHERE status_id=$stdid";
     $result=$conn->query($sql);
    
}


header("Location:ballbyball.php");
        exit; 


?>
