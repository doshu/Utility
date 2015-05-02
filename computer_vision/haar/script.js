var image = new Image();

function hasGetUserMedia() {
  return navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || false;
}

function printVideo(source, dest) {
	dest.drawImage(source, 0, 0, 640, 480);
}


function getFrame(source) {
	var canvasThumb = document.getElementById('canvasThumb');
	canvasThumb.getContext('2d').drawImage(source, 0, 0, 640, 480);
	return canvasThumb.toDataURL();
}


function run() {
	try {
		
		var frame = getFrame(source);
	
		var canvas = document.getElementById('canvas');
		var ctx = canvas.getContext('2d');
		
		image.onload = function() {
		
			new HAAR.Detector(haarcascade_frontalface_alt, false)
        	.image(image) 
		    .complete(function(){
            	var i, rect, l=this.objects.length;
            	printVideo(image, ctx);
				
	            ctx.strokeStyle="rgba(220,0,0,1)"; ctx.lineWidth=2;
	            ctx.strokeRect(this.Selection.x, this.Selection.y, this.Selection.width, this.Selection.height);
	            ctx.strokeStyle="rgba(75,221,17,1)"; ctx.lineWidth=2;
	            for (i=0; i<l; i++) {
	                rect=this.objects[i];
	                ctx.strokeRect(rect.x, rect.y, rect.width, rect.height);
	            }
	             console.log('Selection Rectangle: ');
                       console.log(this.Selection.toString());
                        console.log('Detected Features (' + l +') :');
                        console.log(this.objects.toString());
				setTimeout(run, 0);
	        })
	        .detect(1, 1.25, 0.5, 1, true);
			
		}
		
	
		image.src = frame;
	}
	catch(e) {
		console.log(e);
		setTimeout(run, 0);
	}
}

var source = document.getElementById('source');
navigator.getUserMedia = hasGetUserMedia();

if(navigator.getUserMedia) {
	navigator.getUserMedia({video:true}, function(stream) {
	
	
		window.URL = window.URL || window.webkitURL;
		source.src = window.URL.createObjectURL(stream);
		
		source.addEventListener('play', function() {
		
			setTimeout(run, 10);
			
		});
		
		
		
	}, function(e) { console.log(e); });
}


