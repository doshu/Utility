<?php

    namespace App\Lib\Upload\Filters;
    
    abstract class BeforeAndAfterFilterAbstract implements FilterInterface {
        
        public function implementedEvents() {
            return [
                'Uploader.upload.beforeMove' => 'beforeMove',
                'Uploader.upload.afterMove' => 'afterMove',
            ];
        }

        public function beforeMove($event) {
            throw new Exception('Funzione beforeMove non implementata in '.__CLASS__);
        }
        
    }

?>
