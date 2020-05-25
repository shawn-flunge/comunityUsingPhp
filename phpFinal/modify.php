<?php
include "connect.php";


	$query = "select * from z201607019a where uid='$uid' AND pwd='$pwd'";
	$result = mysql_query( $query );
	if(! $result){
		echo mysql_errno().": ".mysql_error();
		exit;
	}

	$rows = mysql_num_rows($result);

	if(!$rows){
		echo("<script>alert('잘못된 비밀번호를 입력하셨습니다.');</script>");
		echo("<script>history.back();</script>");
		exit;
	}

	$query = "UPDATE z201607019a SET subject = '$subject', comment = '$comment' WHERE uid = '$uid'";
	$result = mysql_query($query);	

if(!$result){
	echo mysql_errno().": ".mysql_error();
	exit;
}
echo("<meta http-equiv='Refresh' content='0; URL=rboard.php?page=$page'>");
?>