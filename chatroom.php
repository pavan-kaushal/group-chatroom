<?php
if(!($_POST["name"] && $_POST["pwd"]=='123456'))
{
	header("Location: ./index.html");


}
session_start();
$_SESSION["name"]=$_POST["name"];


?>


<!DOCTYPE html>
<html>
<head>
	<title>LetsChat</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<script src="js/jquery.js" type="text/javascript"></script>
	<style type="text/css">
	h1
	{	
	color:white;
	background: orange;
	border:1px solid black;
	font-weight: bold;
	border-radius: 10px;
	width:900px;
	
	}
	* {margin:0;padding:0;box-sizing:border-box;font-family:arial,sans-serif;resize:none;}
	html,body {width:100%;height:100%;}
	#wrapper {position:relative;margin:auto;max-width:900px;height:100%;}
	#chat_output {position:absolute;top:0;left:0;padding:20px;width:900px;max-width:900px; height:calc(100%-100px) ; white-space: initial;
  background-color: #cccccc;}
	#chat_input {position:absolute;bottom:0;left:15%;padding:10px;width:70%;height:100px;border:5px solid #ccc;}
	
	.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   color: white;
}

	.footer {
    position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  color: white;
  text-align: left;
  height: 40px;

}

.footer2 {
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
		.footer2 a
		{
		background-color: #ffffa0;
		}

	b
	{
		color: blue;
		margin-left: 250px;
	}

	button {
    border: none;
    padding: 1rem 2rem;
    margin-left: 92%;
    margin-top:-30%;
    text-decoration: none;
    background: #0069ed;
    color: #ffffff;
    font-family: sans-serif;
    font-size: 1rem;
    cursor: pointer;
    text-align: center;
    transition: background 250ms ease-in-out, 
                transform 150ms ease;
    -webkit-appearance: none;
    -moz-appearance: none;
    border-radius: 50px;
}

button:hover,
button:focus {
    background: #0053ba;
}

button:focus {
    outline: 1px solid #fff;
    outline-offset: -4px;
}

button:active {
    transform: scale(0.99);
}


	</style>

</head>
<body>
	
	<h1>welcome to The Chatroom <?php echo $_POST["name"]; ?></h1>

			<button onclick="location.href='index.html';" id="stop-button"> Leave </button><br><br>
	
	
	<div id="wrapper">
		<div id="chat_output"></div>
		<div class="footer">
		<textarea  id="chat_input" placeholder="type your message and press enter......"></textarea>
		</div>
		<script type="text/javascript">
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//#wrapper {position:relative;margin:auto;max-width:900px;height:100%;}
	//#chat_output {position:absolute;top:0;left:0;padding:20px;width:100%;height:calc(100%-100px);
  //background-color: #cccccc;}
	//#chat_input {position:absolute;bottom:0;left:900px;padding:10px;width:40%;height:600px;border:5px solid #ccc; margin-top: -100px}
	

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
		jQuery(function($){
			// Websocket
			var websocket_server = new WebSocket("ws://localhost:8000/");//////////////////////here
			websocket_server.onopen = function(e) {
				websocket_server.send(
					JSON.stringify({
						'type':'socket',
						'user_id':'<?php echo $_POST["name"]; ?>'
					})	
				);
				
				//telling that a user joined the chatroom to all the clients
					websocket_server.send(
						JSON.stringify({
							'type':'chat',
							'user_id':'',
							'chat_msg':'<b>🚨-<a href="profile.php?name=<?php echo $_POST["name"]; ?>"><?php echo $_POST["name"]; ?></a>'.concat(' joined the chatroom-🚨</b>')
						})
					);

			}
			websocket_server.onerror = function(e) {
				// Errorhandle
				window.alert("///**Connection Error**///");
			}
			
			websocket_server.onmessage = function(e)
			{
				var json = JSON.parse(e.data);
				switch(json.type) {
					case 'chat':
						$('#chat_output').append(json.msg);
						break;
				}
			}

			


			// Events
			$('#chat_input').on('keyup',function(e){
				if(e.keyCode==13 )
				{
					var chat_msg = $(this).val();
					
					websocket_server.send(
						JSON.stringify({
							'type':'chat',
							'user_id':'<?php echo $_POST["name"]; ?>',
							'chat_msg':chat_msg
							//send bio from here
						})
					);
					$(this).val('');
				}
			});
		});

	
		</script>
	</div>
	<div class="footer2"><br>pavan-kaushal	:<a href="https://github.com/pavan-kaushal/group-chatroom">Github</a></div>
</body>
</html>