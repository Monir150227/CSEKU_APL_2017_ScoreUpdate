<?php
include 'dbh.php';

$temid;
$tossid;

 $sql="SELECT toss FROM m_atch";
    $result=$conn->query($sql);
    if($result->num_rows>0)
    {
        while($rows=$result->fetch_assoc())
        {
            $tossid=$rows["toss"];
        }
    }

    //select team id

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
		<select class="element select medium" id="element_1" name="element_1"> 
	
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