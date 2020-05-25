<?php

include "connect.php";


    // 해당 글에 대한 조회 확인 및 조회 수 확인 루트

    $liked_query = "SELECT * FROM z201607019b WHERE userip = '$userip' AND uid = $number";
    $liked_result = mysql_query($liked_query);
    
    if(!$liked_result){
        echo mysql_error();
    }

    $liked_rows = mysql_num_rows($liked_result);
    

    if($liked_rows == 1){

        $liked_search_query = "SELECT * FROM z201607019b WHERE userip = '$userip' AND uid = $number AND liked = 0";
        $liked_search_result = mysql_query($liked_search_query);
        
        $liked_search_rows = mysql_num_rows($liked_search_result);


        if($liked_search_rows == 1){
            $liked_search_result = mysql_query("UPDATE z201607019b SET liked = 1 WHERE userip = '$userip' AND uid = $number");


            // 원 글이면 원글 추천수 추가
            if(strlen($my_thread) == 1){   
                $source_update_result = mysql_query("UPDATE z201607019a SET sourcelikecnt = sourcelikecnt + 1 WHERE fid=$my_fid");
            }
            

            // 만약 원글이 아니여도 해당 글에 대한 조회수 추가 
            $result = mysql_query("UPDATE z201607019a SET ref = $my_likecnt + 1 WHERE uid = $number");

            echo("<script>alert(\"해당 글을 추천 하셨습니다.\")</script>");
            
            $query = "SELECT * FROM z201607019a WHERE uid = $number";
            $result = mysql_query($query);
            
            if(!$result){
                echo mysql_error();
                exit;
            }
        
            $row = mysql_fetch_array($result);
        
            $my_likecnt = $row['likecnt'];
        
            $result = mysql_query("UPDATE z201607019a SET likecnt = $my_likecnt + 1 WHERE uid = $number");

           
        }else{
            echo("<script>alert(\"이미 해당 글에 대하여 추천하셨습니다.\")</script>");
        }

    }

    if($liked_rows == 0){
        $logadd_query = "INSERT INTO z201607019b (userip, uid, liked) VALUES('$userip', $number, 1)";

        $logadd_result = mysql_query($logadd_query);

        // 원 글이면 원글 추천수 추가
        if(strlen($my_thread) == 1){   
            $source_update_result = mysql_query("UPDATE z201607019a SET sourcelikecnt = sourcelikecnt + 1 WHERE fid=$my_fid");
        }
        

        // 만약 원글이 아니여도 해당 글에 대한 조회수 추가 
        $result = mysql_query("UPDATE z201607019a SET ref = $my_likecnt + 1 WHERE uid = $number");

        echo("<script>alert(\"해당 글을 추천 하셨습니다.\")</script>");


        $query = "SELECT * FROM z201607019a WHERE uid = $number";
        $result = mysql_query($query);
        
        if(!$result){
            echo mysql_error();
            exit;
        }
    
        $row = mysql_fetch_array($result);
    
        $my_likecnt = $row['likecnt'];
    
        $result = mysql_query("UPDATE z201607019a SET likecnt = $my_likecnt + 1 WHERE uid = $number");

        
    }

    
    

    echo("<meta http-equiv='Refresh' content='0; URL=rboard.php'>");

    
    
?>


