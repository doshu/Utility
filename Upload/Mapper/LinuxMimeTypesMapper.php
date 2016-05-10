<?php

    namespace App\Lib\Upload\Mapper;
    
    
    class LinuxMimeTypesMapper implements MapperInterface {
        
        private $__map = [];
        
        public function __construct($file = '/etc/mime.types') {
            $this->__map = $this->_parseFile($file);
        }
        
        public function get($mime) {
            $mime = strtolower($mime);
            return isset($this->__map[$mime])?$this->__map[$mime][0]:null;
        }   
        
        
        protected function _parseFile($file) {
            $file = file($file);
            $map = [];
            foreach($file as $line) {
                $line = trim($line);
                if(strlen($line) > 0 && $line[0] != '#') {
                    preg_match('/^([^\s]*)\s*(.*)$/i', $line, $matches);
                    if(isset($matches[1]) && !empty($matches[1]) && isset($matches[2]) && !empty($matches[2])) {
                        $map[strtolower($matches[1])] = explode(' ', $matches[2]);
                    }  
                }
            }
            return $map;
        }
        
    }

?>
