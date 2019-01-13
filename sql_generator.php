<?php
//generate dynamic query php 

$params = array
(
   "sort" => 
   array
   (
        1 => array
        (
            "GET" => "name_asc",
            "sql_field" => "last_name",
            "order_sql" => "ASC", 
        ),
        2 => array
        (
            "GET" => "name_desc",
            "sql_field" => "last_name",
            "order_sql" => "DESC", 
        ),
   ),
   
    "criteria" =>
    array
    (
         1 => array
        (
            "GET" => "user_rank",
            "sql_field" => "rank",
           
        ),
        2 => array
        (
            "GET" => "status",
            "sql_field" => "status",
            
        ),
    ),
    
    
);
function gen_query($params,$table_name)
{
       
       //defining sort order
       
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
            elseif($_GET["sort"] == "")
            {
                $sql_sort = "";
            }
            else
            {
                $sql_sort = "";
            }
            }
            else
            {
                $sql_sort = "";
            }
            
       }
       
       foreach($params["criteria"] as $c)
       {
        $c_field = $c["GET"];
        $c_sql = $c["sql_field"];
           
           if(array_key_exists($c_field, $_GET))
           {
            $criteria_input = $_GET["$c_field"];
            
            $criteria[] = "$c_sql = '$criteria_input'";
           }
          
       }
      
      if(!empty($criteria))
      {
      $criteria = implode(' AND ', $criteria);
      $sql = "SELECT from $table_name WHERE $criteria $sql_sort";
      }
      else
      {
        $criteria = "";
        $sql = "SELECT * FROM $table_name $sql_sort";
      }
      
     
     return $sql;
      
      
}
//usage
//the only $_GET value that is hardcoded is the sort parameter
//looks like this yoursite.com/index.php?sort=name_desc&user_rank=1&status=active
echo gen_query($params,"users");
?>
