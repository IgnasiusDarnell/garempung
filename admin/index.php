<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Admin Login Page">
	<meta name="author" content="Dashboard">
	<title>Login To Admin</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	<style>
		body {
			background-color: #004643;
			color: #fff;
			font-family: 'Arial', sans-serif;
		}

		.login-container {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}

		.login-form {
			background-color: rgba(255, 255, 255, 0.1);
			padding: 2rem;
			border-radius: 10px;
			box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
			width: 100%;
			max-width: 400px;
		}

		.login-form h2 {
			text-align: center;
			margin-bottom: 1.5rem;
			color: #fffffe;
		}

		.form-control {
			background-color: rgba(255, 255, 255, 0.2);
			border: none;
			color: #fffffe;
			margin-bottom: 1rem;
		}

		.form-control::placeholder {
			color: #abd1c6;
		}

		.btn-primary {
			background-color: #f9bc60;
			border: none;
			color: #001e1d;
			font-weight: bold;
		}

		.btn-primary:hover {
			background-color: #e16162;
		}
	</style>
</head>

<body>
	<?php
	session_start();
	if (isset($_POST['proses'])) {
		require '../config.php';

		$user = strip_tags($_POST['user']);
		$pass = strip_tags($_POST['pass']);

		$sql = 'SELECT member.*, login.username, login.password
            FROM member INNER JOIN login ON member.id_member = login.id_member
            WHERE username = ?';
		$row = $config->prepare($sql);
		$row->execute([$user]);
		$result = $row->fetch();

		if ($result && $result['password'] === $pass) { // Direct password comparison (not secure)
			$_SESSION['admin'] = $result;
			echo '<script>alert("Login Sukses");window.location="./product/index.php"</script>';
		} else {
			echo '<script>alert("Login Gagal");history.go(-1);</script>';
		}
	}
	?>
	<div class="login-container">
		<div class="login-form">
			<h2>Admin Login</h2>
			<form method="POST">
				<div class="mb-3">
					<input type="text" class="form-control" name="user" placeholder="User ID" required autofocus>
				</div>
				<div class="mb-3">
					<input type="password" class="form-control" name="pass" placeholder="Password" required>
				</div>
				<button class="btn btn-primary w-100" name="proses" type="submit">
					<i class="fas fa-lock me-2"></i> Sign In
				</button>
			</form>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>