<?php
    include "connect.php";
    $query = "SELECT thread, right(thread, 1)  
                FROM z201607019a
                WHERE fid = $fid AND length(thread) = length('$thread') + 1 AND locate('$thread', thread) = 1
                ORDER BY thread DESC LIMIT 1";


    $result = mysql_query($query);

    $rows = mysql_num_rows($result);

    $row = mysql_fetch_row($result);

    if($rows){
        
        $t_head = substr($row[0], 0, -1);
        $t_foot = ++$row[1];
        
        $new_thread = $t_head . $t_foot;
        
        
    }else{
        $new_thread = $thread . "A";
    }
    $query = "SELECT sourceref, sourcelikecnt FROM z201607019a WHERE fid = $fid AND length(thread) = 1";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    $sourceref = $row['sourceref'];
    $sourcelikecnt = $row['sourcelikecnt'];


    $signdate = time();
    


    $query = "INSERT INTO z201607019a (fid, name, subject, comment, pwd, signdate, ref, likecnt, thread, sourceref, sourcelikecnt) 
            VALUES ($fid, '$name', '$subject','$comment','$pwd','$signdate', 0 , 0 ,'$new_thread', $sourceref, $sourcelikecnt)";
        
    $result = mysql_query($query);

    if(!$result){
        echo("query error");
        exit;
    }

    echo("<meta http-equiv='Refresh' content='0; URL=rboard.php?page=$page'>");