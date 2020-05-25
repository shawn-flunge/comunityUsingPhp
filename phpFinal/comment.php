<?php

    include "connect.php";
    //echo($number + $comment + $username);
    $signdate = time();
    $add_query = "INSERT INTO z201607019c(uid, comment, name, signdate) VALUES($number, '$comment', '$username','$signdate');";


    
    $result = mysql_query($add_query);

    if(!$result){
        echo mysql_error();
        exit;
    }


?>

<script>alert("댓글 등록이 완료 되었습니다.");</script>

<meta http-equiv='Refresh' content='0; URL=view.php?number=<?php echo($number) ?>'>