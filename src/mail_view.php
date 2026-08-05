<?php include("db.php");?>
<html>

<body>
	<div id="popLeft" style="position:relative;width:500px;border:0">
		<img style="width:200px"src="/img/logo.png"/>
		<h1 style="display: contents;">&nbsp; 옥션 관리자 메일</h1>
	</div>	

	
	<button onclick='document.location = "/mail_list.php";'>돌아가기</button>
	
</body>


</html>

<?php
	$isAdmin = 0;
	if(isset($_COOKIE["AuctionSession"])){
		$session = $_COOKIE["AuctionSession"];
		$sql = "SELECT * FROM sessions WHERE session = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $session);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		if ($row = $result->fetch_assoc()) {
			$sql = "SELECT * FROM users WHERE id = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("s", $row["id"]);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			if ($row = $result->fetch_assoc()) {
				$isAdmin = $row['isAdmin'];
				
				$sql = "SELECT * FROM mail WHERE no = '".$_GET["no"]."'";
				$result = mysqli_query($conn, $sql);
				$row2 = mysqli_fetch_array($result);
				
				$title = $row2['title'];
				$title = strip_tags($title);
				$sender = $row2['sender'];
				$content = $row2['content'];
				$content = strip_tags($content,"<img>");
				$content = str_ireplace ("on","0n",$content);
				$time = $row2['time'];
				
				echo '<div><strong>제목:  </strong>'.$title.'</div>'.
				'<div><strong>보낸이:  </strong>'.$sender.' <span style="float:right"><strong>시간: </strong>'.$time.'</span></div>'.
				'<div style="padding:10px;height:500px"><pre style="white-space: break-spaces;">'.$content.'</pre></div>';
	
				}
		}
		else{
			header("Location: /login.php");
			return;
		}
		
	}
	else{
		header("Location: /login.php");
		return;
	}
	if($isAdmin==0){header("Location: /");return;};
?>




<style>

 div{
	 border: 1px solid green;
 }
 
</style>





<?php
	if ($isAdmin==1){
		
		$sql = "SELECT * FROM mail ORDER BY time DESC";
		$result_set = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_array($result_set)){
			$onclick = "&quot;/mail_view.php?no=".$row['no']."&quot;";
			$title = $row['title'];
			$title = str_replace("<", "&lt;",$title);
			
			$text = "<tr onclick='document.location=".$onclick."'><td style='width:10%'>".$row['sender']."</td> <td style='width:60%'>".$title."</td> <td style='width:30%'>".$row['time']."</td></tr>";
			echo "<script>document.querySelector('.table').innerHTML +=\"" .$text."\"</script>";
		}
		
	}
	else header("Location: /");
	
	
	
?>





<?php
    ob_end_flush(); // Flush the output from the buffer
?>
