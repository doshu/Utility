<script>
	var source = new EventSource('stream.php');
	
	source.addEventListener('message', function (e) {
		console.log(e.data);
	}); 
</script>
