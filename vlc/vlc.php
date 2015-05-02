<?php


	class VlcStream {
		
		private $__input;
		private $__output;
		private $__outputFormat;
		 
		private $__commandTemplate = "cvlc %s --sout '#transcode{vcodec=theo,acodec=vorb,deinterlace=0,scale=1,vb=800,ab=128,channels=2}:standard{access=file,mux=ogg,dst=%s}'";

		//private $__commandTemplate = "avconv -i %s %s -f %s %s";
		private $__process;
		private $__pipes;
		private $__opt = '';
		
		private $__contentType = array(
			'webm' => 'video/webm',
			'ogg' => 'video/ogg',
			'avi' => 'video/x-msvideo'
		);
		
		public function __construct() {
			$this->__out = fopen('php://output', 'w');
			register_shutdown_function(array($this, 'shutdown'));
		}
		
		public function setInput($input) {
			$this->__input = $input;
		}
		
		public function setOutput($output) {
			$this->__output = $output;
		}
		
		/*
		public function setOpt($opt) {
			$this->__opt = $opt;
		}
		*/
		
		public function setOutputFormat($outputFormat) {
			$this->__outputFormat = $outputFormat;
		}
		
		
		public function getStream() {
			$cmd = sprintf($this->__commandTemplate, $this->__input, $this->__output);
			$this->__process = proc_open($cmd, $this->__getStreamDescriptor(), $this->__pipes);
			stream_set_blocking($this->__pipes[1], 0);
			if(is_resource($this->__process)) {
				$this->__sendHeaders();
				while(($status = proc_get_status($this->__process)) && $status['running']) {
					$checkRead = array($this->__pipes[1]);
					$checkWrite = $checkExcept = null;
					if($readed = stream_select($checkRead, $checkWrite, $checkExcept, 0) !== false) {
						if(count($checkRead)) {
							$data = $this->__getDataFromPipe($checkRead[0]);
							$this->__sendData($data);
						}
					}
				}
			}
		}
		
		/*
		public function putStream() {
			$cmd = sprintf($this->__commandTemplate, $this->__input, $this->__outputFormat, $this->__output);
			$this->__process = proc_open($cmd, $this->__getStreamDescriptor(), $this->__pipes);
			stream_set_blocking($this->__pipes[1], 0);
			$fp = fopen('file.'.$this->__outputFormat, 'w');
			if(is_resource($this->__process)) {
				$time = time();
				while(time() - $time < 20) {
					
					
					$checkRead = array($this->__pipes[1]);
					$checkWrite = $checkExcept = null;
					if($readed = stream_select($checkRead, $checkWrite, $checkExcept, 0) !== false) {
						if(count($checkRead)) {
							$data = $this->__getDataFromPipe($checkRead[0]);
							fwrite($fp, $data);
						}
					}
					
				}
				//$this->shutdown();
			}
		}
		*/
		
		private function __sendHeaders() {
			ob_implicit_flush(1);
			header('Content-Type: '.$this->__getContentType());
			ob_flush();
			flush();
		}
		
		private function __getContentType() {
			if(isset($this->__contentType[$this->__outputFormat])) {
				return $this->__contentType[$this->__outputFormat];
			}
			return 'video/'.$this->__outputFormat;
		}
		
		private function __sendData($data) {
			fwrite($this->__out, $data);
			ob_flush();
			flush();
		}
		
		private function __getDataFromPipe($pipe) {
			
			return stream_get_contents($pipe);
		}
		
		private function __getStreamDescriptor() {
			return array(
			   0 => array("pipe", "r"),  // stdin
			   1 => array("pipe", "w"),  // stdout
			   2 => array("pipe", "w") // stderr
			);
		}
		
		public function shutdown() {
			fclose($this->__pipes[0]);
			fclose($this->__pipes[1]);
			fclose($this->__pipes[2]);
			proc_terminate($this->__process);
		}
	}

?>
