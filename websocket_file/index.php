<html>
	<head>
		<style>
			#drag {
				border:2px dashed #333; 
				border-radius:10px; 
				width:50%; 
				height:300px; 
				margin:auto; 
				display:table;
			}
			
			#drag > div:first-child {
				font-size:25px; 
				font-family:arial; 
				text-transform:uppercase; 
				text-align:center; 
				vertical-align:middle; 
				display:table-cell
			}
			
			.dragin {
				background-color:rgba(255, 0, 0, 0.4);
			}
			
			#upload {
				margin-top:20px;
			}
			
		</style>
	</head>
	<body>
		<!--div id="file" style="border:2px dashed #333; border-radius:10px; width:50px; height:50px; margin:auto; display:table;" draggable="true">
			<div style="font-size:15px; font-family:arial; text-transform:uppercase; text-align:center; vertical-align:middle; display:table-cell">
				File
			</div>
		</div-->
		<div id="drag">
			<div>
				Trascina i file qui
			</div>
		</div>
		<div>
			<button type="button" id="upload">Upload</button>
		</div>
		<script>
		
			function file_to_blob (file, callback) {
				var type = file.type;
     			var reader = new FileReader;
     			
     			reader.onloadend = function() {
     				callback(new Blob([reader.result], {type:type}));
     			}
     			reader.readAsBinaryString(file);
     			
     			
     		};
     		
     		var filelist = [];
			
			var drag = document.getElementById('drag');
			var file = document.getElementById('file');
			var upload = document.getElementById('upload');
			var socket;
			
			/*
			file.addEventListener("dragstart", function (e) {
         		e.dataTransfer.setData('text/html', this.innerHTML);
      		}, false);
      		*/
      		
      		drag.addEventListener("drop", function(e) {
         		//console.log(e.dataTransfer.getData('text/html'));
         		e.stopPropagation();
         		e.preventDefault();
         		this.classList.remove('dragin');
         		[].forEach.call(e.dataTransfer.files, function(file) {
         			filelist.push(file);
         		});
         		
      		}, false);
      		 
      		drag.addEventListener("dragenter", function(e) {
         		this.classList.add('dragin');
      		}, false);
      		
      		
      		
      		drag.addEventListener("dragleave", function(e) {
         		this.classList.remove('dragin')
      		}, false);
      		
			
      		drag.addEventListener("dragover", function(e) {
      			e.preventDefault();
         		e.dataTransfer.dropEffect = 'move';
         		
         		return false;
      		}, false);
      		
      		upload.addEventListener('click', function(e) {
      			socket = new WebSocket('ws://127.0.0.1:8081/');
      			socket.onmessage = function() {
      				alert('ok');
      			}
      			socket.onopen = function() {
      				socket.send(filelist[0]);
      				/*
      				file_to_blob(filelist[0], function(blob) {
      					socket.send(blob);
      				});
      				*/
      				
      				socket.send("\0\n");
      			}
      			
      		});
      		
      	
		</script>
	</body>
</html>
