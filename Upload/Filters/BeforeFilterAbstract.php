<?php

    namespace App\Lib\Upload\Filters;
    
    abstract class BeforeFilterAbstract implements FilterInterface {
        
        public function implementedEvents() {
            return [
                'Uploader.upload.beforeMove' => 'beforeMove',
            ];
        }

        public function beforeMove($event) {
            throw new Exception('Funzione beforeMove non implementata in '.__CLASS__);
        }
        
    }

?>
