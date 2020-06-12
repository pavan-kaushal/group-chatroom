
<?php
session_start();
?>
<!DOCTYPE html>

<html>
<head>
	
	<title><?php echo $_GET["name"]; ?>'s Profile</title>
	<style type="text/css">
.profile-round-icon
{
	margin-left: 200px;
	position: relative;
	font-weight: bold;
	width:100px;
	height: 100px;
		
	border:5px solid black;
	border-radius: 100px;
}

.profile-round-icon h1
{
	width: 40%;
	padding-left: 40%;
	padding-top: 10%;
	color:black;
	font-weight: bold;
	
	
}

#user-details
{
	margin-left: 12%;
	padding-top: 1%;
	
}

.footer {
 		   position: fixed;
 			 left: 0;
 			 bottom: 0;
 			 width: 100%;
 			 background-color: red;
  			color: white;
			  text-align: left;
			  height: 50px;
			  margin-left: 1300px;
			  padding-left: 40px;
				}
		.footer a
		{
		background-color: #ffffa0;
		}

</style>


</head>	
<body>
	<div class="profile-round-icon">
		<h1><?php echo mb_substr($_GET["name"], 0, 1) ?><h1>
		</div>



 

	
	<div id ="user-details">
			<STRONG>Username: </STRONG><?php echo $_GET["name"]; ?><br><br>
	
	<br><br><br>
	<h1>**add any details about the user here from a database or through json message to the server**</h1>>
	</div>
	<div class="footer"><br><b>pavan-kaushal</b>:<a href="https://github.com/pavan-kaushal/group-chatroom">Github</a></div>
</body>
<script type="text/javascript">
	var colors = ['#4285F4', '#DB4437', 'F4B400','#0F9D58'];
var random_color = colors[Math.floor(Math.random() * colors.length)];
document.querySelector('.profile-round-icon').style.backgroundColor = random_color;
</script>
</html>
