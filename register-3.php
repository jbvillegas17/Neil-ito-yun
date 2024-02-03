<?php
session_start();

include_once("connection.php");

$con = connection();

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['submit'])) {
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $email = validate($_POST['email']);

    // Password verification
    if (strlen($password) < 8 || !preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]{2,}/", $password)) {
  		
        header("Location: register.php?error=Password must be at least 8 characters long, contain at least one uppercase letter, and have at least two numbers.");
        exit();
    }

    // Confirm password
    $confirmPassword = validate($_POST['confirm_password']);
    if ($password !== $confirmPassword) {
        header("Location: register.php?error=Passwords do not match");
        exit();
    }else{

    $sql = "INSERT INTO `user`(`email`,`username`,`password`) VALUES('$email','$username','$password')";
    $db = $con->query($sql) or die($con->error);

    echo "<script>alert('Registration successful');</script>";
    echo header("Location: login.php");
    exit();
}
}
?>

?>
<html>
<head>
	<title>Log In</title>
	

	<link rel="icon" type="image/x-icon" href="pic/Logo.png">	

</head>
<style type="">
	
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		font-family: "Poppins", sans-serif;
	}
	body {
		display: flex;
		justify-content: center;
		align-items: center;
		min-height: 100vh;

		background: url('pic/bg.png') no-repeat;
		background-size: cover;
		background-position: center;
	}
	.wrapper {
		width: 700px;
		height: 840px;
		background: linear-gradient(to right, rgba(0, 0, 255, 0.6), rgba(255, 255, 255, 0.9));
		box-shadow: 0 0 10px rgba(0, 0, 0, -2);
		color: #fff;
		border-radius: 70px;
		padding: 30px 40px;
	
	}

	.wrapper form {
		margin-top: -640px;
		opacity: 99%;
	}
	#logo {
		width: 600px;
		height: 600px; 
		margin-top: 30px;
		margin-left: 30px;
		opacity: 30%;

	}
	.wrapper .input-box {
		position: relative;
		width: 100%;
		height: 90px;
		margin: 30px 0;
	}
	.input-box input {
		width: 100%;
		height: 100%;
		background: transparent;
		border: 6px solid white;
		outline: none;
		font-weight: 600;
		border-radius: 60px;
		font-size: 32px;
		color: white;
		padding: 20px 45px 20px 20px;
	}
	.input-box input::placeholder {
		color: white;
	}

	.input-box i {
		position: absolute;
		right: 20px;
		top: 50%;
		transform: translateY(-50%);
		font-size: 100px;
	}
	
	.wrapper .btn {
		width: 100%;
		height: 80px;
		background: blue;
		border: none;
		outline: none;
		border-radius: 40px;
		box-shadow: 0 0 10px rgba(0, 0, 0, -1);
		cursor: pointer;
		font-size: 35px;
		color: white;
		font-weight: 600;
	}
	.wrapper .register-link {
		font-size: 25px;
		text-align: center;
		margin: 20px 0 15px;
		color: blue;
		font-weight: 600;
	}
	.register-link p a {
		color: blue;
		text-decoration: none;
		font-weight: 900;
	}
	.register-link p a:hover {
		text-decoration: underline;
	}
	.error {
		background: white;
		color: red;
		padding: 10px;
		width: 100%;
		border-radius: 15px;
		font-size: 25px;
		opacity: 90%;
		justify-content: center;
		align-items: center;
	}
	
	.user { 
		position: absolute;
		top: 50%;
		right: 30px;
		transform: translateY(-50%);
		width: 45px;
		height: 50px;
		

	 }
	 .input-box {
	 	position: relative;
	 }
	  #emailInput.valid {
         background-color: green;
    }

      #emailInput.invalid {
      
      background-color: red;
    }

</style>
<body>
	
	<div class="wrapper">
		<img src="pic/AULOGO.png" id="logo">
		<form action="" method="post">
			<?php if(isset($_GET['error'])){?>
				<p class="error"><?php echo $_GET['error'];?></p>
			<?php } ?></br>
			<div class="input-box">
				<input type="text" placeholder="Username" name="username" required>
				<img src="pic/user.png" class="user">
			</div>
			<div class="input-box">
				<input type="text" placeholder="Email" name="email" id="emailInput">
				<img src="pic/email.png" class="user">
			</div>
			<div class="input-box">
				<input type="password" placeholder="Password" class="password" name="password" required>
				
			</div>
			<div class="input-box">
				<input type="password" placeholder="Confirm Password" class="password" name="confirm_password" required>
				
			</div></br>
			
			<button type="submit" class="btn" name="submit" onclick="validateEmail()">Register</button></br></br>
			<div class="register-link">
				<p>Have an account? <a href="login.php">Log in Here</a></p>
			</div>

		</form>
	</div>
<script type="">
	function validateEmail() {
      const emailInput = document.getElementById('emailInput');
      const emailValue = emailInput.value;

      // Basic email validation regex
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (emailRegex.test(emailValue)) {
        emailInput.classList.remove('invalid');
        emailInput.classList.add('valid');
      } else {
        emailInput.classList.remove('valid');
        emailInput.classList.add('invalid');
      }
    }

	   document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.querySelector('input[name="password"]');
            const confirmPasswordInput = document.querySelector('input[name="confirm_password"]');
            const submitButton = document.querySelector('button[name="submit"]');

            confirmPasswordInput.addEventListener('input', function () {
                const confirmPasswordValue = confirmPasswordInput.value;
                const passwordValue = passwordInput.value;

                if (confirmPasswordValue === passwordValue) {
                    confirmPasswordInput.style.background = 'green';
                    submitButton.disabled = false;
                } else {
                    confirmPasswordInput.style.background = 'red';
                    submitButton.disabled = true;
                }
            });
        });

</script>
</html>