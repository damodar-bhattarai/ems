<?php 
	$pdo= new PDO('mysql:host=localhost; dbname=ems','root','');
	
	$ids=[276];
	foreach ($ids as $id) {
	
		$pw = password_hash('Nepal@123', PASSWORD_DEFAULT);
		$query= $pdo->prepare('UPDATE users SET user_pass=:user_pass WHERE user_id=:user_id');
		$data=['user_pass'=>$pw,'user_id'=>$id];
		$query->execute($data); 
	}

 ?>