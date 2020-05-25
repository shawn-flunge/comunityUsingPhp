<!DOCTYPE html>
<html>
<head>
<style>

	.totalstyle {
		width:100%;
		text-align:center;
	}

	.totalmenustyle {
		width:50%;
		display:inline-block;
	}

	.leftmenustyle {
		width:50%;
		text-align:left;
		float:left;
	}
	.rightmenustyle {
		width:50%;
		text-align:right;
		float:right;
	}

	table {
    		width: 50%;
   		border-top: 1px solid #444444;
  		border-collapse: collapse;
		text-align:center;
		margin:auto;
  	}
 	th, td {
    		border-bottom: 1px solid #444444;
    		padding: 10px;
  	}
</style>
</head>
<body>


<div class='totalstyle'>
	<div class='totalmenustyle'>
		<div class='leftmenustyle'>
		   <select id = "sorttype" onchange="location.href=this.value">
                   <option selected>정렬</option>
                    <option value="rboard.php?sorttype=최신순">최신순</option>
                    <option value="rboard.php?sorttype=추천순">추천순</option>
		           <option value="rboard.php?sorttype=조회순">조회순</option>
		   </select> 
		   <?php
    if(! $sorttype){
	echo("최신순");
	}else{
            echo("$sorttype");
    	}
            ?>
		</div>
		<div class='rightmenustyle'>
			<a href="postform.php">글올리기</a>
		</div>

	</div>
	
	

<?php
    include "connect.php";

     $userip = $_SERVER["REMOTE_ADDR"];
    // 사용자의 IP 를 설정
    

    $query = "SELECT count(uid) FROM z201607019a";
    $result = mysql_query($query);

    $total_record = mysql_result($result, 0,0);

    if($total_record == 0){
        echo("답변형 게시판 항목이 없습니다.");
        exit;
    }
    

    
    $num_per_page = 10;
    $page_per_block = 3;
    $total_page = ceil($total_record / $num_per_page);
    $total_block = ceil($total_page / $page_per_block);

    // 아래 페이지에서 사용할 블록 수 계산

    if(! $page){
        $page = 1;
    }

    $first = $num_per_page * ($page-1);
    $block = ceil($page / $page_per_block);
    $first_page = ($block-1) * $page_per_block;
    $last_page = $block * $page_per_block;

    if($block >= $total_block){
        $last_page = $total_page;
    }

   
    
    
    $article_num = $total_record - $num_per_page * ($page -1);
    // 페이지 내 일련번호값
    echo("
        <table>
            <tr>
                <th>
                    번호
                </th>
                <th>
                    제목
                </th>
                <th>
                    글쓴이
                </th>
                <th>
                    작성일
                </th>
                <th>
                    조회수
                </th>
                <th>
                    추천수
                </th>

            </tr>
    ");


     if($sorttype == "최신순" || $sorttype == ""){
        $article_result = mysql_query("SELECT * FROM z201607019a ORDER BY  fid DESC, thread ASC LIMIT $first, $num_per_page");
    }else if($sorttype == "추천순"){
        $article_result = mysql_query("SELECT * FROM z201607019a ORDER BY  sourcelikecnt DESC, fid DESC,  thread ASC  LIMIT $first, $num_per_page");
    }else{
        $article_result = mysql_query("SELECT * FROM z201607019a ORDER BY  sourceref DESC, fid DESC,  thread ASC LIMIT $first, $num_per_page");
        //$article_result = mysql_query("SELECT * FROM r201607019 ORDER BY ref DESC LIMIT $first, $num_per_page");
    }
    

    while($row = mysql_fetch_array($article_result)){
        $my_uid = $row['uid'];
        $my_subject = $row['subject'];
        $my_name = $row['name'];
        $my_signdate = date("y년 m월 d일 H시 i분 s초", $row['signdate']);
        $my_ref = $row['ref'];
        $my_likecnt = $row['likecnt'];
        $my_thread = $row['thread'];
        
        

        echo("
            <tr>
                <td>
                    $article_num
                </td>
                <td style='text-align:left;'>
            ");
                $sp = strlen($my_thread) -1;
                for($j = 0; $j < $sp; $j++){
                    echo("&nbsp;&nbsp;&nbsp;&nbsp;");
                }
        echo("
                    <a href = \"view.php?page=$page&number=$my_uid&userip=$userip\">$my_subject</a>
                </td>
                <td>
                    $my_name
                </td>
                <td>
                    $my_signdate
                </td>
                <td>
                    $my_ref
                </td>
                <td>
                    $my_likecnt
                </td>
            </tr>
        
            ");
        $article_num--;

    }
    
    echo("
        </table>
        <br/>
        <br/>
        ");


        if($block > 1){
            $my_page = $first_page;
            echo("<a href=\"rboard.php?page=$my_page&sorttype=$sorttype\">[이전]</a>");
        }else{
            echo("[이전] ");
        }
        
    
        for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++){
            if($page == $direct_page){
                echo("<b>[$direct_page]</b>");
            }else{
                echo("<a href=\"rboard.php?page=$direct_page&sorttype=$sorttype\">[$direct_page]</a>");
            }
        }
    
        if($block < $total_block){
            $my_page = $last_page+1;
            echo("<a href=\"rboard.php?page=$my_page&sorttype=$sorttype\">[다음]</a>");
        }else{
            echo(" [다음]");
        }
    
    ?>
</div>
</body>
</html>