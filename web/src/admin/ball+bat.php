<?php
include 'dbh.php';

$strik_id=$_POST['element_1'];
$strik_role=$_POST['element_2'];
$tossid;
$matchid;
$temid;
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

 if ($strik_role==0){
	$sql="UPDATE status Set stricking_role=1 WHERE stricking_role=0";
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

  $sql="SELECT team_id FROM team";
    $result=$conn->query($sql);
    if($result->num_rows>0)
    {
        while($rows=$result->fetch_assoc())
        {
            $temid=$rows["team_id"];
        }
    }

    if($temid==$tossid)
    {
        $temid=$tossid-1;
    }



//select bowler from table players
   $name2="SELECT * FROM players WHERE tem_id=$temid";
   $result3=mysqli_query($conn,$name2);


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