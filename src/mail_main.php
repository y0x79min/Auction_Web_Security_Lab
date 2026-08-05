<?php include("db.php");?>
<?php
	$name="";
	$id="";
	if(isset($_COOKIE["AuctionSession"])){
		$session = $_COOKIE["AuctionSession"];
		
		$sql = "SELECT * FROM sessions WHERE session = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $session);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		if ($row = $result->fetch_assoc()) {
			$id=$row["id"];
			$name=$row["name"];
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
<body style="margin:0 auto;padding:50px">

<div id="popLeft" style="position:relative;width:500px;margin:0 auto;">
	<img style="width:200px"src="/img/logo.png"/>
</div>	
	<br>

<form method="post" id="mailForm" action="/mail_main.php">
	<h1> 옥션 문의 메일 보내기</h1>
	보내는 분: <input  style="width:300px;" id="input_sender" name="name" value="<?php echo $name ?>" disabled/><br>
	받는분 분: <input  style="width:300px;"id="input_reciver" name="name" value="옥션 admin" disabled/><br><br>
	<input id="mail_title" name="mail_title" style="width:400px;" placeholder="메일 제목을 입력해주세요." /><br>
	<textarea id="mail_content" name="mail_content" placeholder="메일 내용을 입력해주세요." style="width:400px;"  rows=25"></textarea><br>
	<button type="submit">전송</button>
</form>




<style>
#mailForm{
	position:relative;
	border: 1px solid;
	margin: 0 auto;
	width:500px;
	height:600px;
	text-align:center;
}
</style>
</html>
<?php
	if($_SERVER['REQUEST_METHOD']==="POST"){
		if($_POST['mail_title']==='') {echo "<script>alert('메일 제목을 입력해주세요.');</script>"; return;}
		if($_POST['mail_content']==='') {echo "<script>alert('메일 내용을 입력해주세요.');</script>"; return;}

		
		if (mysqli_connect_errno())	{	exit;}
		else{
			$stmt = $conn->prepare("INSERT INTO mail ( sender, title, content) VALUES (?,?,?)");
			$stmt->bind_param("sss", $id, $_POST['mail_title'],$_POST['mail_content']);
			$stmt->execute();
			
			echo "<script>alert('메일이 보내졌습니다.');  window.open('','_self').close();</script>"; 
			return;
		}
	}
?>

<?php
    ob_end_flush(); // Flush the output from the buffer
?>

