<?php
include 'dbh.php';
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

    //select team id

   /* $sql="SELECT team_id FROM team";
    $result=$conn->query($sql);
    if($result->num_rows>0)
    {
        while($rows=$result->fetch_assoc())
        {
            $temid=$rows["team_id"];
        }
    }

    if($temid!=$tossid)
    {
        $temid=$tossid;
    }*/

    //select bowler from table players
   $name2="SELECT * FROM players WHERE tem_id=$tossid";
   $result1=$conn->query($name2);


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>New Batsman</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>New Batsman</a></h1>
		<form id="form_23896" class="appnitro"  method="post" action="ball+bat.php">
					<div class="form_description">
			<h2>New Batsman</h2>
			<p>This is your form description. Click here to edit.</p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Select Batsman </label>
		<div>
		<select class="element select medium" id="element_1" name="element_1"> 
			<?php while($column=mysqli_fetch_array($result1)):; ?>
    <option value="<?php echo $column[0];?>"> <?php echo $column[1];?> </option>
<?php endwhile; ?>
		</select>
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Striking Role </label>
		<div>
		<select class="element select medium" id="element_2" name="element_2" required="required"> 
			<option value="" selected="selected"></option>
<option value="1" >Striker</option>
<option value="0" >Non Striker</option>

		</select>
		</div> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="23896" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>