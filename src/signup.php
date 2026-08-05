



<html>
<body style="width:300px; margin:0 auto;padding:100px">
<a href="/main.php">
<div id="popLeft" style="position:relative;width:200px;">
<img style="width:70%"src="/img/logo.png"/>
</div>	
</a>

<form method="post" id="loginForm" action="/signup.php">
	<h1> 옥션 회원가입</h1>
	<span>아이디</span><br>
	<input type="text" name="id" placeholder="아이디"><br><br>
	<span>비밀번호</span><br>
	<input type="password" name="pw" placeholder="비밀번호"><br><br>
	<span>비밀번호 확인</span><br>
	<input type="password" name="pw-re" placeholder="비밀번호 확인"><br><br><br>
	<span>이름</span><br>
	<input type="text" name="name" placeholder="ㅇㅇㅇ"><br><br>
	<span>전화번호</span><br>
	<input type="text" name="phone" placeholder="010-0000-0000"><br>
	<br>
	<button class="button button-signup" type="submit">회원가입</button><br>
	<a style="position:absolute;bottom:1px;" href="/login.php">계정이 있으신가요? 로그인 하러 가기</a>
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
		if($_POST['id']==='') {echo "<script>alert('아이디를 입력해주세요.');</script>"; return;}
		if($_POST['pw']==='') {echo "<script>alert('비밀번호를 입력해주세요.');</script>"; return;}
		if($_POST['pw-re']==='') {echo "<script>alert('비밀번호 재확인을 입력해주세요.');</script>"; return;}

		
		if($_POST['name']==='') {echo "<script>alert('이름을 입력해주세요.');</script>"; return;}
		if($_POST['phone']==='') {echo "<script>alert('전화번호를 입력해주세요.');</script>"; return;}
		
		

		if( !($_POST['pw'] === $_POST['pw-re']) ) {echo "<script>alert('비밀번호가 일치하지 않습니다.');</script>"; return;}
		
		
		if (mysqli_connect_errno())
		{
			exit;
		}else{
			$stmt = $conn->prepare("SELECT * FROM users WHERE id = ? ");
			$stmt->bind_param("s", $_POST['id']);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			if ($row = $result->fetch_assoc()) {
				echo "<script>alert('이미 존재하는 아이디 입니다.');</script>"; return;
			}
			
			$stmt = $conn->prepare("INSERT INTO users ( id, pw, name, phone) VALUES (?,?,?,?)");
			$mdpw = md5($_POST['pw']);
			$stmt->bind_param("ssss", $_POST['id'], $mdpw, $_POST['name'],$_POST['phone']);
			$stmt->execute();
			
			echo "<script>alert('회원가입이 완료되었습니다.');</script>"; 
			return;
		}
	}
?>

<?php
    ob_end_flush(); // Flush the output from the buffer
?>

