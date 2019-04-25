<?php
//generate dynamic query php 
//author lexsystems 
//aka alexander dth


//generates advanced sort query
//function for removing unwanted characters and hacking attempts
function clean($string)
{
    $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-\|]/', '', $string); // Removes special chars.
}

//the function itself
function gen_query($params,$table_name)
{
       
       //defining sort order
       if(isset($params["sort"]))
       {
        
       
       foreach($params["sort"] as $sort)
       {
            $get_field = $sort["GET"];
            $sql_field = $sort["sql_field"];
            $sql_order = $sort["order_sql"];
            
            if(isset($_GET["sort"]))
            {
            if($_GET["sort"] == $get_field)
            {
                $sql_sort = "ORDER by $sql_field $sql_order";
                
            }
            }
            else
            {
                $sql_sort = "";
            }
            
       }
       }
       else
       {
        $sql_sort = null;
       }
       
       //define criteria order as in get criteria from something
       if(isset($params["criteria"]))
       {
        
       
       foreach($params["criteria"] as $c)
       {
        $c_field = $c["GET"];
        $c_sql = $c["sql_field"];
           
           if(array_key_exists($c_field, $_GET))
           {
            $criteria_input = $_GET["$c_field"];
            if($criteria_input !="")
            {
            $criteria[] = "$c_sql = '$criteria_input'";
            }
           }
          
       }
        }
        else
        {
            $criteria[] = null;
        }
        
        //define regexp criteria
        if(isset($params["regexp"]))
        { 
       foreach($params["regexp"] as $r)
       {
            $r_field = $r["GET"];
            $r_sql = $r["sql_field"];
            
           if(array_key_exists($r_field, $_GET))
           {
            $regexp_input = $_GET["$r_field"];
           
            if($regexp_input !="")
            {
               
                $regexp_input = explode(" ",$regexp_input);
                foreach($regexp_input as $rg)
                {
                    $exp[] = clean($rg);
                }
                
                $regexp_input = $exp;
                
                $regexp_input  = array_filter($regexp_input);
              
                if(count($regexp_input) > 1)
                {
                    $regexp_input = implode("|",$regexp_input);
                    echo $regexp_input;
                    //$regexp_input = clean($regexp_input);
                    $regexp_input = rtrim($regexp_input,"|");
                   
                }
                else
                {
                    $regexp_input = $regexp_input[0];
                }
               
              
               
                
            $regexp[] = "$r_sql REGEXP '$regexp_input'";
            }
           }
      }
       }
       else
       {
        $regexp[] = null;
       }
       
       //define between params
       if(isset($params["between"]))
       {
            foreach($params["between"] as $b)
            {
                
                $b_from = $b["GET"];
                $b_to = $b["GET2"];
                $b_sql = $b["sql_field"];
                
                $from = $_GET["$b_from"];
                $to = $_GET["$b_from"];
                
                if(array_key_exists($b_from,$_GET) && array_key_exists($b_to,$_GET))
                {
                    $between[] = "$b_sql BETWEEN '$from' AND '$to'";
                }
            }
            
          
       }
       else
       {
        $between[] = null;
       }
                                             
        //check for empty criteria array
      if(!is_null($criteria))
      {
        $criteria = implode(' AND ', $criteria);
      }
      else
      {
        $criteria = null;
      }
      
      //check for empty regexp array
      if(!is_null($regexp))
      {
         $regexp = implode (' OR ', $regexp);
      }
      else
      {
        $regexp = null;
      }
      
      //check for empty between array
      if(!is_null($between))
      {
         $between = implode(' AND ',$between);
      }
      else
      {
        $between  = null;
      }

        // return data
      $data = array($criteria,$regexp,$between);
      $data = array_filter($data);
      $data = implode(" AND ",$data);
      
      if(!empty($data))
      {
        $sql = "SELECT * FROM $table_name WHERE $data $sql_sort";
      }
      else
      {
        $sql = "SELECT * FROM $table_name ";
      }
      
     
     return $sql;
      
      
}




?>
