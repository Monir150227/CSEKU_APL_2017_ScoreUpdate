<?php
include 'dbh.php';
$toss;
$team_Aid;
$team_Bid;
$result1;
$result2;



// select which team bat first
$sql="SELECT team_id FROM team";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	$bat;
	while($row=$result->fetch_assoc())
	{
       $bat=$row["team_id"];
	}

	$team_Aid=$bat-1;
	$team_Bid=$bat;
}

$sql="SELECT toss FROM m_atch";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row=$result->fetch_assoc())
	{
       $toss=$row["toss"];
	}
}

else
{
	echo "result 0";
}
if($toss==$team_Aid)
{
	$sql="UPDATE m_atch SET toss=$team_Bid";
	$result=$conn->query($sql);
}
else if($toss==$team_Bid)
{
	$sql="UPDATE m_atch SET toss=$team_Aid";
	$result=$conn->query($sql);
}

$sql="SELECT toss FROM m_atch";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row=$result->fetch_assoc())
	{
       $toss=$row["toss"];
	}
}

	

         $name="SELECT * FROM players WHERE tem_id=$toss";
         $result1=mysqli_query($conn,$name);
         $result2=mysqli_query($conn,$name);

//select batsman from player table table players
  

?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Opening Batsman </title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Opening Batsman</a></h1>
		<form id="index3" class="appnitro"  method="post" action="bowler.php">
					<div class="form_description">
			<h2>2nd Innings Opening Batsman</h2>
			<p></p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Striker </label>
		<div>
		<select class="element select medium" id="element_1" name="element_1"> 
	
<?php while($column=mysqli_fetch_array($result1)):; ?>
    <option value="<?php echo $column[0];?>"> <?php echo $column[1];?> </option>
<?php endwhile; ?>


		</select>
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Non Striker </label>
		<div>
		<select class="element select medium" id="element_2" name="element_2"> 

			<?php while($column=mysqli_fetch_array($result2)):; ?>
    <option value="<?php echo $column[0];?>"> <?php echo $column[1];?> </option>
    <?php endwhile; ?>

		</select>

		</div> 
		</li>		<li class="buttons">
			    <input type="hidden" name='batsmen' />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
		
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>