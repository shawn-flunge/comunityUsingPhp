<?php
include "connect.php";
$query = "select * from z201607019a where uid = $number";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

$my_name = $row['name'];
$my_subject = $row['subject'];
$my_comment = $row['comment'];
$my_uid = $row['uid'];
?>


<html>
<body>
	<form method = "post" action = "modify.php?page=<? echo("$page")?>&subject=<? echo("$my_subject")?>&comment=<? echo("$my_comment")?>&uid=<? echo("$my_uid")?>" enctype=multipart/form-data>
		이름 : <? echo ("$my_name") ?><br>
		제목 : <input type = "text" name = "subject" value = '<? echo ("$my_subject") ?>'><br>
		<textarea name = "comment" cols = "60" rows = "10">
			<? echo ("$my_comment") ?>
		</textarea><p>
		비밀번호 : <input type = "password" name = "pwd" />

		<input type = "submit" value = "수정하기">
		<input type = "reset" value = "취소">
	</form>
</body>
</html>