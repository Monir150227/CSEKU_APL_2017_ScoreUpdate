<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Team Details</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<!--<script type="text/javascript" src="view.js"></script>-->
<script>
function validateForm() {
    var x = document.forms["index"]["team_name1"].value;
    if (x == "") {
        alert("Team A Name must be filled out");
        return false;
    }
}
</script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Team Details</a></h1>
		<form id="index" class="appnitro"  method="post" action="team_a" onsubmit="return validateForm()">
					<div class="form_description">
			<h2>Team Details</h2>
			<p>Please enter proper info below:</p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="team_name1">Team A Name </label>
		<div>
			<input id="team_name1" name="team_name1" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="coach_name1">Team A Coach Name </label>
		<div>
			<input id="coach_name1" name="coach_name1" class="element text medium" type="text" maxlength="255" value="" required /> 
		</div> 
		</li>		<li id="li_3" >
		<label class="description" for="manager_name1">Team A Manager Name </label>
		<div>
			<input id="manager_name1" name="manager_name1" class="element text medium" type="text" maxlength="255" value="" required /> 
		</div> 
		</li>		<li id="li_4" >
		<label class="description" for="team_name2">Team B Name </label>
		<div>
			<input id="team_name2" name="team_name2" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_5" >
		<label class="description" for="coach_name2">Team B Coach Name </label>
		<div>
			<input id="coach_name2" name="coach_name2" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>		<li id="li_6" >
		<label class="description" for="manager_name2">Team B Manager Name </label>
		<div>
			<input id="manager_name2" name="manager_name2" class="element text medium" type="text" maxlength="255" value="" required/> 
		</div> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="index" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
	</div>
	<img id="bottom" src="bottom.png">
	</body>
</html>