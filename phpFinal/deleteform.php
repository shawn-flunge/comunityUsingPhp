<html>
<script type="text/javascript">
	function button_event(){
		if (confirm("정말 삭제하시겠습니까??") == true)
		{
			
 			document.form.submit();
		}
		else
		{  
   			return;
		}
	}
</script>
<body>
<form name="form" method="post" action = "delete.php">
	<h1>게시물을 삭제합니다.</h1>
	<input type=hidden name="number" value=<?php echo $number ?>>
	<input type=hidden name="page" value=<?php echo $page ?>>
	<br>

	비밀번호 : <input type="password" name="pwd"/>
	<input type="button" value="글 삭제" onclick="button_event();">

</form>
</body>
</html>

