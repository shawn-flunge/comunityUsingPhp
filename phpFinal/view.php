<html>
<head>
<style>
	table {
    		width: 100%;
   		border-top: 1px solid #858585;
  		border-collapse: collapse;
		font-family : '돋움';
		margin:auto;
  	}

 	th, td {
    		border-bottom: 1px solid #858585;
    		padding: 10px;
  	}

	.divbox {
		width:600px;
		margin:auto;
	}

input::-webkit-input-placeholder { text-align:center; }
input::-moz-placeholder { text-align:center; }
input:-ms-input-placeholder { text-align:center; }
input:-moz-placeholder { text-align:center; }
input::placeholder { text-align:center; }

textarea::-webkit-input-placeholder { text-align:center; }
textarea::-moz-placeholder { text-align:center; }
textarea:-ms-input-placeholder { text-align:center; }
textarea:-moz-placeholder { text-align:center; }
textarea::placeholder { text-align:center; }
</style>
</head>
<body>

<?php

    include "connect.php";

    $query = "SELECT name, subject, comment, signdate, ref, fid, thread FROM z201607019a WHERE uid = $number";
    $result = mysql_query($query);
    
    if(!$result){
        echo mysql_error();
        exit;
    }

    $row = mysql_fetch_array($result);

    $my_subject = $row['subject'];
    $my_name = $row['name'];
    $my_signdate = date('y년 m월 d일 H시 i분 s초', $row['signdate']);
    $my_ref = $row['ref'];
    $my_comment = nl2br($row['comment']);
    $my_fid= $row['fid'];
    $my_thread= $row['thread'];

    // 해당 글에 대한 조회 확인 및 조회 수 확인 루트

    $viewed_query = "SELECT * FROM z201607019b WHERE userip = '$userip' AND uid = $number";
    $viewed_result = mysql_query($viewed_query);
    
    if(!$viewed_result){
        echo mysql_error();
    }


    $viewed_rows = mysql_num_rows($viewed_result);

    
    // 처음에 추천 수가 설정이 되어 있는지를 확인

    if($viewed_rows == 1){

        $viewed_search_query = "SELECT * FROM z201607019b WHERE userip = '$userip' AND uid = $number AND viewed = 0";
        $viewed_search_result = mysql_query($viewed_search_query);
        
        $viewed_search_rows = mysql_num_rows($viewed_search_result);


        if($viewed_search_rows == 1){
            echo($viewed_search_rows);
            $viewed_search_result = mysql_query("UPDATE z201607019b SET viewed = 1 WHERE userip = '$userip' AND uid = $number");


            // 원 글이면 원글 조회수 추가
            if(strlen($my_thread) == 1){   
                $source_update_result = mysql_query("UPDATE z201607019a SET sourceref = sourceref + 1 WHERE fid=$my_fid");
            }
            

            // 만약 원글이 아니여도 해당 글에 대한 조회수 추가 
            $result = mysql_query("UPDATE z201607019a SET ref = $my_ref + 1 WHERE uid = $number");
        }


    }

    // 아예 계정이 해당 글에 대하여 조회한 적이 없다면
    if($viewed_rows == 0){
        $logadd_query = "INSERT INTO z201607019b (userip, uid, viewed) VALUES('$userip', $number, 1)";
        $logadd_result = mysql_query($logadd_query);

        // 원 글이면 원글 조회수 추가
        if(strlen($my_thread) == 1){   
            $source_update_result = mysql_query("UPDATE z201607019a SET sourceref = sourceref + 1 WHERE fid = $my_fid");
        }
        
        // 만약 원글이 아니여도 해당 글에 대한 조회수 추가 
        $result = mysql_query("UPDATE z201607019a SET ref = $my_ref + 1 WHERE uid = $number");
    }


    echo("
  <div class='divbox'>
        <table width = 600>
            <tr>
                <td align=center>
                    $my_subject
                </td>            
            </tr>
            <tr>
                <td style='border:0px; color:#616161; font-size:12px; '>
                    글쓴이 : $my_name
                </td>            
            </tr>
            <tr>
                <td style='color:#616161; font-size:12px; '>
                    올린시간 : $my_signdate
                </td>            
            </tr>
            <tr>
                <td>
                    $my_comment
                </td>            
            </tr>
            <tr>
                <td align=right style='border:0px;'> ");

   if(strlen($my_thread) == 1){
        echo("<a href=\"recommand.php?page=$page&number=$number&userip=$userip\">추천</a> &nbsp;&nbsp;");
    }
    echo("
                    <a href=\"replyform.php?page=$page&number=$number\">답글</a>&nbsp;&nbsp;
                    <a href=\"modifyform.php?page=$page&number=$number\">수정</a>&nbsp;&nbsp;
                    <a href=\"deleteform.php?page=$page&number=$number\">삭제</a>&nbsp;&nbsp;
                </td>            
            </tr>
        
        </table>
        
         <br/>
        <br/>
	<br/>
	<br/>
    ");


$comment_view_count = mysql_query("SELECT count(uid) FROM z201607019c WHERE uid=$number");
		$row = mysql_fetch_array($comment_view_count);
			$my_count = $row['count(uid)'];
     /// 아래 댓글 작성자란과 작성한 댓글이 보이는 란
    echo("
        <form action = \"comment.php\">
	");
	if($my_count >= 1){
		echo("댓글 $my_count 개");
	}else{
		echo("댓글 없음");
	}
	echo("
            <table border=0 width = 600> 
                <tr colspan=2> 
                </tr>
                <tr >
                    <td style='width:20px; border:0px;'>
                        <input type = \"text\" name = \"username\" / placeholder='작성자명' style='width:80px; height:40px;'>
                    </td>
                    <td style='border:0px;'>
                        <textarea rows=2 cols=30 name=\"comment\" placeholder='댓글 내용 추가' style='overflow:hidden; width:400px; height:40px;'></textarea>
                    </td>
		<td style='border:0px;'>
		<input type=\"submit\" value='작성'/ style='width:60px; height:40px; background-color:#0068ff; border:0px; border-radius: 2px; color:white;'>
	        </td>
                </tr>
            </table>
            <input type=\"hidden\" name=\"number\" value = $number />
        </form>
    ");

    $comment_view_result = mysql_query("SELECT * FROM z201607019c WHERE uid=$number");
    
    echo("<table border=0 width=600>");

    while($row = mysql_fetch_array($comment_view_result)){
         $my_signdate = date('y년 m월 d일 H i s', $row['signdate']);
        $my_comment = $row['comment'];
        $my_name = $row['name'];

        echo("
            <tr>
                <td style='width:10%; border:0px;'>
		<h3>$my_name</h3>
                </td>
	<td style='color:#616161; font-size:12px; border:0px;'>
		$my_signdate
	</td>
	</tr>
	<tr>
                <td colspan=2 style='font-size:18px; color:#454545; padding-bottom:20px;'>
		$my_comment
                </td>
            </tr>
        
        ");
    }


    echo("</table>  </br></br></br></br>");



    $result = mysql_query("SELECT * FROM z201607019a WHERE fid=$my_fid and uid !=$number and length(thread) = 1");
    $rows = mysql_fetch_row($result);
    if($rows == 0){

     $result = mysql_query("SELECT * FROM z201607019a WHERE fid=$my_fid and length(thread) >= 2 and uid !=$number ORDER BY thread");

//     $threaded_rows = mysql_num_rows($result);

        echo("관련 목록");
echo ("<table width = 600>");
while($row = mysql_fetch_array($result)){
            $my_uid = $row['uid'];
            $my_subject = $row['subject'];
            $my_name = $row['name'];

     echo("
        <tr>
            <td style='width:20%;'>$my_name</td><td><a href=\"view.php?page=$page&number=$my_uid\">$my_subject</a></td>
        </tr>
         
     ");
}
        echo("</table>");
    
    }else{
        echo("관련 목록");
        echo("<table width = 600>");
        $result = mysql_query("SELECT * FROM z201607019a WHERE fid=$my_fid and length(thread) = 1");
        $row = mysql_fetch_array($result);
        $my_uid = $row['uid'];
        $my_subject = $row['subject'];
        $my_name = $row['name'];
        echo("
            <tr>
                <td style='width:20%;'>$my_name</td><td><a href=\"view.php?page=$page&number=$my_uid\">$my_subject</a></td>
            </tr>
        </table>
        ");
    }

echo("</div>");

?>
</body>
</html>