<?php

//connect to server and database

$conn=mysqli_connect("localhost","root","","update_score");
 if(!$conn)
 {
     die("Failed to connect ".mysqli_connect_error());
 }
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Cricket Scoreboard</title>
    <style>
        body
        {
            font-family: sans-serif;
            font-size: 11pt;
            background-image: url(cricket-balls-hd-free-wallpapers.jpg);
            background-size: cover;
            background-attachment: fixed;   
        }
        
        table
        {
            width: 80%;
        }
        
        table,th,td
        {
            border: .1px solid black;
            border-collapse: collapse;
            opacity: 0.85;
        }
        
        th,td
        {
            padding: 4px 30px 4px 8px;
            text-align: left;
        }
        
        th
        {
            background-color: chartreuse;
            color: black;
            
        }
        
        tr:nth-child(even)
        {
            background-color: #e8e8e8;
        }
        
        tr:nth-child(odd)
        {
            background-color: white;
        }
        
        #header
        {
            background-color: moccasin;
            color: black;
            text-align: center;
        }
        
    </style>
</head>
<body>
    <h1 align="center">Full Scorecard</h1>
    <h2 align="center">
     <?php
       $id1=NULL;
       $id2=NULL;
       $team_A;
       $team_B;

      // select which team are in the match
       $sql="SELECT team_id FROM team";
       $result=$conn->query($sql);
       if($result->num_rows>0)
       {
          while($row=$result->fetch_assoc())
          {
            $id2=$row["team_id"];
          }
             $id1=$id2-1;
       }

     // show which team are in the match
      if($id1!=NULL)
      {
        $sql="SELECT team_name FROM team WHERE team_id=$id1";
       $result=$conn->query($sql);
       if($result->num_rows>0)
       {
          $row=$result->fetch_assoc();
            $team_A=$row["team_name"];
             echo " $team_A ";
       }
      }
       // show which team are in the match
     if($id2!=NULL)
     {
        $sql="SELECT team_name FROM team WHERE team_id=$id2";
       $result=$conn->query($sql);
       if($result->num_rows>0)
       {
          $row=$result->fetch_assoc();
            $team_B=$row["team_name"];
            echo " VS  $team_B"."<br>";
       }
     }

     ?>
   </h2>

    <h2>
      <?php
        $toss=NULL;
        $team_name=NULL;
        $team_Aid=NULL;
        $team_Bid=NULL;
        $team_id=NULL;
        $sum_run=0;
        $sum_wicket=0;
        $sum_over=0;
        $matchid=NULL;
        $over=0;
        $over1=0;
        $over_point=0;
        $teamArun=0;
        $teamBrun=0;

        // select which team in toss
        $sql="SELECT toss FROM m_atch";
        $result=$conn->query($sql);
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
                $toss=$row["toss"];
            }
        }

        // select match id from match table to calculate 
        //this match run wicket 
        $sql="SELECT match_id FROM m_atch";
        $result=$conn->query($sql);
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
                $matchid=$row["match_id"];
            }
           // echo "$matchid";
        }

        $sql="SELECT overs FROM m_atch ";
        $result=$conn->query($sql);
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
                $over=$row["overs"];
            }
           // echo "$matchid";
        }


       // show which team is in the batting position
        if($toss!=NULL)
        {
             $sql="SELECT team_name FROM team WHERE team_id=$toss";
             $result=$conn->query($sql);
             if($result->num_rows>0)
            {
              $row=$result->fetch_assoc();
              $team_name=$row["team_name"];
           }
        }

      
      // select which is in bowling position
       $sql="SELECT team_id FROM team";
       $result=$conn->query($sql);
       if($result->num_rows>0)
       {
          while($row=$result->fetch_assoc())
          {
            $team_Bid=$row["team_id"];
          }
          $team_Aid=$team_Bid-1;
          if($toss==$team_Aid)
          {
           $team_id=$team_Bid;
          }
         if($toss==$team_Bid)
          {
            $team_id=$team_Aid;
          }
       }
       //echo $team_Aid." ".$team_Bid." ".$toss."<br>";

       
       //calculate batting run
       if($team_id!=NULL)
       {
          $sql= "SELECT bowlruns FROM status WHERE toss=$team_id AND match_id=$matchid";
          $result=$conn->query($sql);
          if($result->num_rows>0)
          {
            while($row=$result->fetch_assoc())
           {
            $sum_run=$sum_run+$row["bowlruns"];
           }
        
         }
       }
       
      // calculate falling wicket for batting team
      if($team_id!=NULL)
      {

        $sql= "SELECT wicket FROM status WHERE toss=$team_id AND match_id=$matchid";
        $result=$conn->query($sql);
          if($result->num_rows>0)
          {
            while ($row=$result->fetch_assoc())
            {
                  $sum_wicket+=$row["wicket"];
            }
        
          }
      }

         
        // calculate extra wicket for batting team
        if($team_id!=NULL)
        {
          
           $sql= "SELECT extra_wicket FROM status WHERE toss=$team_id AND match_id=$matchid";
          $result=$conn->query($sql);
          if($result->num_rows>0)
          {
            while ($row=$result->fetch_assoc())
            {
                  $sum_wicket+=$row["extra_wicket"];
            }
        
          }
        }


       
          //calculate batting and bowling bat run for which is win

        if($team_id!=NULL)
        {
          
           $sql= "SELECT bowlruns FROM status WHERE toss=$team_Bid AND match_id=$matchid";
          $result=$conn->query($sql);
          if($result->num_rows>0)
          {
            while ($row=$result->fetch_assoc())
            {
                  $teamArun+=$row["bowlruns"];
            }
        
          }
        }
         if($team_id!=NULL)
        {
          
        $sql= "SELECT bowlruns FROM status WHERE toss=$team_Aid AND match_id=$matchid";
        $result=$conn->query($sql);
        if($result->num_rows>0)
          {
            while ($row=$result->fetch_assoc())
            {
                  $teamBrun+=$row["bowlruns"];
            }
        
          }
        }
         // here which team is win final result
        if($teamArun!=0&&$teamBrun!=0)
        {
               $Awicket=0;
               $Bwicket=0;
               $Aball=0;
               $Bball=0;

               $sql="SELECT bowled_overs FROM status WHERE toss=$team_Bid AND match_id=$matchid";
              $result=$conn->query($sql);
             if($result->num_rows>0)
             {
              while ($row=$result->fetch_assoc())
               {
                  $Aball+=$row["bowled_overs"];
               }
        
             }

              $sql="SELECT bowled_overs FROM status WHERE toss=$team_Aid AND match_id=$matchid";
              $result=$conn->query($sql);
             if($result->num_rows>0)
             {
              while ($row=$result->fetch_assoc())
               {
                  $Bball+=$row["bowled_overs"];
               }
        
             }
              $sql="SELECT wicket FROM status WHERE toss=$team_Bid AND match_id=$matchid";
              $result=$conn->query($sql);
             if($result->num_rows>0)
             {
              while ($row=$result->fetch_assoc())
               {
                  $Awicket+=$row["wicket"];
               }
        
             }

             $sql="SELECT extra_wicket FROM status WHERE toss=$team_Bid AND match_id=$matchid";
              $result=$conn->query($sql);
             if($result->num_rows>0)
             {
              while ($row=$result->fetch_assoc())
               {
                  $Awicket+=$row["extra_wicket"];
               }
        
             }


              
                $sql="SELECT wicket FROM status WHERE toss=$team_Aid AND match_id=$matchid";
              $result=$conn->query($sql);
             if($result->num_rows>0)
             {
              while ($row=$result->fetch_assoc())
               {
                  $Bwicket+=$row["wicket"];
               }
        
             }
             $sql="SELECT extra_wicket FROM status WHERE toss=$team_Aid AND match_id=$matchid";
              $result=$conn->query($sql);
             if($result->num_rows>0)
             {
              while ($row=$result->fetch_assoc())
               {
                  $Bwicket+=$row["extra_wicket"];
               }
        
             }
           // echo "$"
            // if teamA is bat first and  win
             if($team_Aid!=$toss && $Bwicket==10 && $teamArun>$teamBrun || $team_Aid!=$toss && $Bball==$over*6 && $teamArun>$teamBrun)
             {
                if($teamArun>$teamBrun)
                 {
                 $sql="SELECT team_name FROM team WHERE  team_id=$team_Aid";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                   {
                    $row=$result->fetch_assoc();
                    $name=$row["team_name"];
                   $run1=$teamArun-$teamBrun;
                   if($run1>1)
                   {
                    echo "<span style='position:absolute;right:630px;'>".$name. " won by ".$run1." runs"."</span>"."<br>";
                   }
                   else
                   {
                      echo "<span style='position:absolute;right:630px;'>".$name. " won by ".$run1." run"."</span>"."<br>";
                   }
                   
                  }
              
                }
             }
             
             // if team B is bat first and win
            else if($team_Bid!=$toss && $Awicket==10 && $teamArun<$teamBrun || $team_Bid!=$toss && $Aball==$over*6 && $teamArun<$teamBrun)
             {
                if($teamArun<$teamBrun)
                 {
                 $sql="SELECT team_name FROM team WHERE  team_id=$team_Bid";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                    if($result->num_rows>0)
                   {
                    $row=$result->fetch_assoc();
                    $name=$row["team_name"];
                    $run1=$teamBrun-$teamArun;
                   if($run1>1)
                   {
                       echo "<span style='position:absolute;right:630px;'>".$name. " won by ".$run1." runs"."</span>"."<br>";
                   } 

                   else
                   {
                      echo "<span style='position:absolute;right:630px;'>".$name. " won by ".$run1." run"."</span>"."<br>";
                   }
                  }
              
                }
             }

             // if both team runs is same then match tied
             else if( $toss== $team_Aid && $Awicket==10 && $teamArun==$teamBrun || $toss==$team_Aid && $Aball==$over*6 && $teamArun==$teamBrun || $toss==$team_Bid && $Bwicket==10 && $teamArun==$teamBrun || $toss==$team_Bid && $Bball==$over*6 && $teamArun==$teamBrun)
             {
                
                   echo "<span style='position:absolute;right:630px;'>"."Match tied"."</span>"."<br>";
                   
              
             }
             

         
         // if teamB is batted second innings and win
         else if($team_Bid==$toss)
         {
            if($teamArun<$teamBrun)
          {
            $all=10-$Bwicket;
            
            $sql="SELECT team_name FROM team WHERE  team_id=$team_Bid";
              $result=$conn->query($sql);
             if($result->num_rows>0)
             {
                    $row=$result->fetch_assoc();
                    $name=$row["team_name"];
                  // $run1=$teamBrun-$teamArun;
                   if($all>1)
                   {
                       echo "<span style='position:absolute;right:630px;'>".$name. " won by ".$all." wickets"."</span>"."<br>";
                   }
                   else
                   {
                     echo "<span style='position:absolute;right:630px;'>".$name. " won by ".$all." wicket"."</span>"."<br>";
                   }

                  
              }
              
          }
         }
         // if teamA is batted second inning and win
         else if($team_Aid==$toss)
         {
             if($teamArun>$teamBrun)
          {
            $all=10-$Awicket;
            
            $sql="SELECT team_name FROM team WHERE  team_id=$team_Aid";
              $result=$conn->query($sql);
             if($result->num_rows>0)
             {
                    $row=$result->fetch_assoc();
                    $name=$row["team_name"];
                 //  $run1=$teamBrun-$teamArun;
                    if($all>1)
                    {
                       echo "<span style='position:absolute;right:630px;'>".$name. " won by ".$all." wickets"."</span>"."<br>";
                    }
                    else
                    {
                      echo "<span style='position:absolute;right:630px;'>".$name. " won by ".$all." wicket"."</span>"."<br>";
                    }
                   
              }

              
          }
         }
          
}


// calculate over
    if($toss!=NULL && $toss==$team_Aid|| $toss!=NULL && $toss==$team_Bid)
    {
    
        $sql= "SELECT bowled_overs FROM status WHERE toss=$team_id";
        $result=$conn->query($sql);
        if($result->num_rows>0)
          {
            while ($row=$result->fetch_assoc())
            {
                  $sum_over+=$row["bowled_overs"];
            }
              $over1=intval($sum_over/6);
              $over_point=($sum_over)%6;
          }
    }

// show which team is batted
if($toss!=NULL&&$toss==$team_Bid|| $toss!=NULL&&$toss==$team_Aid)
{

    echo "<br>"."$team_name   $sum_run/$sum_wicket"."<br>";
    echo "Overs $over1.$over_point";
}
      

?>
</h2>

<table align="center">
	<tr>
        <td id="header" colspan="7">
        <h3>
              <?php
              $toss=NULL;
              $team;
              $overs;
              $match;
              $team_Aid=NULL;
              $team_Bid=NULL;

       // select which is in bowling position
       $sql="SELECT team_id FROM team";
       $result=$conn->query($sql);
       if($result->num_rows>0)
       {
          while($row=$result->fetch_assoc())
          {
            $team_Bid=$row["team_id"];
          }
           $team_Aid=$team_Bid-1;
          
       }
        

              $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }

              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }

              if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
              {
                $sql="SELECT team_name FROM team WHERE team_id=$toss";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                 {
                  while($row= $result->fetch_assoc())
                   {
                    $team=$row["team_name"];
                   }
                    echo "$team";
                 }
               }
                
                 if($toss!=NULL&& $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
                 {
                    $sql="SELECT overs FROM m_atch WHERE match_id=$match";
                    $result=$conn->query($sql);
                   if($result->num_rows>0)
                   {
                     while($row= $result->fetch_assoc())
                     {
                      $overs=$row["overs"];
                     }

                     echo "($overs overs maximum)"."<br>";
                   }
                }  

        

        
       ?>

     </h3>
     </td>
    </tr>
    <tr>
        <th>
          Batsman <br>
            <?php

                $p1id;
                $p2id;
                $toss=NULL;
                $strid;
                $str;
                $match;
                $team_Bid=NULL;
                $team_Aid=NULL;

                  $sql="SELECT team_id FROM team";
                  $result=$conn->query($sql);
                  if($result->num_rows>0)
                   {
                     while($row=$result->fetch_assoc())
                      {
                         $team_Bid=$row["team_id"];
                      }
                       $team_Aid=$team_Bid-1;
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


              $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
                

               if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
               {
                $sql="SELECT player_id,stricking_role FROM status WHERE toss=$toss AND  out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
         
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {

                        $p1id=$row["player_id"];
                        $str=$row["stricking_role"];
                        $sql1="SELECT player_name FROM players WHERE player_id=$p1id";
                        $result1=$conn->query($sql1);

                        if($result1->num_rows>0)
                        {
                           while($row1=$result1->fetch_assoc())
                           {
                              $p2id=$row1["player_name"];
                            
                           }

                           if($str==1)
                           {
                             
                             echo "$p2id*"."<br>";
                            
                           }
                           else
                           {
                            echo "$p2id"."<br>";
                           }
                            
                        }
                          
                    }
                }
            }
               
               
  ?>

 </th>
        <th>
    
              Out<br>

              <?php

                   $p1id;
                   $p2id;
                   $toss=NULL;
                   $match;
                   $team_Bid=NULL;
                   $team_Aid=NULL;



                    $sql="SELECT team_id FROM team";
                    $result=$conn->query($sql);
                    if($result->num_rows>0)
                    {
                        while($row=$result->fetch_assoc())
                        {
                          $team_Bid=$row["team_id"];
                        }
                        $team_Aid=$team_Bid-1;
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
                 $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }

               if($toss!=NULL&& $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
               {
                   $sql="SELECT out_type FROM status WHERE toss=$toss AND out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $out_type=$row["out_type"];
                        echo "$out_type"."<br>";
                    }
                }
               }

             ?>

        </th>

        <th>

              Runs<br>
              <?php

                   $p1id;
                   $p2id;
                   $toss;
                   $match;
                   $team_Bid=NULL;
                   $team_Aid=NULL;

                    $sql="SELECT team_id FROM team";
                    $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {
                  while($row=$result->fetch_assoc())
                  {
                    $team_Bid=$row["team_id"];
                  }
                  $team_Aid=$team_Bid-1;
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

                 $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
               if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
               {
                   $sql="SELECT bat_run FROM status WHERE toss=$toss AND out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $bat_run=$row["bat_run"];
                        echo "$bat_run"."<br>";
                    }
                }
               }
                

             ?>
        </th>


        <th>

             Balls<br>

             <?php
                   $p1id;
                   $p2id;
                   $toss=NULL;
                   $match;
                   $team_Aid=NULL;
                   $team_Bid=NULL;

                  $sql="SELECT team_id FROM team";
                  $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {
                  while($row=$result->fetch_assoc())
                  {
                    $team_Bid=$row["team_id"];
                  }
                  $team_Aid=$team_Bid-1;
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

                if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
               {
                $sql="SELECT played_ball FROM status WHERE toss=$toss AND out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $ball=$row["played_ball"];
                        echo "$ball"."<br>";
                    }
                }
              
               }
             ?>



        </th>
        <th>
             4s<br>
             <?php
                   $p1id;
                   $p2id;
                   $toss=NULL;
                   $match;
                   $team_Aid=NULL;
                   $team_Bid=NULL;

                    $sql="SELECT team_id FROM team";
                    $result=$conn->query($sql);
                   if($result->num_rows>0)
                   {
                    while($row=$result->fetch_assoc())
                     {
                        $team_Bid=$row["team_id"];
                     }
                      $team_Aid=$team_Bid-1;
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

                 $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }

                if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
                {
                $sql="SELECT hitted_fours FROM status WHERE toss=$toss AND out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $four=$row["hitted_fours"];
                        echo "$four"."<br>";
                    }
                }

                }

               

             ?>
        </th>

        <th>

              6s<br>
              <?php
                   $p1id;
                   $p2id;
                   $toss=NULL;
                   $match;

                   $team_Aid=NULL;
                   $team_Bid=NULL;

                    $sql="SELECT team_id FROM team";
                    $result=$conn->query($sql);
                   if($result->num_rows>0)
                   {
                    while($row=$result->fetch_assoc())
                     {
                        $team_Bid=$row["team_id"];
                     }
                      $team_Aid=$team_Bid-1;
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

                 $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
                if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)

                {
                $sql="SELECT hitted_sixes FROM status WHERE toss=$toss AND out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $six=$row["hitted_sixes"];
                        echo "$six"."<br>";
                    }
                }

                }

               

             ?>

        </th>
        <th>

            SR<br>

            <?php
               
               $toss;
               $match;
               $team_Aid=NULL;
               $team_Bid=NULL;

               $sql="SELECT team_id FROM team";
               $result=$conn->query($sql);
                if($result->num_rows>0)
                 {
                    while($row=$result->fetch_assoc())
                     {
                        $team_Bid=$row["team_id"];
                     }
                      $team_Aid=$team_Bid-1;
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
                 $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }

                if($toss!=NULL && $toss==$team_Bid || $toss!=NULL && $toss==$team_Aid)
               {
                  $sql="SELECT bat_run,played_ball FROM status WHERE toss=$toss AND out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
                 // $sql1="SELECT played_ball FROM status WHERE toss=$toss AND stricking_role IS NOT NULL";
                  // $result1=$conn->query($sql1);
                if($result->num_rows)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $bat_run=$row["bat_run"];
                        $ball=$row["played_ball"];
                        $str=0;
                       // echo "$bat_run "."$ball". "1"."<br>";
                        if($ball!=0)
                        {
                            $str= round(($bat_run/$ball)*100,2); 
                        }
                       
                       // $str*=100;
                        if($str>=1)
                        echo "$str"."<br>";
                       else
                        echo "0"."<br>"; 
                    }
                }
              }

            ?>


        </th>
    </tr>
    
</table>

<table align="center" style="margin-top: 20px;">
<tr>
        <td id="header" colspan="7">
        <h3>
              <?php
              $toss=NULL;
              $team;
              $overs;
              $team_Aid;
              $team_Bid;

              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }

               $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $team=$row["team_id"];
                }
                 $team_Aid=$team-1;
                 $team_Bid=$team;
                 if($toss==$team_Aid)
                 {
                    $team=$team_Bid;
                 }
                 if($toss==$team_Bid)
                 {
                    $team=$team_Aid;
                 }

              }

              if($toss!=NULL && $toss==$team_Bid || $toss!=NULL && $toss==$team_Aid )
              {
                $sql="SELECT team_name FROM team WHERE team_id=$team";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                 {
                  while($row= $result->fetch_assoc())
                   {
                    $team=$row["team_name"];
                   }
                    echo "$team";
                 }
               }
                
               if($toss!=NULL && $toss==$team_Bid || $toss!=NULL && $toss==$team_Aid )
               {
                  $sql="SELECT overs FROM m_atch";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                {
                  while($row= $result->fetch_assoc())
                  {
                    $overs=$row["overs"];
                  }
                  echo "($overs overs maximum)"."<br>";
                }
               }
              ?>

        </h3>
        </td>
    </tr>
    <tr>
        <th>
        Bowler<br>

            <?php

              $toss=NULL;
              $team;
              $overs;
              $team_Aid;
              $team_Bid;
              $match;

              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }
               $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
              
              if($toss!=NULL)
              {
                     $sql="SELECT team_id FROM team";
                     $result=$conn->query($sql);
                     if($result->num_rows>0)
                      {
                      while($row= $result->fetch_assoc())
                       {
                         $team=$row["team_id"];
                       }

                        $team_Aid=$team-1;
                        $team_Bid=$team;
                        if($toss==$team_Aid)
                        {
                          $team=$team_Bid;
                        }
                        if($toss==$team_Bid)
                        {
                         $team=$team_Aid;
                        }
                 
                     }
              }

              if($toss!=NULL)
              {



                $sql="SELECT DISTINCT player_id FROM status WHERE toss=$team AND stricking_role IS NULL AND bowled_overs>1 AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                    while($row=$result->fetch_assoc())
                    {
                        $pid=$row["player_id"];
                        //echo "null $pid"."<br>";
                        $sql2="SELECT player_id FROM status WHERE toss=$team AND stricking_role IS NOT NULL AND match_id=$match";
                        $result2=$conn->query($sql2);
                        $row2=$result2->fetch_assoc();
                        $p2id=$row2["player_id"];
                       // echo "is not null $p2id"."<br>";

                        if($pid!=$p2id)
                        {
                             $sql1="SELECT player_name FROM players WHERE player_id=$pid";
                             $result1=$conn->query($sql1);
                             $row1=$result1->fetch_assoc();
                             $pname=$row1["player_name"];
                            echo "$pname"."<br>";
                        }
                       
                        
                    }
                 }
                 $sql="SELECT player_id FROM status WHERE toss=$team AND stricking_role IS NOT NULL AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                    while($row=$result->fetch_assoc())
                    {
                        $pid=$row["player_id"];
                      //  echo "$pid"."<br>";

                        $sql1="SELECT player_name FROM players WHERE player_id=$pid";
                        $result1=$conn->query($sql1);
                        $row1=$result1->fetch_assoc();
                        $pname=$row1["player_name"];
                        echo "$pname*"."<br>";
                        
                    }
                 }

                
                
              }

             ?>
        </th>
        <th>

           Over<br>

            <?php

              $toss=NULL;
              $team;
              $overs;
              $team_Aid;
              $team_Bid;
              $sumball;
              $match;
              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }
              
              if($toss!=NULL)
              {
                     $sql="SELECT team_id FROM team";
                     $result=$conn->query($sql);
                     if($result->num_rows>0)
                      {
                      while($row= $result->fetch_assoc())
                       {
                         $team=$row["team_id"];
                       }

                        $team_Aid=$team-1;
                        $team_Bid=$team;
                        if($toss==$team_Aid)
                        {
                          $team=$team_Bid;
                        }
                        if($toss==$team_Bid)
                        {
                         $team=$team_Aid;
                        }
                 
                     }
              }

              if($toss!=NULL)
              {



                $sql="SELECT DISTINCT player_id FROM status WHERE toss=$team AND stricking_role IS NULL AND bowled_overs>=1 AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                    while($row=$result->fetch_assoc())
                    {
                        $sumball=0;
                        $pid=$row["player_id"];

                        $sql2="SELECT player_id FROM status WHERE toss=$team AND stricking_role IS NOT NULL AND match_id=$match";
                        $result2=$conn->query($sql2);
                        $row2=$result2->fetch_assoc();
                        $p2id=$row2["player_id"];
                        if($pid!=$p2id)
                        {
                           $sql1="SELECT bowled_overs FROM status WHERE player_id=$pid";
                           $result1=$conn->query($sql1);
                          while ($row1=$result1->fetch_assoc())
                          {
                           $sumball+=$row1["bowled_overs"];
        
                          }
                        
                         $ball=intval($sumball/6);
                         $pointball=$sumball%6;
                         echo "$ball.$pointball"."<br>";
                        }
                        
                    }
                 }

                 $sql="SELECT player_id FROM status WHERE toss=$team AND stricking_role IS NOT NULL AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                     while($row=$result->fetch_assoc())
                    {
                        $sumball=0;
                        $pid=$row["player_id"];

                        $sql1="SELECT bowled_overs FROM status WHERE player_id=$pid";
                        $result1=$conn->query($sql1);
                        while($row1=$result1->fetch_assoc())
                        {
                            $sumball+=$row1["bowled_overs"]; 
                        }

                         
                        
                         $ball=intval($sumball/6);
                        $pointball=$sumball%6;
                        echo "$ball.$pointball"."<br>";  
                    }
                 } 
                
              }

             ?>

        </th>
        <th>

           Run<br>


            <?php

              $toss=NULL;
              $team;
              $overs;
              $team_Aid;
              $team_Bid;
              $sumball;
              $match;
              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }
               $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
              
              if($toss!=NULL)
              {
                     $sql="SELECT team_id FROM team";
                     $result=$conn->query($sql);
                     if($result->num_rows>0)
                      {
                      while($row= $result->fetch_assoc())
                       {
                         $team=$row["team_id"];
                       }

                        $team_Aid=$team-1;
                        $team_Bid=$team;
                        if($toss==$team_Aid)
                        {
                          $team=$team_Bid;
                        }
                        if($toss==$team_Bid)
                        {
                         $team=$team_Aid;
                        }
                 
                     }
              }

              if($toss!=NULL)
              {



                $sql="SELECT DISTINCT player_id FROM status WHERE toss=$team AND stricking_role IS NULL AND bowled_overs>1 AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                    while($row=$result->fetch_assoc())
                    {
                        $sumrun=0;
                        $pid=$row["player_id"];

                        $sql2="SELECT player_id FROM status WHERE toss=$team AND stricking_role IS NOT NULL AND match_id=$match";
                        $result2=$conn->query($sql2);
                        $row2=$result2->fetch_assoc();
                        $p2id=$row2["player_id"];

                        //echo " $pid $p2id"."<br>";
                        if($pid!=$p2id)
                        {
                          $sql1="SELECT bowlruns FROM status WHERE player_id=$pid AND match_id=$match";
                          $result1=$conn->query($sql1);
                          while ($row1=$result1->fetch_assoc())
                          {
                            $sumrun+=$row1["bowlruns"];
        
                          }
                          echo "$sumrun"."<br>";
                        }

                         
                    }
                 }

                 $sql="SELECT player_id FROM status WHERE toss=$team AND stricking_role IS NOT NULL AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                     while($row=$result->fetch_assoc())
                    {
                        $sumrun=0;
                        $pid=$row["player_id"];

                        $sql1="SELECT bowlruns FROM status WHERE player_id=$pid AND match_id=$match";
                        $result1=$conn->query($sql1);
                        while($row1=$result1->fetch_assoc())
                        {
                            $sumrun+=$row1["bowlruns"]; 
                        }

                    
                        echo "$sumrun"."<br>";  
                    }
                 } 
                
              }

             ?>

           
        </th>
            
      
       <th>


              Wicket<br>

            <?php

              $toss=NULL;
              $team;
              $overs;
              $team_Aid;
              $team_Bid;
              $sumball;
              $match;
              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }
               $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
              
              if($toss!=NULL)
              {
                     $sql="SELECT team_id FROM team";
                     $result=$conn->query($sql);
                     if($result->num_rows>0)
                      {
                      while($row= $result->fetch_assoc())
                       {
                         $team=$row["team_id"];
                       }

                        $team_Aid=$team-1;
                        $team_Bid=$team;
                        if($toss==$team_Aid)
                        {
                          $team=$team_Bid;
                        }
                        if($toss==$team_Bid)
                        {
                         $team=$team_Aid;
                        }
                 
                     }
              }

              if($toss!=NULL)
              {



                $sql="SELECT DISTINCT player_id FROM status WHERE toss=$team AND stricking_role IS NULL AND bowled_overs>1 AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                    while($row=$result->fetch_assoc())
                    {
                        $sumwicket=0;
                        $pid=$row["player_id"];

                        $sql2="SELECT player_id FROM status WHERE toss=$team AND stricking_role IS NOT NULL AND match_id=$match";
                        $result2=$conn->query($sql2);
                        $row2=$result2->fetch_assoc();
                        $p2id=$row2["player_id"];
                       // echo "is not null $p2id"."<br>";

                        if($pid!=$p2id)
                        {
                            $sql1="SELECT wicket FROM status WHERE player_id=$pid AND match_id=$match";
                            $result1=$conn->query($sql1);
                            while ($row1=$result1->fetch_assoc())
                            {
                             $sumwicket+=$row1["wicket"];
        
                            }
                           echo "$sumwicket"."<br>"; 
                        }
 
                    }
                 }

                 $sql="SELECT player_id FROM status WHERE toss=$team AND stricking_role IS NOT NULL AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                     while($row=$result->fetch_assoc())
                    {
                        $sumwicket=0;
                        $pid=$row["player_id"];

                        $sql1="SELECT wicket FROM status WHERE player_id=$pid AND match_id=$match";
                        $result1=$conn->query($sql1);
                        while($row1=$result1->fetch_assoc())
                        {
                            $sumwicket+=$row1["wicket"]; 
                        }

                    
                        echo "$sumwicket"."<br>";  
                    }
                 } 
                
              }

             ?>


       </th>
        <th>

           Econ<br>
            <?php

              $toss=NULL;
              $team;
              $overs;
              $team_Aid;
              $team_Bid;
              $sumball=0;
              $match;
              $sumrun=0;
              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }
              
              if($toss!=NULL)
              {
                     $sql="SELECT team_id FROM team";
                     $result=$conn->query($sql);
                     if($result->num_rows>0)
                      {
                      while($row= $result->fetch_assoc())
                       {
                         $team=$row["team_id"];
                       }

                        $team_Aid=$team-1;
                        $team_Bid=$team;
                        if($toss==$team_Aid)
                        {
                          $team=$team_Bid;
                        }
                        if($toss==$team_Bid)
                        {
                         $team=$team_Aid;
                        }
                 
                     }
              }

              if($toss!=NULL)
              {



                $sql="SELECT DISTINCT player_id FROM status WHERE toss=$team AND stricking_role IS NULL AND bowled_overs>=1 AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                    while($row=$result->fetch_assoc())
                    {
                        $sumball=0;
                        $sumrun=0;
                        $pid=$row["player_id"];

                        $sql2="SELECT player_id FROM status WHERE toss=$team AND stricking_role IS NOT NULL AND match_id=$match";
                        $result2=$conn->query($sql2);
                        $row2=$result2->fetch_assoc();
                        $p2id=$row2["player_id"];
                        if($pid!=$p2id)
                        {
                           $sql1="SELECT bowled_overs,bowlruns FROM status WHERE player_id=$pid";
                           $result1=$conn->query($sql1);
                          while ($row1=$result1->fetch_assoc())
                          {
                           $sumball+=$row1["bowled_overs"];
                           $sumrun+=$row1["bowlruns"];
        
                          }
                        
                        $econ=0;
                        if($sumball!=0);
                         $econ=round(($sumrun*6)/$sumball,2);
                        
                         echo "$econ"."<br>";
                        }
                        
                    }
                 }

                 $sql="SELECT player_id FROM status WHERE toss=$team AND stricking_role IS NOT NULL AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                     while($row=$result->fetch_assoc())
                    {
                        $sumball=0;
                        $sumrun=0;
                        $pid=$row["player_id"];

                        $sql1="SELECT bowled_overs,bowlruns FROM status WHERE player_id=$pid";
                        $result1=$conn->query($sql1);
                        while($row1=$result1->fetch_assoc())
                        {
                            $sumball+=$row1["bowled_overs"];
                            $sumrun+=$row1["bowlruns"]; 
                        }

                         $econ=0;
                        if($sumball!=0)
                         $econ=round(($sumrun*6)/$sumball,2);
                      //  $pointball=$sumball%6;
                        echo "$econ"."<br>";  
                    }
                 } 
                
              }
      ?>




        </th>
        </tr>
    
</table>

    <h2>
      <?php

      // first innings
      // first innings
        $toss=NULL;
        $team_name=NULL;
        $team_Aid=NULL;
        $team_Bid=NULL;
        $team_id=NULL;
        $sum_run=0;
        $sum_wicket=0;
        $sum_over=0;
        $matchid;
        $over=0;
        $over_point=0;
        $sum_over=0;
        $sql="SELECT toss FROM m_atch";
        $result=$conn->query($sql);
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
                $toss=$row["toss"];
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
           // echo "$matchid";
        }
         
       $sql="SELECT team_id FROM team";
       $result=$conn->query($sql);
       if($result->num_rows>0)
       {
          while($row=$result->fetch_assoc())
          {
            $team_Bid=$row["team_id"];
          }
          $team_Aid=$team_Bid-1;
        if($toss==$team_Aid)
         {
          $team_id=$team_Bid;
         }
         if($toss==$team_Bid)
         {
         $team_id=$team_Aid;
         }
       }

        if($team_id!=NULL)
        {
             $sql="SELECT team_name FROM team WHERE team_id=$team_id";
             $result=$conn->query($sql);
             if($result->num_rows>0)
            {
              $row=$result->fetch_assoc();
              $team_name=$row["team_name"];
           }
        }

      

       


       if($team_id!=NULL)
       {
          $sql= "SELECT bowlruns FROM status WHERE toss=$toss AND match_id=$matchid";
        $result=$conn->query($sql);
       if($result->num_rows>0)
       {
        while($row=$result->fetch_assoc())
        {
            $sum_run=$sum_run+$row["bowlruns"];
        }
        
       }
      }
       
      
      if($team_id!=NULL)
      {

        $sql= "SELECT wicket FROM status WHERE toss=$toss AND match_id=$matchid";
        $result=$conn->query($sql);
          if($result->num_rows>0)
          {
            while ($row=$result->fetch_assoc())
            {
                  $sum_wicket+=$row["wicket"];
            }
        
          }
      }

         
        
        if($team_id!=NULL)
        {
          
           $sql= "SELECT extra_wicket FROM status WHERE toss=$toss AND match_id=$matchid";
        $result=$conn->query($sql);
        if($result->num_rows>0)
          {
            while ($row=$result->fetch_assoc())
            {
                  $sum_wicket+=$row["extra_wicket"];
            }
        
          }
        }

        
    
        if($team_id!=NULL)
        {
            $sql= "SELECT bowled_overs FROM status WHERE toss=$toss";
          $result=$conn->query($sql);
        if($result->num_rows>0)
          {
            while ($row=$result->fetch_assoc())
            {
                  $sum_over+=$row["bowled_overs"];
            }
              $over=intval($sum_over/6);
             $over_point=($sum_over)%6;

             
          }
        }
  
        if($sum_over>=1)
        {
          echo "$team_name   $sum_run/$sum_wicket"."<br>";
          echo "Overs $over.$over_point";
        }
      

      ?>
     
  </h2>


<table align="center">
  <tr>
        <td id="header" colspan="7">
        <h3>
              <?php
              $toss=NULL;
              $team;
              $overs;
              $match;
              $team_id=NULL;
              $team_Aid;
              $team_Bid;


              $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
              $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $team_Bid=$row["team_id"];
                }
                $team_Aid=$team_Bid-1;
              }

              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
                if($toss==$team_Aid)
                {
                  $team_id=$team_Bid;
                }
                if($toss==$team_Bid)
                {
                  $team_id=$team_Aid;
                }
              }

              if($team_id!=NULL)
              {
                $sql="SELECT team_name FROM team WHERE team_id=$team_id";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                 {
                  $row= $result->fetch_assoc();
                    $team=$row["team_name"];
                    echo "$team";
                 }
                

                 $sql="SELECT overs FROM m_atch WHERE match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                {
                  while($row= $result->fetch_assoc())
                  {
                    $overs=$row["overs"];
                  }
                  echo "($overs over maximum)"."<br>";
                }

              }
              ?>

        </h3>
        </td>
    </tr>
    <tr>
        <th>
          Batsman <br>
            <?php

                $p1id;
                $p2id;
                $toss=NULL;
                $strid;
                $str;
                $match;
                $team_Aid;
                $team_Bid;
                $team_id=NULL;
                $sql="SELECT toss FROM m_atch";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $toss=$row["toss"];
                    }
                }


              $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
               $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $team_Bid=$row["team_id"];
                }
                $team_Aid=$team_Bid-1;

                if($toss==$team_Aid)
                {
                  $team_id=$team_Bid;
                }
                if($toss==$team_Bid)
                {
                  $team_id=$team_Aid;
                }
              }
                

               if($team_id!=NULL)
               {
                $sql="SELECT player_id,stricking_role FROM status WHERE toss=$team_id AND  out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
         
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {

                        $p1id=$row["player_id"];
                        $str=$row["stricking_role"];
                        $sql1="SELECT player_name FROM players WHERE player_id=$p1id";
                        $result1=$conn->query($sql1);

                        if($result1->num_rows>0)
                        {
                           while($row1=$result1->fetch_assoc())
                           {
                              $p2id=$row1["player_name"];
                            
                           }

                           if($str==1)
                           {
                             
                             echo "$p2id*"."<br>";
                            
                           }
                           else
                           {
                            echo "$p2id"."<br>";
                           }
                            
                        }
                          
                    }
                }
            }
               
               
             ?>

        </th>
        <th>
    
              Out<br>

              <?php

                   $p1id;
                   $p2id;
                   $toss=NULL;
                   $match;
                   $team_id=NULL;
                   $team_Bid;
                   $team_Aid;

                $sql="SELECT toss FROM m_atch";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $toss=$row["toss"];
                    }
                }
              $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
               $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $team_Bid=$row["team_id"];
                }
                $team_Aid=$team_Bid-1;

                if($toss==$team_Aid)
                {
                  $team_id=$team_Bid;
                }
                if($toss==$team_Bid)
                {
                  $team_id=$team_Aid;
                }
              }
               if($team_id!=NULL)
               {
                   $sql="SELECT out_type FROM status WHERE toss=$team_id AND out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $out_type=$row["out_type"];
                        echo "$out_type"."<br>";
                    }
                }
               }

             ?>

        </th>

        <th>

              Runs<br>
              <?php

                   $p1id;
                   $p2id;
                   $toss=NULL;
                   $match;
                   $team_id=NULL;
                   $team_Bid;
                   $team_Aid;
                $sql="SELECT toss FROM m_atch";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $toss=$row["toss"];
                    }
                }
                 $sql="SELECT team_id FROM team";
                $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $team_Bid=$row["team_id"];
                }
                $team_Aid=$team_Bid-1;

                if($toss==$team_Aid)
                {
                  $team_id=$team_Bid;
                }
                if($toss==$team_Bid)
                {
                  $team_id=$team_Aid;
                }
              }

                 $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
               if($team_id!=NULL)
               {
                   $sql="SELECT bat_run FROM status WHERE toss=$team_id AND out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $bat_run=$row["bat_run"];
                        echo "$bat_run"."<br>";
                    }
                }
               }
                

             ?>
        </th>


        <th>

             Balls<br>

             <?php
                   $p1id;
                   $p2id;
                   $toss=NULL;
                   $match=NULL;
                   $team_id=NULL;
                   $team_Aid;
                   $team_Bid;

                $sql="SELECT match_id FROM m_atch";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $match=$row["match_id"];
                    }
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
                 $sql="SELECT team_id FROM team";
                 $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $team_Bid=$row["team_id"];
                }
                $team_Aid=$team_Bid-1;

                if($toss==$team_Aid)
                {
                  $team_id=$team_Bid;
                }
                if($toss==$team_Bid)
                {
                  $team_id=$team_Aid;
                }
              }

                if($team_id!=NULL)
               {
                $sql="SELECT played_ball FROM status WHERE toss=$team_id AND out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $ball=$row["played_ball"];
                        echo "$ball"."<br>";
                    }
                }
              
               }
             ?>



        </th>
        <th>
             4s<br>
             <?php
                   $p1id;
                   $p2id;
                   $toss=NULL;
                   $match=NULL;
                   $team_id=NULL;
                   $team_Aid;
                   $team_Bid;

                $sql="SELECT toss FROM m_atch";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $toss=$row["toss"];
                    }
                }
                 $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $team_Bid=$row["team_id"];
                }
                $team_Aid=$team_Bid-1;

                if($toss==$team_Aid)
                {
                  $team_id=$team_Bid;
                }
                if($toss==$team_Bid)
                {
                  $team_id=$team_Aid;
                }
              }

                 $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }

                if($team_id!=NULL)
                {
                $sql="SELECT hitted_fours FROM status WHERE toss=$team_id AND out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $four=$row["hitted_fours"];
                        echo "$four"."<br>";
                    }
                }

                }

               

             ?>
        </th>

        <th>

              6s<br>
              <?php
                   $p1id;
                   $p2id;
                   $toss=NULL;
                   $match;
                   $team_id=NULL;
                   $team_Aid;
                   $team_Bid;

                $sql="SELECT toss FROM m_atch";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $toss=$row["toss"];
                    }
                }
              $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $team_Bid=$row["team_id"];
                }
                $team_Aid=$team_Bid-1;

                if($toss==$team_Aid)
                {
                  $team_id=$team_Bid;
                }
                if($toss==$team_Bid)
                {
                  $team_id=$team_Aid;
                }
              }

                 $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
                if($team_id!=NULL)

                {
                $sql="SELECT hitted_sixes FROM status WHERE toss=$team_id AND out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $six=$row["hitted_sixes"];
                        echo "$six"."<br>";
                    }
                }

                }

               

             ?>

        </th>
        <th>

            SR<br>

            <?php
               
               $toss=NULL;
               $match;
               $team_id=NULL;
               $team_Aid;
               $team_Bid;

                $sql="SELECT toss FROM m_atch";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $toss=$row["toss"];
                    }
                }

                 $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $team_Bid=$row["team_id"];
                }
                $team_Aid=$team_Bid-1;

                if($toss==$team_Aid)
                {
                  $team_id=$team_Bid;
                }
                if($toss==$team_Bid)
                {
                  $team_id=$team_Aid;
                }
              }

                 $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }

                if($team_id!=NULL)
               {
                  $sql="SELECT bat_run,played_ball FROM status WHERE toss=$team_id AND out_type IS NOT NULL AND match_id=$match";
                $result=$conn->query($sql);
                 // $sql1="SELECT played_ball FROM status WHERE toss=$toss AND stricking_role IS NOT NULL";
                  // $result1=$conn->query($sql1);
                if($result->num_rows)
                {
                    while($row=$result->fetch_assoc())
                    {
                        $bat_run=$row["bat_run"];
                        $ball=$row["played_ball"];
                        $str=0;
                       // echo "$bat_run "."$ball". "1"."<br>";
                        if($ball!=0)
                        {
                            $str= round(($bat_run/$ball)*100,2); 
                        }
                       
                       // $str*=100;
                        if($str>=1)
                        echo "$str"."<br>";
                       else
                        echo "0"."<br>"; 
                    }
                }
              }

            ?>


        </th>
    </tr>
    </h3>
    
</table>

<table align="center" style="margin-top: 20px;">
<tr>
        <td id="header" colspan="7">
        <h3>
              <?php
              $toss=NULL;
              $team;
              $overs;
              $team_Aid=NULL;
              $team_Bid=NULL;

              $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
              while($row=$result->fetch_assoc())
               {
                 $team_Bid=$row["team_id"];
               }
                $team_Aid=$team_Bid-1;
              }

              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }

              

              if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
              {
                $sql="SELECT team_name FROM team WHERE team_id=$toss";
                $result=$conn->query($sql);
                if($result->num_rows>0)
                 {
                  while($row= $result->fetch_assoc())
                   {
                    $team=$row["team_name"];
                   }
                    echo "$team";
                 }
               }
                
                 if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
                 {
                    $sql="SELECT overs FROM m_atch";
                    $result=$conn->query($sql);
                   if($result->num_rows>0)
                   {
                     while($row= $result->fetch_assoc())
                     {
                       $overs=$row["overs"];
                     }
                    echo "($overs over maximum)"."<br>";
                   }
                 }
                 
              ?>

        </h3>
        </td>
    </tr>
    <tr>
        <th>
        Bowler<br>

            <?php

              $toss=NULL;
              $team;
              $overs;
              $match=NULL;
              $team_Aid=NULL;
              $team_Bid=NULL;

              $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
              while($row=$result->fetch_assoc())
               {
                 $team_Bid=$row["team_id"];
               }
                $team_Aid=$team_Bid-1;
              }

              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }
               $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
              
     

              if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
              {



                $sql="SELECT DISTINCT player_id FROM status WHERE toss=$toss AND bowled_overs>1 AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                    while($row=$result->fetch_assoc())
                    {
                        $pid=$row["player_id"];
                        
                             $sql1="SELECT  player_name FROM players WHERE player_id=$pid";
                             $result1=$conn->query($sql1);
                             $row1=$result1->fetch_assoc();
                             $pname=$row1["player_name"];
                            echo "$pname"."<br>";
                       
                        
                    }
                 }
                
              }

             ?>
        </th>
        <th>

           Over<br>

            <?php

              $toss=NULL;
              $team;
              $overs;
              $sumball;
              $match;
              $team_Aid=NULL;
              $team_Bid=NULL;

              $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
              while($row=$result->fetch_assoc())
               {
                 $team_Bid=$row["team_id"];
               }
                $team_Aid=$team_Bid-1;
              }
              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }
          

              if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
              {



                $sql="SELECT DISTINCT player_id FROM status WHERE toss=$toss  AND bowled_overs>=1 AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                    while($row=$result->fetch_assoc())
                    {
                        $sumball=0;
                        $pid=$row["player_id"];
                        $sql1="SELECT bowled_overs FROM status WHERE player_id=$pid";
                        $result1=$conn->query($sql1);
                          while ($row1=$result1->fetch_assoc())
                          {
                           $sumball+=$row1["bowled_overs"];
        
                          }
                        
                         $ball=intval($sumball/6);
                         $pointball=$sumball%6;
                         echo "$ball.$pointball"."<br>";
                        }
                        
                    }
                 }

             ?>

        </th>
        <th>

           Run<br>


            <?php

              $toss=NULL;
              $team;
              $overs;
              $sumball;
              $match;

               $team_Aid=NULL;
              $team_Bid=NULL;

              $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
              while($row=$result->fetch_assoc())
               {
                 $team_Bid=$row["team_id"];
               }
                $team_Aid=$team_Bid-1;
              }
              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }
               $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
              
              

              if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
              {



                $sql="SELECT DISTINCT player_id FROM status WHERE toss=$toss AND bowled_overs>1 AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                    while($row=$result->fetch_assoc())
                    {
                        $sumrun=0;
                        $pid=$row["player_id"];

                       
                          $sql1="SELECT bowlruns FROM status WHERE player_id=$pid";
                          $result1=$conn->query($sql1);
                          while ($row1=$result1->fetch_assoc())
                          {
                            $sumrun+=$row1["bowlruns"];
        
                          }
                          echo "$sumrun"."<br>";
                        }

                         
                    }
                 }

             ?>  
        </th>
            
      
       <th>


              Wicket<br>

            <?php

              $toss=NULL;
              $team;
              $overs;
              $sumball;
              $match;
              $team_Aid=NULL;
              $team_Bid=NULL;

              $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
              while($row=$result->fetch_assoc())
               {
                 $team_Bid=$row["team_id"];
               }
                $team_Aid=$team_Bid-1;
              }
              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }
               $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
              
            

              if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
              {



                $sql="SELECT DISTINCT player_id FROM status WHERE toss=$toss  AND bowled_overs>=1 AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                    while($row=$result->fetch_assoc())
                    {
                        $sumwicket=0;
                        $pid=$row["player_id"];

                            $sql1="SELECT wicket FROM status WHERE player_id=$pid";
                            $result1=$conn->query($sql1);
                            while ($row1=$result1->fetch_assoc())
                            {
                             $sumwicket+=$row1["wicket"];
        
                            }
                           echo "$sumwicket"."<br>"; 
                        }
 
                    }
                }

             ?>

       </th>

        <th>

          Econ<br>
          <?php

              $toss=NULL;
              $match=NULL;
              $team;
              $overs;
              $team_Aid=NULL;
              $team_Bid=NULL;
              $sumball;
              $match;
              $sumrun;

              $sql="SELECT team_id FROM team";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
              while($row=$result->fetch_assoc())
               {
                 $team_Bid=$row["team_id"];
               }
                $team_Aid=$team_Bid-1;
              }
              $sql="SELECT toss FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $toss=$row["toss"];
                }
              }

              $sql="SELECT match_id FROM m_atch";
              $result=$conn->query($sql);
              if($result->num_rows>0)
              {
                while($row= $result->fetch_assoc())
                {
                    $match=$row["match_id"];
                }
              }
              
             

              if($toss!=NULL && $toss==$team_Aid || $toss!=NULL && $toss==$team_Bid)
              {
                $sql="SELECT DISTINCT player_id FROM status WHERE toss=$toss AND stricking_role IS NULL AND bowled_overs>=1 AND match_id=$match";
                 $result=$conn->query($sql);
                 if($result->num_rows>0)
                 {

                    while($row=$result->fetch_assoc())
                    {
                        $sumball=0;
                        $sumrun=0;
                        $pid=$row["player_id"];

                          $sql1="SELECT bowled_overs,bowlruns FROM status WHERE player_id=$pid";
                          $result1=$conn->query($sql1);
                          while ($row1=$result1->fetch_assoc())
                          {
                           $sumball+=$row1["bowled_overs"];
                           $sumrun+=$row1["bowlruns"];
        
                          }
                        
                         $econ=0;
                         if($sumball!=0);
                         {
                             $econ=round(($sumrun*6)/$sumball,2);
                             
                         }
                        
                        
                         echo "$econ"."<br>";
                        }
                        
                    }
                 }

               
    
          ?>

 </th>
 </tr>  
</table>
</body>

</html>