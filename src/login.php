<?php include("db.php");?>

<html>
<body style="width:300px; margin:0 auto;padding:100px">
<a href="/main.php">
<div id="popLeft" style="position:relative;width:200px;">
<img style="width:70%"src="/img/logo.png"/>
</div>	
</a>
<form id="loginForm" method="post" action="login.php">
	<h1> 옥션 로그인</h1>
	<span>ID</span><br>
	<input type="text" name="id" placeholder="아이디"><br>
	<span>PW</span><br>
	<input type="password" name="pw" placeholder="비밀번호"><br>
	<br>
	<button class="button button-login" type="submit">로그인</button><br>
	<a style="position:absolute;bottom:1px;" href="/signup.php">계정이 없으신가요? 회원가입 하러 가기</a>
</form>



<style>
#loginForm{
	position:relative;
	border: 1px solid;
	margin: 0 auto;
	width:300px;
	height:600px;
	text-align:center;
}
</style>
</html>
<?php include("db.php");?>
<?php
	if($_SERVER['REQUEST_METHOD']==="POST"){
		
		if($_POST['id']==='') echo "<script>alert('아이디를 입력해주세요.');</script>";
		else{
			if($_POST['pw']==='') echo "<script>alert('비밀번호를 입력해주세요.');</script>";
			else{
				
				if (mysqli_connect_errno())	{exit;}
				else{
					
					$sql = "SELECT * FROM users WHERE id = ? and pw = ?";
					$stmt = $conn->prepare($sql);
					$mdpw = md5($_POST['pw']);
					$stmt->bind_param("ss", $_POST['id'], $mdpw);
					$stmt->execute();
					$result = $stmt->get_result();
					$stmt->close();
					if ($row = $result->fetch_assoc()) {
						srand((double)microtime()*1000000); 
						$session_id = md5(uniqid(rand())); 
						
						$sql = "INSERT INTO sessions (session, id, name, time) VALUES (?,?,?,?)";
						$stmt = $conn->prepare($sql);
						$time = (time() + 36000) ;
						$stmt->bind_param("ssss", $session_id, $row['id'], $row['name'], $time);
						$stmt->execute();
						$result = $stmt->get_result();
						$stmt->close();
					
						setcookie("AuctionSession", $session_id, $time, "/");
						header("Location: /");
						
					}
					else{
						echo "<script>alert('로그인 정보가 일치하지 않습니다.');</script>";
					}
				}

			}
		}
			
	}
?>

<?php
    ob_end_flush(); // Flush the output from the buffer
?>


