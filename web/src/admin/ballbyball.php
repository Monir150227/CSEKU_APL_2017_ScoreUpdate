<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Ball by ball update</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Ball by ball update</a></h1>
		<form id="ballbyball" class="appnitro"  method="post" action="update.php">
					<div class="form_description">
			<h2>Ball by ball update</h2>
			<p></p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Run </label>
		<div>
		<select class="element select medium" id="element_1" name="element_1"> 
			<option value="" selected="selected"></option>
<option value="0" >0</option>
<option value="1" >1</option>
<option value="2" >2</option>
<option value="3" >3</option>
<option value="4" >4</option>
<option value="5" >5</option>
<option value="6" >6</option>
<option value="7" >7</option>


		</select>
		</div> <p class="guidelines" id="guide_1"><small>Select</small></p>
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Type of run </label>
		<div>
		<select class="element select medium" id="element_2" name="element_2"> 
			<option value="" selected="selected"></option>
<option value="1" >Batted</option>
<option value="2" >Extra</option>
<option value="3" >Extra+Batted</option>
<option value="4" >Out</option>
<option value="5" >Out +Extra</option>


		</select>
		</div><p class="guidelines" id="guide_2"><small>Select</small></p> 
		</li>		<li id="li_3" >
		<label class="description" for="element_3">Select if the run is extra </label>
		<div>
		<select class="element select medium" id="element_3" name="element_3"> 
			<option value="" selected="selected"></option>
<option value="1" >Wide</option>
<option value="2" >Wide+bye</option>
<option value="3" >No Ball</option>
<option value="4" >No ball+Bye</option>
<option value="5" >bye/legbye</option>

		</select>
		</div><p class="guidelines" id="guide_3"><small>select</small></p> 
		</li>		<li id="li_4" >
		<label class="description" for="element_4">Select if the Batsmen is out </label>
		<div>
		<select class="element select medium" id="element_4" name="element_4"> 
			<option value="" selected="selected"></option>
<option value="1" >Bowled</option>
<option value="2" >Catch out</option>
<option value="3" >Run Out Striker</option>
<option value="4" >LBW</option>
<option value="5" >Stumped</option>
<option value="6" >Hit Wicket</option>
<option value="7" >Retired Hurt</option>
<option value="8" >Run Out NonStriker</option>

		</select>
		</div><p class="guidelines" id="guide_4"><small>select</small></p> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="ballbyball"  />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>