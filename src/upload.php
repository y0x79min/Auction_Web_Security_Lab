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
	if($isAdmin==0){header("Location: /"); return;};
?>
<?php

	$target_dir = isset($_POST['serverPath']) ? $_POST['serverPath'] : "/";

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_POST["submit"])) {
		// 파일 업로드 
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			
			echo "<script>alert('파일 ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " 이 업로드되었습니다.'); </script>"; 
			
			echo "<script> location.replace('/mypage.php')</script>";
			
		} else {
			echo "<script>alert('파일 업로드 오류.'); </script>"; 
			echo "<script> location.replace('/mypage.php')</script>";
		}
	
    }
?>