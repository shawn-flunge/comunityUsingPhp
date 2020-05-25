<?php
    include "connect.php";
    $query = "select max(fid) from z201607019a";
    $result = mysql_query($query);
    $row = mysql_fetch_row($result);

    if($row[0]){
        $new_fid = $row[0] + 1;
        
    }else{
        $new_fid = 1;
    }

    
    $signdate = time();

    $query = "INSERT INTO z201607019a (fid, name, subject, comment, pwd, signdate, ref, likecnt, thread, sourceref, sourcelikecnt) VALUES ($new_fid,'$name','$subject','$comment','$pwd',$signdate,0,0,'A', 0, 0)";
    $result = mysql_query($query);
    
    if(!$result){
        echo mysql_error();
        exit;

    }

    echo("<meta http-equiv='Refresh' content='0; URL=rboard.php'>");
    
?>