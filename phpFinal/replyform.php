<?php

    include "connect.php";

    $query = "SELECT * FROM z201607019a WHERE uid = $number";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);


    $my_name = $row['name'];
    $my_subject = $row['subject'];
    $my_comment = $row['comment'];
    $my_fid = $row['fid'];
    $my_thread = $row['thread'];
    

    $my_comment = ":". $my_comment;
    $my_comment = eregi_replace("\n","\n:", $my_comment);
    
    $reply_comment = $my_name ."님의 답글입니다.\n\n" .$my_comment;

?>


<html>
    <body>
        <form name = "signform" method="POST" action = "reply.php?page=<? echo("$page") ?>&fid=<? echo("$my_fid") ?>&thread=<? echo("$my_thread") ?>" >

            이름 : <input type = "text" name = "name" size = "20" maxlength="12"/><br>
            제목 : <input type = "text" readonly name = "subject" size = "50" maxlength = "60" value = "[Re] <? echo("$my_subject") ?>" /><br>
            
            <textarea name="comment" cols="60" rows="10">
            <? echo("$reply_comment") ?>
            </textarea><br>
            
            비밀번호 : <input type = "password" name = "pwd" size = "30" maxlength = "30"><br>
            <p>
            

            <input type = "submit" value = "답변글 쓰기"/>
            <input type = "reset" value = "취 소"/>
        </form>
    
    </body>
</html>