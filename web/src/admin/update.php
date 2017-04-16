<?php
include 'dbh.php';
//update score player ball by ball

//check runs null or not
if ($_POST['element_1'] === '') 
{
     $runs= null; // or 'NULL' for SQL
}
else
{
   $runs=$_POST['element_1'];  
}

// check runtype null or not
if ($_POST['element_2'] === '') 
{
     $typerun= null; // or 'NULL' for SQL
}
else
{
   $typerun=$_POST['element_2'];  
}

// check extra runtype null or not
if ($_POST['element_3'] === '') 
{
     $extra_runtype= null; // or 'NULL' for SQL
}
else
{
   $extra_runtype=$_POST['element_3'];  
}

// check out type null or not
if ($_POST['element_4'] === '') 
{
     $outtype= null; // or 'NULL' for SQL
}
else
{
  $outtype=$_POST['element_4'];  
}

//echo "$extra_runtype";
$id1;
$id2;
$tossid;
$temid;
$flag=0;
$inningsball;
$totalball;
$bwlarball;
$p1id;
$p2id;
$matchid;

$bat1id;
$bat2id;
$ballid;


 //select toss id from m_atch table
    $sql="SELECT toss FROM m_atch";
    $result=$conn->query($sql);
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
        while($row= $result->fetch_assoc())
        {
          $matchid=$row["match_id"];
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
          $bat2id=$row["status_id"];
        }
    }
    $sql="SELECT status_id FROM status WHERE stricking_role=2 AND match_id=$matchid AND toss=$temid";
     $result=$conn->query($sql);
    if($result->num_rows>0)
     {
        while($row= $result->fetch_assoc())
        {
          $ballid=$row["status_id"];
        }
    }
//update type of run ball by ball batting run
//if batted
if($typerun==1 && $runs!=null && $extra_runtype==null && $outtype==null)
{
    // update ball played by batsman
    $addball ="SELECT played_ball FROM status WHERE status_id=$bat1id AND match_id=$matchid";
    $result=$conn->query($addball) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $batsball=1+$row["played_ball"];
        $sql="UPDATE  status  SET played_ball=$batsball WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }

    // update ball  bowler

    $addball ="SELECT bowled_overs FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addball) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $bwlrball=1+$row["bowled_overs"];
        $sql="UPDATE  status  SET bowled_overs=$bwlrball WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }
     // update batted run

    $addrun="SELECT bat_run FROM status WHERE status_id=$bat1id AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $run=$runs+$row["bat_run"];
        $sql="UPDATE  status  SET bat_run=$run WHERE status_id=$bat1id";
        $result=$conn->query($sql);

    }


    $addblrruns ="SELECT bowlruns FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addblrruns) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $blruns=$runs+$row["bowlruns"];
        $sql="UPDATE  status  SET bowlruns=$blruns WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }
     
     //count number of four hitted by batsmen
    if($runs==4)
    {
        $addfour ="SELECT hitted_fours FROM status WHERE status_id=$bat1id AND match_id=$matchid";
        $result=$conn->query($addfour) or die(mysqli_error($conn));
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $four=1+$row["hitted_fours"];
            $sql="UPDATE  status  SET hitted_fours=$four WHERE status_id=$bat1id";
            $result=$conn->query($sql);
        }
    }
    // count number of 6 hitted by batsmen
    if($runs==6)
    {
        $addsix ="SELECT hitted_sixes FROM status WHERE status_id=$bat1id AND match_id=$matchid";
        $result=$conn->query($addsix) or die(mysqli_error($conn));
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $six=1+$row["hitted_sixes"];
            $sql="UPDATE  status  SET hitted_sixes=$six WHERE status_id=$bat1id";
            $result=$conn->query($sql);
        }
    }

   
     //change batting position if batted run is odd
     if($runs%2==1)

      {

            $sql="UPDATE status SET stricking_role=0 WHERE status_id=$bat1id";
            $result=$conn->query($sql);
            $sql="UPDATE status SET stricking_role=1 WHERE status_id=$bat2id";
            $result=$conn->query($sql);
      }
   
}

// if run is wide && wide bye
else if($typerun==2 && $extra_runtype==1 && $runs!=null && $outtype==null|| $typerun==2 && $extra_runtype==2 && $runs!=null && $outtype==null)
{

   //count exta run bowler
    $addrun="SELECT extra FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["extra"];
        $sql="UPDATE  status  SET extra=$run WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }

    //update bowler run
    $addrun="SELECT bowlruns FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["bowlruns"];
        $sql="UPDATE  status  SET bowlruns=$run WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }
    

     //changing batting position
       if($runs%2==0)
            {
                

                $sql="UPDATE status SET stricking_role=0 WHERE status_id=$bat1id";
                $result=$conn->query($sql);

                $sql="UPDATE status SET stricking_role=1 WHERE status_id=$bat2id";
                $result=$conn->query($sql);
            }     

}

//check extra no && no + bye
else if($typerun==2 && $extra_runtype==3 && $runs!=null && $outtype==null|| $typerun==2 && $extra_runtype==4 && $runs!=null && $outtype==null)
{
     // update ball played by batsman
    $addball ="SELECT played_ball FROM status WHERE status_id=$bat1id AND match_id=$matchid";
    $result=$conn->query($addball) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $batsall=1+$row["played_ball"];
        $sql="UPDATE  status  SET played_ball=$batsall WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }


     //count exta run bowler
    $addrun="SELECT extra FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["extra"];
        $sql="UPDATE  status  SET extra=$run WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }

    //update bowler run
    $addrun="SELECT bowlruns FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["bowlruns"];
        $sql="UPDATE  status  SET bowlruns=$run WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }
    
   


    //changing batting position
       if($runs%2==0)
            {
                

                $sql="UPDATE status SET stricking_role=0 WHERE status_id=$bat1id";
                $result=$conn->query($sql);

                $sql="UPDATE status SET stricking_role=1 WHERE status_id=$bat2id";
                $result=$conn->query($sql);
            }

}

// check bye run

else if( $typerun==2 && $extra_runtype==5 && $runs!=null)
{



    //update bowler run
    $addrun="SELECT bowlruns FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["bowlruns"];
        $sql="UPDATE  status  SET bowlruns=$run WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }
     // update ball played by batsman
    $addball ="SELECT played_ball FROM status WHERE status_id=$bat1id AND match_id=$matchid";
    $result=$conn->query($addball) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $batsball=1+$row["played_ball"];
        $sql="UPDATE  status  SET played_ball=$batsball WHERE status_id=$bat1id ";
        $result=$conn->query($sql);
    }

    // update ball  bowler

    $addball ="SELECT bowled_overs FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addball) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $bwlrball=1+$row["bowled_overs"];
        $sql="UPDATE  status  SET bowled_overs=$bwlrball WHERE status_id=$ballid ";
        $result=$conn->query($sql);
    }

    //count exta run bowler
    $addrun="SELECT extra FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["extra"];
        $sql="UPDATE  status  SET extra=$run WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }


     //change batting position if batted run is odd
     if($runs%2==1)

      {
           

            $sql="UPDATE status SET stricking_role=0 WHERE status_id=$bat1id";
            $result=$conn->query($sql);
            $sql="UPDATE status SET stricking_role=1 WHERE status_id=$bat2id";
            $result=$conn->query($sql);
      }

}

// check run extra && batted
else if($typerun==3 && $extra_runtype==3 && $runs!=null && $outtype==null)
{
    // count played ball by batsmen
    $addball ="SELECT played_ball FROM status WHERE status_id=$bat1id AND match_id=$matchid";
    $result=$conn->query($addball) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $tball=1+$row["played_ball"];
        $sql="UPDATE  status  SET played_ball=$tball WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    //count exta run bowler
    $addrun="SELECT extra FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["extra"];
        $sql="UPDATE  status  SET extra=$run WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }

    //update bowler run
    $addrun="SELECT bowlruns FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["bowlruns"];
        $sql="UPDATE  status  SET bowlruns=$run WHERE status_id=$ballid ";
        $result=$conn->query($sql);
    }

    
    //update batsman run
    $addrun="SELECT bat_run FROM status WHERE status_id=$bat1id AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        // output data of each row
        $row = $result->fetch_assoc();
        $run=$runs+$row["bat_run"]-1;

        $sql="UPDATE  status  SET bat_run=$run WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }

     //if no ball && 4
    if($runs==5)
    {
        $addfour ="SELECT hitted_fours FROM status WHERE status_id=$bat1id AND match_id=$matchid";
        $result=$conn->query($addfour) or die(mysqli_error($conn));
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $four=1+$row["hitted_fours"];
            $sql="UPDATE  status  SET hitted_fours=$four WHERE status_id=$bat1id ";
            $result=$conn->query($sql);
        }
    }
    //if no ball && 6
    if($runs==7)
    {
        $addsix ="SELECT hitted_sixes FROM status WHERE status_id=$bat1id AND match_id=$matchid";
        $result=$conn->query($addsix) or die(mysqli_error($conn));
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $six=1+$row["hitted_sixes"];
            $sql="UPDATE  status  SET hitted_sixes=$six WHERE status_id=$bat1id";
            $result=$conn->query($sql);
        }
    }

     //changing batting position
       if($runs%2==0)
            {
              

                $sql="UPDATE status SET stricking_role=0 WHERE status_id=$bat1id";
                $result=$conn->query($sql);

                $sql="UPDATE status SET stricking_role=1 WHERE status_id=$bat2id";
                $result=$conn->query($sql);
            }

}
// check if out
else if($typerun==4 && $outtype!=null && $runs==null && $extra_runtype==null)
{
    $blrball;
    $blruns;
    $tossid;
    $temid;
    $totalball;
    $allwicket;
    $ingsball;
    $flag=1;



    //add ball played by batsman
    $addball ="SELECT played_ball FROM status WHERE status_id=$bat1id AND match_id=$matchid";
    $result=$conn->query($addball) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $tball=1+$row["played_ball"];
        $sql="UPDATE  status  SET played_ball=$tball WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }

    // add bowler ball
    $addovers ="SELECT bowled_overs FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addovers) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $blrball=1+$row["bowled_overs"];
        $sql="UPDATE  status  SET bowled_overs=$blrball WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }

  /*  $addrun="SELECT bat_run FROM status WHERE status_id=$bat1id AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $run=$runs+$row["bat_run"];
        $sql="UPDATE  status  SET bat_run=$run WHERE status_id=$bat1id";
        $result=$conn->query($sql);

    }*/


   /* $addblrruns ="SELECT bowlruns FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addblrruns) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $blruns=$runs+$row["bowlruns"];
        $sql="UPDATE  status  SET bowlruns=$blruns WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }*/
    

      // select which type of out
    if($outtype==1)
    {
        $sql="UPDATE status SET out_type='Bowled' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    else if($outtype==2)
    {
        $sql="UPDATE status SET out_type='Caught' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    else if($outtype==3)
    {
        $sql="UPDATE status SET out_type='Run out' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    else if($outtype==4)
    {
        $sql="UPDATE status SET out_type='LBW' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    else if($outtype==5)
    {
        $sql="UPDATE status SET out_type='Stumped' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    else if($outtype==6)
    {
        $sql="UPDATE status SET out_type='Hit-Wicket' WHERE status_id=$bat1id ";
        $result=$conn->query($sql);
    }
     else if($outtype==7)
    {
        $sql="UPDATE status SET out_type='Retired-hurt' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    else
    {
        $sql="UPDATE status SET out_type='Run out' WHERE status_id=$bat2id";
        $result=$conn->query($sql);

    }

     // update extra wicket if runout
    if($outtype==3||$outtype==8 || $outtype==7)
    {
         $addwicket ="SELECT extra_wicket FROM status WHERE status_id=$ballid  AND match_id=$matchid";
          $result=$conn->query($addwicket) or die(mysqli_error($conn));
         if ($result->num_rows > 0)
        {
            $wiket=0;
            $row = $result->fetch_assoc();
           $wiket=1+$row["extra_wicket"];
           $sql="UPDATE  status  SET extra_wicket=$wiket  WHERE status_id=$ballid";
           $result=$conn->query($sql);
        }
    }

   // update bowler wicket
    else
    {
       $addwicket ="SELECT wicket FROM status WHERE status_id=$ballid AND match_id=$matchid";
       $result=$conn->query($addwicket) or die(mysqli_error($conn));
      if ($result->num_rows > 0)
       {
         $row = $result->fetch_assoc();
         $wiket=1+$row["wicket"];
         $sql="UPDATE  status  SET wicket=$wiket WHERE status_id=$ballid";
         $result=$conn->query($sql);
       
       } 
    }
    
    // make null which batsman is out
       if($outtype==8)
        {
           $sql="UPDATE status SET stricking_role=NULL WHERE status_id=$bat2id";
           $result=$conn->query($sql); 
        }
        else
        {
            $sql="UPDATE status SET stricking_role=NULL WHERE status_id=$bat1id";
            $result=$conn->query($sql);
        }   

}



// check if wide, wide + by && wicket
else if($typerun==5 && $extra_runtype==1 && $runs!=null && $outtype!=null|| $typerun==5 && $extra_runtype==2 && $runs!=null && $outtype!=null)
{
    $flag=1;

   // update bowler extra run
    $addrun="SELECT extra FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["extra"];
        $sql="UPDATE  status  SET extra=$run WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }

    //update bowler run
    $addrun="SELECT bowlruns FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["bowlruns"];
        $sql="UPDATE  status  SET bowlruns=$run WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }

    
   if($outtype==3)
    {
        $sql="UPDATE status SET out_type='Run out' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    else if($outtype==5)
    {
        $sql="UPDATE status SET out_type='Stumped' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    else if($outtype==6)
    {
        $sql="UPDATE status SET out_type='Hit-Wicket' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
     else if($outtype==7)
    {
        $sql="UPDATE status SET out_type='Retired-hurt' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    
    else 
    {
        $sql="UPDATE status SET out_type='Run out' WHERE status_id=$bat2id";
        $result=$conn->query($sql);

    }

    
    // if wicket is stumped add to bowler

    if($outtype==5)
    {
       $addwicket ="SELECT wicket FROM status WHERE status_id=$ballid AND match_id=$matchid";
       $result=$conn->query($addwicket) or die(mysqli_error($conn));
      if ($result->num_rows > 0)
       {
         $row = $result->fetch_assoc();
         $wiket=1+$row["wicket"];
         $sql="UPDATE  status  SET wicket=$wiket WHERE status_id=$ballid";
         $result=$conn->query($sql);
       
       } 
    }
    else
    {
         $addwicket ="SELECT extra_wicket FROM status WHERE status_id=$ballid AND match_id=$matchid";
          $result=$conn->query($addwicket) or die(mysqli_error($conn));
         if ($result->num_rows > 0)
         {
            $wiket;
           while($row = $result->fetch_assoc())
           {

              $wiket=$row["extra_wicket"];
           }
           $wiket++;
           $sql="UPDATE  status  SET extra_wicket=$wiket  WHERE status_id=$ballid";
           $result=$conn->query($sql);
       
         }
    }

    // make null which batsman is out
    if($outtype==8)
        {
           $sql="UPDATE status SET stricking_role=NULL WHERE status_id=$bat2id";
           $result=$conn->query($sql); 
        }
        else
        {
            $sql="UPDATE status SET stricking_role=NULL WHERE status_id=$bat1id";
            $result=$conn->query($sql);
        }
}

// check if no, no + by && wicket
else if($typerun==5 && $extra_runtype==3 && $runs!=null && $outtype!=null||$typerun==5 && $extra_runtype==4 && $runs!=null && $outtype!=null)
{
    $flag=1;

   // update bowler extra run
    $addrun="SELECT extra FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["extra"];
        $sql="UPDATE  status  SET extra=$run WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }

     // update ball played by batsman
    $addball ="SELECT played_ball FROM status WHERE status_id=$bat1id AND match_id=$matchid";
    $result=$conn->query($addball) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $tball=1+$row["played_ball"];
        $sql="UPDATE  status  SET played_ball=$tball WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }

    //update bowler run
    $addrun="SELECT bowlruns FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["bowlruns"];
        $sql="UPDATE  status  SET bowlruns=$run WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }

    
   if($outtype==3)
    {
        $sql="UPDATE status SET out_type='Run out' WHERE status_id=$bat1id ";
        $result=$conn->query($sql);
    }
    else if($outtype==5)
    {
        $sql="UPDATE status SET out_type='Stumped' WHERE status_id=$bat1id ";
        $result=$conn->query($sql);
    }
    else if($outtype==6)
    {
        $sql="UPDATE status SET out_type='Hit-Wicket' WHERE status_id=$bat1id ";
        $result=$conn->query($sql);
    }
     else if($outtype==7)
    {
        $sql="UPDATE status SET out_type='Retired-hurt' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    
    else 
    {
        $sql="UPDATE status SET out_type='Run out' WHERE status_id=$bat2id";
        $result=$conn->query($sql);

    }

    
    // if wicket is stumped add to bowler

    if($outtype==5)
    {
       $addwicket ="SELECT wicket FROM status WHERE status_id=$ballid AND match_id=$matchid";
       $result=$conn->query($addwicket) or die(mysqli_error($conn));
      if ($result->num_rows > 0)
       {
         $row = $result->fetch_assoc();
         $wiket=1+$row["wicket"];
         $sql="UPDATE  status  SET wicket=$wiket WHERE status_id=$ballid";
         $result=$conn->query($sql);
       
       } 
    }
    else
    {
         $addwicket ="SELECT extra_wicket FROM status WHERE status_id=$ballid AND  match_id=$matchid";
          $result=$conn->query($addwicket) or die(mysqli_error($conn));
         if ($result->num_rows > 0)
         {
            $wiket=0;
            $row = $result->fetch_assoc();
            $wiket=1+$row["extra_wicket"];
            $sql="UPDATE  status  SET extra_wicket=$wiket  WHERE status_id=$ballid";
            $result=$conn->query($sql);
       
         }
    }

    // make null which batsman is out
    if($outtype==8)
        {
           $sql="UPDATE status SET stricking_role=NULL WHERE status_id=$bat2id";
           $result=$conn->query($sql); 
        }
        else
        {
            $sql="UPDATE status SET stricking_role=NULL WHERE status_id=$bat1id";
            $result=$conn->query($sql);
        }
}



// check if lageby && wicket
else if($typerun==5 && $extra_runtype==5 && $runs!=null && $outtype!=null)
{
    $flag=1;

   // update bowler extra run
    $addrun="SELECT extra FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["extra"];
        $sql="UPDATE  status  SET extra=$run WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }

     // update ball played by batsman
    $addball ="SELECT played_ball FROM status WHERE status_id=$bat1id AND match_id=$matchid";
    $result=$conn->query($addball) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $tball=1+$row["played_ball"];
        $sql="UPDATE  status  SET played_ball=$tball WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }

     // update ball  bowler

    $addball ="SELECT bowled_overs FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addball) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $bwlrball=1+$row["bowled_overs"];
        $sql="UPDATE  status  SET bowled_overs=$bwlrball WHERE status_id=$ballid";
        $result=$conn->query($sql);
    }
    //update bowler run
    $addrun="SELECT bowlruns FROM status WHERE status_id=$ballid AND match_id=$matchid";
    $result=$conn->query($addrun) or die(mysqli_error($conn));
    if ($result->num_rows > 0)
    {
        
        $row = $result->fetch_assoc();
        $run=$runs+$row["bowlruns"];
        $sql="UPDATE  status  SET bowlruns=$run WHERE status_id=$ballid ";
        $result=$conn->query($sql);
    }

    
   if($outtype==3)
    {
        $sql="UPDATE status SET out_type='Run out' WHERE status_id=$bat1id ";
        $result=$conn->query($sql);
    }
    else if($outtype==5)
    {
        $sql="UPDATE status SET out_type='Stumped' WHERE status_id=$bat1id ";
        $result=$conn->query($sql);
    }
    else if($outtype==6)
    {
        $sql="UPDATE status SET out_type='Hit-Wicket' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
     else if($outtype==7)
    {
        $sql="UPDATE status SET out_type='Retired-hurt' WHERE status_id=$bat1id";
        $result=$conn->query($sql);
    }
    
    else 
    {
        $sql="UPDATE status SET out_type='Run out' WHERE status_id=$bat2id";
        $result=$conn->query($sql);

    }

    
    // if wicket is stumped add to bowler

    if($outtype==5)
    {
       $addwicket ="SELECT wicket FROM status WHERE status_id=$ballid AND match_id=$matchid";
       $result=$conn->query($addwicket) or die(mysqli_error($conn));
      if ($result->num_rows > 0)
       {
         $row = $result->fetch_assoc();
         $wiket=1+$row["wicket"];
         $sql="UPDATE  status  SET wicket=$wiket WHERE status_id=$ballid";
         $result=$conn->query($sql);
       
       } 
    }
    else
    {
         $addwicket ="SELECT extra_wicket FROM status WHERE status_id=$ballid AND match_id=$matchid";
          $result=$conn->query($addwicket) or die(mysqli_error($conn));
         if ($result->num_rows > 0)
         {
          $wiket=0;
          $row = $result->fetch_assoc();
          $wiket=1+$row["extra_wicket"];
          $sql="UPDATE  status  SET extra_wicket=$wiket  WHERE status_id=$ballid";
          $result=$conn->query($sql);
       
         }
    }

    // make null which batsman is out
    if($outtype==8)
        {
           $sql="UPDATE status SET stricking_role=NULL WHERE status_id=$bat2id";
           $result=$conn->query($sql); 
        }
        else
        {
            $sql="UPDATE status SET stricking_role=NULL WHERE status_id=$bat1id ";
            $result=$conn->query($sql);
        }
}


// after all condition

// count total wicket
      $Bwicket=0;
      $Arun=0;
      $Brun=0;
      $Aball=0;;
      $Bball=0;
      $totalball=0;
      $ingsball=0;
      $allwicket=0;

      $sql="SELECT wicket FROM status WHERE toss=$temid AND match_id=$matchid";
      $result=$conn->query($sql);

      if($result->num_rows>0)
      {
        while($row=$result->fetch_assoc())
        {
            $allwicket+=$row["wicket"];
        }
      }

      $sql="SELECT extra_wicket FROM status WHERE toss=$temid AND match_id=$matchid";
      $result=$conn->query($sql);
          if($result->num_rows>0)
          {
            $wi=0;
              while($row=$result->fetch_assoc())
             {
                $wi+=$row["extra_wicket"];
             }
               $allwicket+=$wi;
          }

     

      
     

// count total && extra wicket
      $sql="SELECT overs FROM m_atch WHERE match_id=$matchid";
      $result=$conn->query($sql);

      while( $row=$result->fetch_assoc())
      {
        $totalball=$row["overs"]*6;
      }

// count total wicket
     $sql="SELECT bowled_overs FROM status WHERE toss=$temid AND match_id=$matchid";
     $result=$conn->query($sql);
    
     if($result->num_rows>0)
     { 
        while($row=$result->fetch_assoc())
        {
             $ingsball+=$row["bowled_overs"];
        }
     }
     $sql="SELECT bowled_overs FROM status WHERE toss=$tossid AND match_id=$matchid";
     $result=$conn->query($sql);
    
     if($result->num_rows>0)
     { 
        while($row=$result->fetch_assoc())
        {
             $Bball+=$row["bowled_overs"];
        }
     }
     echo $Bball."<br>";

     // check if present bowled 6
     $sql="SELECT bowled_overs FROM status WHERE status_id=$ballid AND match_id=$matchid";
     $result=$conn->query($sql);
     if($result->num_rows>0)
     { 
       while( $row=$result->fetch_assoc())
       {
           $bwlarball=$row["bowled_overs"];
       }
       
     }


     $sql="SELECT bowlruns FROM status WHERE toss=$temid AND match_id=$matchid";
     $result=$conn->query($sql);
    
     if($result->num_rows>0)
     { 
        while($row=$result->fetch_assoc())
        {
             $Arun+=$row["bowlruns"];
        }
     }
     $sql="SELECT bowlruns FROM status WHERE toss=$tossid AND match_id=$matchid";
     $result=$conn->query($sql);
    
     if($result->num_rows>0)
     { 
        while($row=$result->fetch_assoc())
        {
             $Brun+=$row["bowlruns"];
        }
     }



    if($Arun>$Brun && $Bball>0)
    {
      
     // echo "xxxxxxxxx";
       // echo $Brun
         $sql="UPDATE status SET stricking_role = NULL WHERE match_id=$matchid";
         $result=$conn->query($sql);
         header("Location:index.php");
         exit;
    }
   else if($allwicket==10&&$Bball>0 || $totalball==$ingsball&& $Bball>0)
    {

       // echo $Brun
         $sql="UPDATE status SET stricking_role = NULL WHERE match_id=$matchid";
         $result=$conn->query($sql);
         header("Location:index.php");
         exit;
    }
    else if($allwicket==10 && $Brun==$Arun ||$totalball==$ingsball && $Brun==$Arun)
    {
         
       // echo $Brun
         $sql="UPDATE status SET stricking_role = NULL WHERE match_id=$matchid";
         $result=$conn->query($sql);
         header("Location:index.php");
         exit;
    }
    
    else if(($allwicket==10 && $Brun<$Arun && $Bball>0)||($totalball==$ingsball && $Brun<$Arun && $Bball!=0))
       {
         // echo " AAAAAA";
       // echo $Brun
         $sql="UPDATE status SET stricking_role = NULL WHERE match_id=$matchid";
         $result=$conn->query($sql);
         header("Location:index.php");
         exit;
      }
    

// if all wicket is 10 || total overs then innings is finished
   else if($allwicket==10||$totalball==$ingsball)
     {
         $sql="UPDATE status SET stricking_role = NULL WHERE match_id=$matchid";
         $result=$conn->query($sql);
         header("Location:secondinnings.php");
         exit;
     }
     else if($flag==1 && $bwlarball==6)
     {
         $sql="UPDATE status SET stricking_role = NULL WHERE status_id=$ballid";
         $result=$conn->query($sql);

            header("Location:newbatsman1.php");
               exit;
     }
     else if($flag==1&& $bwlarball!=6)
     {
          header("Location:newbatsman.php");
        exit;
     }
     //if bwlarball is 6
     else if($bwlarball==6)
     {

         $sql="SELECT player_id FROM status WHERE stricking_role=1 AND match_id=$matchid";
         $result=$conn->query($sql);
         if($result->num_rows>0)
         {
           while($rows=$result->fetch_assoc())
           {
              $p1id=$rows["player_id"];

           }
                   
        }
        $sql="SELECT player_id FROM status WHERE stricking_role=0 AND match_id=$matchid";
        $result=$conn->query($sql);
        if($result->num_rows>0)
         {
           while($rows=$result->fetch_assoc())
           {
              $p2id=$rows["player_id"];

           }
                   
        }
        
        $sql="UPDATE status SET stricking_role =0 WHERE player_id=$p1id ";
        $result=$conn->query($sql);
        $sql="UPDATE status SET stricking_role =1 WHERE player_id=$p2id ";
        $result=$conn->query($sql);

         $sql="UPDATE status SET stricking_role = NULL WHERE status_id=$ballid";
         $result=$conn->query($sql);
         header("Location:newbowler.php");
         exit;
     }
     header("Location:ballbyball.php");
        exit;


?>