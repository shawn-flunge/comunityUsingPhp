<?php
include "connect.php";



$query = "select * from z201607019a where uid='$number'";
$result = mysql_query( $query );
if(! $result){
	echo mysql_errno().": ".mysql_error();
	exit;
}
$row = mysql_fetch_array( $result );
    $my_fid = $row['fid'];
	$my_uid = $row['uid'];
	$my_pwd = $row['pwd'];
    $my_thread = $row['thread'];
if(!$row){
	echo $row;
	exit;
}

if($my_pwd != $pwd){
	echo("<script>alert('잘못된 비밀번호를 입력하셨습니다.');</script>");
	echo("<script>history.back();</script>");
	exit;
}



if(strlen($my_thread) == 1){
			$result=mysql_query("delete from z201607019a where fid='$my_fid'");
			if(!$result){
				echo mysql_errno().": ".mysql_error();
				exit;
			}
			echo("$row[subject]게시글이 삭제되었습니다.");
        }else{
            $result=mysql_query("delete from z201607019a where fid='$my_fid' and length(thread) >= length('$my_thread') and thread like('$my_thread%')");
			if(!$result){
				echo mysql_errno().": ".mysql_error();
				exit;
			}
			echo("$row[subject]게시글이 삭제되었습니다.");   
        }

	echo("2초뒤 돌아갑니다.");
	echo("<meta http-equiv='Refresh' content='2; URL=rboard.php?page=$page'>");

?>