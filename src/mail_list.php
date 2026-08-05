<?php include("db.php");?>
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
	if($isAdmin==0){header("Location: /");return;}
?>

<html>

<body>
	<div id="popLeft" style="position:relative;width:500px;">
		<img style="width:200px"src="/img/logo.png"/>
		<h1 style="display: contents;">&nbsp; 옥션 관리자 메일</h1>
	</div>	

	<div style="margin:auto; width:100%;height:100%;">
		<div style="overflow-y: scroll; max-height: 50%;">
			<table border=1 style="width:100%;" class='table'>
			<th> 작성자 </th><th> 제목 </th><th> 날짜 </th>
			
			</table>
		</div>
	</div>
	
</body>


</html>


<style>

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-size: 16px;
}

.table th {
    background-color: #4CAF50; 
    color: #fff; 
    padding: 10px;
	
}
.table tr{
	cousor:pointer;
	
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
