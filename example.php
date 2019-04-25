 $params = array
(
// select via fixed criteria
   "criteria" =>
    array
    (
         1 => array
        (
            "GET" => "region_id",
            "sql_field" => "property_region",
           
        ),
        2 => array
        (
            "GET" => "cat_id",
            "sql_field" => "category_id",
        ),
    ),
//select via regexp / LIKE , useful for partial matches and keyword search
    "regexp" =>
    array
    (
        1 => array
        (
            "GET" => "keyword",
            "sql_field" => "property_name",
            
        ),
        
        2 => array
        (
            "GET" => "keyword2",
            "sql_field" => "username",
        ),
    ),
    "between" => array
    (
        1 => array
        (
            "GET" => "from_price",
            "GET2" => "to_price",
            "sql_field" => "price",
        ),
    ),

// sort by specific field names in GET 
 "sort" => 
   array
   (
        1 => array
        (
            "GET" => "name_asc",
            "sql_field" => "property_name",
            "order_sql" => "ASC", 
        ),
        2 => array
        (
            "GET" => "name_desc",
            "sql_field" => "property_name",
            "order_sql" => "DESC", 
        ),
        3 => array
        (
            "GET" => "date_desc",
            "sql_field" => "created_at",
            "order_sql" => "DESC", 
        ),
        4 => array
        (
            "GET" => "date_asc",
            "sql_field" => "created_at",
            "order_sql" => "ASC", 
        ),
   ),
    
    
);  

//access the URL 
//test.php?cat_id=2&from_price=33&to_price=122&keyword=something&sort=date_asc
echo gen_query($params,"test_table");
