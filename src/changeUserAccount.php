<?php include("db.php");?>
<?php

	if(isset($_COOKIE["AuctionSession"])){
		$session = $_COOKIE["AuctionSession"];
		
		$sql = "SELECT * FROM sessions WHERE session = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $session);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		if ($row = $result->fetch_assoc()) {
			if(isset($_GET["pw"])){
				
				$sql = "UPDATE users SET pw = ? WHERE id=?";
				$stmt = $conn->prepare($sql);
				$md5pw = md5($_GET['pw']);
				$stmt->bind_param("ss", $md5pw,$row["id"]);
				$stmt->execute();
			}
			echo "<script>alert('비밀번호 변경이 완료되었습니다.');</script>";
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
#loginForm{
	border: 1px solid;
	margin: 0 auto;
	width:300px;
	height:600px;
	text-align:center;
}
</style>
</html>
