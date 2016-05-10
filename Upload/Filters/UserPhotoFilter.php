<?php

    namespace App\Lib\Upload\Filters;
    
    class UserPhotoFilter extends BeforeFilterAbstract {
    
        protected $_containerWidth = null;
        protected $_containerHeight = null; 
        protected $_showedImageWidth = null; 
        protected $_showedImageHeight = null; 
        protected $_top = null; 
        protected $_left = null;
        
        public function __construct($containerWidth, $containerHeight, $showedImageWidth, $showedImageHeight, $top, $left) {
            $this->_containerWidth = $containerWidth;
            $this->_containerHeight = $containerHeight; 
            $this->_showedImageWidth = $showedImageWidth; 
            $this->_showedImageHeight = $showedImageHeight; 
            $this->_top = $top; 
            $this->_left = $left;
        }
    
        public function beforeMove($event) {
            $cover = (new \Intervention\Image\ImageManager)->make($event->data['temp']['tempname']);
            $top = ceil($cover->height()*$this->_top/$this->_showedImageHeight);
            $left = ceil($cover->width()*$this->_left/$this->_showedImageWidth);
            $height = ceil($cover->height()*$this->_containerHeight/$this->_showedImageHeight);
            $width = ceil($cover->width()*$this->_containerWidth/$this->_showedImageWidth);
            
            $cover = $cover->crop($width, $height, $left, $top);
            $temporary = tempnam(TMP, '');
            $event->data['temp']['tempname'] = $temporary;
            $event->data['temp']['mime'] = 'image/jpg';
            $event->data['temp']['extension'] = 'jpg';
            file_put_contents($temporary, $cover->encode('jpg', 100));
            
            $event->result['newFileName'] = $event->subject()->getFinalName('jpg');
        }
    }

?>
