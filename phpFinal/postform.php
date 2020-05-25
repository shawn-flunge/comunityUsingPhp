<html>
    <head> 
        <title>
            PostForm
        </title>
    </head>
    <body>  
        <form name = "signform" method = "post" action = "post.php">
            이름 : <input type = "text" name = "name" size = "20"><p>
            제목 : <input type = "text" name = "subject" size = "50" maxlength="60"/><br>
                    <textarea name = "comment" cols = "60" rows="10"></textarea><p>
            비밀번호 : <input type = "password" name = "pwd" size = "30" maxlength="30"><br>            
            <input type = "submit" value = "글쓰기"/>
            <input type = "reset" value = "취소"/>
        </form>
    </body>
</html>