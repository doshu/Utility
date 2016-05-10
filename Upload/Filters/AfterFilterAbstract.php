<?php

    namespace App\Lib\Upload\Filters;
    
    abstract class AfterFilterAbstract implements FilterInterface {
        
        public function implementedEvents() {
            return [
                'Uploader.upload.afterMove' => 'afterMove',
            ];
        }

        public function afterMove($event) {
            throw new Exception('Funzione afterMove non implementata in '.__CLASS__);
        }
        
    }

?>
