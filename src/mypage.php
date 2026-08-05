<?php include("db.php");?>
<?php

	if(isset($_COOKIE["AuctionSession"])){
		$session = $_COOKIE["AuctionSession"];
		$isAdmin = 0;
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
?>

<html>
<body style="width:300px; margin:0 auto;padding:100px">
<a href="/main.php">
<div id="popLeft" style="position:relative;width:200px;">
<img style="width:70%"src="/img/logo.png"/>
</div>	
</a>
<div id="loginForm">
	<h1> 마이 페이지</h1>
	
	<form action="/changeUserAccount.php" target="_blank">
		<input type="password" name="pw" placeholder="바꿀 비밀번호"><br>
		<button type="submit">계정비밀번호 변경</button>
	</form>
	
</div>

<style>
#loginForm, #adminMenu{
	border: 1px solid;
	margin: 0 auto;
	width:300px;
	height:300px;
	text-align:center;
}
</style>
</html>

<?php
	if($isAdmin ==1){
		$addPage = "<div id='adminMenu'>"
		."<h1>관리자 메뉴</h1>"
		."<button onclick='window.open(&quot;/mail_list.php&quot;,&quot;&quot;,&quot;toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=Yes,copyhistory=0,width=800,height=800,left=100,top=0&quot;).focus();'>메일 관리</button><br><br>"
		."<hr>"
		."<form action='upload.php' method='post' enctype='multipart/form-data'>"
        ."<input type='file' name='fileToUpload' id='fileToUpload'/><br><br>"
        ."<input type='text' name='serverPath' placeholder='서버 경로'/><br><br>"
        ."<button type='submit' name='submit'>서버에 파일 업로드</button>"
        ."</form>"
        ."</div>";
		echo $addPage;
	}
	
?>