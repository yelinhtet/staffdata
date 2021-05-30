<?php  //Start the Session
    include("config.php");
    session_start();
    if (isset($_POST['username']) and isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM admin_tbl WHERE admin_name = '".$_POST['username']."' and admin_password = '".$_POST['password']."'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
        if($count == 1){  
            $_SESSION['login_user'] = $username;
            header("location: home.php");
        }  
        else{
        	$_SESSION["error"]="Login invalid";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	    <title>1000DC</title>
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	   	<style type="text/css">
	   		 <style>
	         body {
	            padding-top: 40px;
	            padding-bottom: 40px;
	            background-color: #ADABAB;
	         }
	         
	         .form-signin {
	            max-width: 330px;
	            padding: 10px;
	            margin: 0 auto;
	            color: #017572;
	         }
	         
	         .form-signin .form-signin-heading,
	         .form-signin .checkbox {
	            margin-bottom: 10px;
	         }
	         
	         .form-signin .checkbox {
	            font-weight: normal;
	         }
	         
	         .form-signin .form-control {
	            position: relative;
	            height: auto;
	            -webkit-box-sizing: border-box;
	            -moz-box-sizing: border-box;
	            box-sizing: border-box;
	            padding: 10px;
	            font-size: 10px;
	         }
	         
	         .form-signin .form-control:focus {
	            z-index: 2;
	         }
	         
	         .form-signin input[type="email"] {
	            margin-bottom: -1px;
	            border-bottom-right-radius: 0;
	            border-bottom-left-radius: 0;
	            border-color:#017572;
	         }
	         
	         .form-signin input[type="password"] {
	            margin-bottom: 10px;
	            border-top-left-radius: 0;
	            border-top-right-radius: 0;
	            border-color:#017572;
	         }
	         
	         

	        @media(max-width:767px){
	        	.logo-img{
	         		height: 35%;
	         		width: 35%;
	         	}
	        }
	        @media(min-width:767px){
	        	.logo-img{
	         		height: 25%;
	         		width: 25%;
	         	}
	        }
	        .logo-img{
	         	height: 20%;
	        	width: 20%;
	        }
	        .login-box{
	        	border-radius: 20px;
	         	margin-top: 100px;
	         	width: 25%;
	         	box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
	        }
	        .div-logo{
	        	padding-top: 40px;
	        	padding-bottom: 40px;
	        }
	        .form-signin{
	        	padding-bottom: 40px;
	        }
	        .staff-mgnt{
	        	padding-top: 30px;
	        }
	        .login-btn{
	        	border-radius: 20px;
	    		width: 50%;
	    		margin: 0 auto;
	        }
	        .error-msg{
	        	color: red;
	        }
	      </style>
	   	</style>
	</head>
	<body>      
  		<div class = "container login-box">
		  	<div class="div-logo text-center">
				<img src="src/logo/logo.png" class="img-responsive center-block logo-img"/>
				<h2 class="staff-mgnt">Staff Management</h2>
				<h3 class="error-msg">
					<?php
                    if(isset($_SESSION["error"])){
                        $error = $_SESSION["error"];
                        echo "$error";
                    }
                ?>  
				</h3>
		  	</div>
		  	<?php
				unset($_SESSION["error"]);
			?>		    
			<form class = "form-signin" role = "form" 
		        action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
		        ?>" method = "post">
		        <input type = "text" class = "form-control" 
		           name = "username" placeholder = "username" 
		           required autofocus></br>
		        <input type = "password" class = "form-control"
		           name = "password" placeholder = "password" required>
		        <div class="btn_align center-block">
		        	<button class = "btn btn-primary btn-block login-btn" type = "submit" 
		           name = "login">Login</button>
		        </div>
			</form>
  		</div>
   </body>
</html>