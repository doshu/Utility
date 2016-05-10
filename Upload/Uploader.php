<?php

    namespace App\Lib\Upload;
    
    use Cake\ORM\TableRegistry;
    use Cake\Validation;
    use Cake\Datasource\ConnectionManager;
    use Cake\Event\Event;

    
    class Uploader {
    
        use \Cake\Event\EventManagerTrait;
        
        protected $_beforeFilters = [];
        
        protected $_afterFilters = [];
        
        protected $_allowedExtensions = [];
        
        protected $_allowedMimeTypes = [];
        
        protected $_maxSize = null;
        
        protected $_tempDir = TMP;
        
        protected $_data = null;
        
        protected $_field = null;
        
        protected $_uploadModel = null;
        
        protected $_defaultUploadModel = 'Tempfiles';
        
        protected $_errors;
        
        protected $_destinationDir = null;
        
        protected $_user = null;
        
        
        /**
         * __construct
         *
         * data deve essere l'array del file uploadato come riportato dall'oggetto request
         * 
         * @param array $data
         * @return void
         */
        public function __construct($options = []) {
            $this->_uploadModel = TableRegistry::get(isset($options['model'])?$options['model']:$this->_defaultUploadModel);
        }
        
        
        /**
         * data
         *
         * imposta o ritorna i dati del file da uploadare. Il formato deve essere quello estrapolato dall'oggetto request
         * 
         * @param string $data = null
         * @return mixed
         */
        public function data($field = null, $data = null, $full = false) {
            if($data) {
                $this->_data[$field] = isset($data[$field])?$data[$field]:[];
                $this->_field = $field;
                return $this;
            }
            return $full == true?$this->_data:$this->_data[$this->_field];
        }
        
        /**
         * user
         *
         * imposta o ritorna l'utente per il quale l'upload viene associato e verificato
         * 
         * @param int $user_id = null
         * @return void
         */
        public function user($user_id = null) {
            if($user_id) {
                $this->_user = $user_id;
                return $this;
            }
            return $this->_user;
        }
        
        /**
         * tempDir
         *
         * imposta o ritorna la directory temporanea attuale
         * 
         * @param string $dir = null
         * @return mixed
         */
        public function tempDir($dir = null) {
            if($dir) {
                $this->_tempDir = $dir;
                return $this;
            }
            return $this->_tempDir;
        }
        
        
        /**
         * destinationDir
         *
         * imposta o ritorna la directory di destinazione attuale
         * 
         * @param string $dir = null
         * @return mixed
         */
        public function destinationDir($dir = null) {
            if($dir) {
                $this->_destinationDir = $dir;
                return $this;
            }
            return $this->_destinationDir;
        }
        
        /**
         * allowedExtensions
         *
         * imposta o ritorna le estensioni abilitate
         * se $empty è true, le estensioni abilitate vengono sovrascritte
         * 
         * @param mixed $ext
         * @param bool $empty = true
         * @return mixed
         */
        public function allowedExtensions($ext = null, $empty = true) {
            if($ext) {
                $ext = (array)$ext;
                $this->_allowedExtensions = [];
                foreach($ext as $extension) {
                    if(is_string($extension)) {
                        $this->_allowedExtensions[] = $extension;
                    }
                }
                return $this;
            }
            return $this->_allowedExtensions;
        }
        
        
        
        /**
         * allowedMimeTypes
         *
         * imposta o ritorna i mime/type abilitati
         * se $empty è true, l mime/type abilitati vengono sovrascritte
         * 
         * @param mixed $mime
         * @param bool $empty = true
         * @return mixed
         */
        public function allowedMimeTypes($mime = null, $empty = true) {
            if($mime) {
                $mime = (array)$mime;
                $this->_allowedMimeTypes = [];
                foreach($mime as $mimetype) {
                    if(is_string($mimetype)) {
                        $this->_allowedMimeTypes[] = $mimetype;
                    }
                }
                return $this;
            }
            return $this->_allowedMimeTypes;
        }
        
        
        /**
         * maxSize
         *
         * imposta o ritorna la dimensione massima del file
         * il formato può essere di tipo human (1M, 2K) o in byte
         * 
         * @param unknown $size = null
         * @return string
         */
        public function maxSize($size = null) {
            if($size) {
                $this->_maxSize = $size;
                return $this;
            }
            return $this->_maxSize;
        }
        
        /**
         * attachFilter
         *
         * attacha al event manager un filtro che può eseguire operazioni prima o dopo lo spostamento del file
         * la cosa vale sia per l'upload, quindi prima dello spostamento dalla temp di php alla cartella temporanea
         * dei file uploadati, sia durante la richiesta di conferma del file uploadato, quindi dalla cartella temporanea al file finale
         * 
         * @param \App\Lib\Upload\Filters\FilterInterface $filter
         * @return void
         */
        public function attachFilter(\App\Lib\Upload\Filters\FilterInterface $filter) {
            $this->eventManager()->on($filter);
            return $this;
        }
        
        /**
         * errors
         *
         * imposta o ritorna gli errori della validazione
         * 
         * @param array $errors = null
         * @return array
         */
        public function errors($errors = null) {
            if($errors) {
                $this->_errors = $errors;
                return $this;
            }
            return $this->_errors;
        }
        
        /**
         * getBasename
         *
         * ritorna il nome originale del file
         * 
         * @return string
         */
        public function getName() {
            return $this->data()['name'];
        }
        
        /**
         * getTempName
         *
         * ritorna il path del file temporaneo 
         * 
         * @return string
         */
        public function getTempName() {
            return $this->data()['tmp_name'];
        }
        
        /**
         * _getUniqueFilename
         *
         * crea il nome di un file temporaneo
         * 
         * @param string $dir
         * @return string
         */
        protected function _getUniqueFilename($dir) {
            do {
                $filename = md5(uniqid(null, true));
            } while(file_exists($dir.DS.$filename));
            return $dir.DS.$filename;
        }
        
        /**
         * getNewTempName
         *
         * ritorna il nome del nuovo file temporaneo
         * 
         * @return string
         */
        public function getNewTempName() {
            $name = $this->_getUniqueFilename($this->tempDir()).'.'.$this->guessExtension();
            touch($name);
            return $name;
        }
        
        
        /**
         * getFinalName
         *
         * ritorna il nome del nuovo file finale
         * 
         * @return string
         */
        public function getFinalName($ext) {
            return $this->_getUniqueFilename($this->destinationDir()).'.'.$ext;
        }
        
        
        /**
         * getMimeType
         *
         * ritorna il mime/type del file da finfo
         * 
         * @return string
         */
        public function getMimeType() {
            $finfo = finfo_open(FILEINFO_MIME);
            $finfo = finfo_file($finfo, $this->getTempName());

            if (!$finfo) {
                return null;
            }

            list($mime) = explode(';', $finfo);
            return $mime;
        }
        
        
        /**
         * guessExtension
         *
         * trova l'estensione corretta per il file in base al mime/type
         * 
         * @return string
         */
        public function guessExtension() {
            $mime = $this->getMimeType();
            $ext = null;
            if($mime) {
                $ext = (new Mapper\LinuxMimeTypesMapper())->get($mime);
            }
            return $ext;
        }
        
        /**
         * _isValidUpload
         *
         * Controlla che l'array del file in data non sia stato creato a mano
         * e che sia un array creato da $_FILES.
         * il controllo viene fatto in base a se esiste nell'array $_FILES un campo con lo stesso nome
         * e con la funzione is_uploaded_file
         * 
         * @param array $data
         * @param array $context
         * @return bool
         */
        public function isValidUpload($data, $context) {
            if(isset($_FILES[$this->_field])) {
                if(empty($data['tmp_name'])) {
                    return true; //se c'è stato un errore il tmp_name è vuoto
                }
                return is_uploaded_file($data['tmp_name']);
            }
            return false;
        }
        
        
        /**
         * _getUploadModel
         * 
         * ritorna l'oggetto tabella per il salvataggio del file temporaneo
         *
         * @return Table
         */
        protected function _getUploadModel() {
            if(!$this->_uploadModel) {
                $this->_uploadModel = TableRegistry::get($this->_defaultUploadModel);
            }   
            return $this->_uploadModel;
        }
        


        /**
         * upload
         *
         * esegue il primo step di upload del file
         * prende il file uploadato, lo valida e lo copia in una cartella temporanea, salvando nel db l'entry del file temporaneo
         * che successivamente verrà utilizzato per recuperare il vero file
         * 
         * @return bool
         */
        public function upload() {
            
            $validator  = new Validation\Validator();
            $validator->provider('default', new Validation\Validation());
            $validator->add($this->_field, 'isValidUpload', [
                'rule' => [$this, 'isValidUpload'],
                'last' => true
            ]);
            $validator->add($this->_field, 'mimetype', ['rule' => ['mimeType', $this->allowedMimeTypes()]]);
            $validator->add($this->_field, 'fileSize', ['rule' => ['fileSize', '<=', $this->maxSize()]]);
            $validator->add($this->_field, 'uploadError', ['rule' => ['uploadError', false], 'last' => true]);
            
            if(!empty($this->allowedExtensions())) {
                $validator->add($this->_field, 'extension', ['rule' => ['extension', $this->allowedExtensions()]]);          
            }
            
            $errors = $validator->errors($this->data(null, null, true));
            if(empty($errors)) {
                $temp = $this->_getUploadModel()->newEntity();
                $temp->basename = $this->getName();
                $temp->mime = $this->getMimeType();
                $temp->extension = $this->guessExtension();
                $temp->user_id = $this->user();
                
                $connection = ConnectionManager::get('default');
                $connection->begin();
                try {
                    $event = new Event('Uploader.upload.beforeMove', $this, [
                        'upload_data' => $this->data(),
                        'temp' => $temp
                    ]);
                    $this->eventManager()->dispatch($event);
                    if ($event->isStopped()) {
                        throw new Exception('Errore durante il caricamento del file');    
                    }
                    $finalName = isset($event->result['newFileName'])?$event->result['newFileName']:$this->getNewTempName();
                    $temp->tempname = $finalName;
                    
                    $saved = $this->_getUploadModel()->save($temp);
                    if(!$saved) {
                        throw new Exception('Errore durante il caricamento del file');
                    }
                    
                    $moved = @move_uploaded_file($this->getTempName(), $temp->tempname);
                    
                    $event = new Event('Uploader.upload.afterMove', $this, [
                        'upload_data' => $this->data(),
                        'temp' => $temp
                    ]);
                    $this->eventManager()->dispatch($event);
                    if ($event->isStopped()) {
                        throw new Exception('Errore durante il caricamento del file');    
                    }
                    
                    if(!$moved) {
                        throw new Exception('Errore durante il caricamento del file');
                    }
                    $connection->commit();
                    return $this->_getUploadModel()->get($temp->id);
                }
                catch(Exception $e) {
                    \Cake\Log\Log::write('error', $e->getMessage(), ['upload']);
                    $errors['upload'] = $e->getMessage();
                    $connection->rollback();
                }
                
            }
            $this->errors($errors);
            return false;
        }
        
        
        public function commit($uuid) {
        
            try {
                if(!$this->destinationDir()) {
                    throw new \LogicException('La directory di destinazione non è stata impostata');
                }
                
                $temp = $this->_getUploadModel()->findByUuid($uuid)->first();
                if($temp) {
                    if($this->user()) {
                        if($temp->user_id != $this->user()) {
                            throw new \Cake\Datasource\Exception\RecordNotFoundException('File non trovato');
                        }
                    }
                    $connection = ConnectionManager::get('default');
                    $connection->begin();
                    
                    $deleted = $this->_getUploadModel()->delete($temp);
                    if(!$deleted) {
                        throw new \Exception('Errore durante la cancellazione del record temporaneo');
                    }
                    
                    $event = new Event('Uploader.upload.beforeMove', $this, [
                        'temp' => $temp,
                    ]);
                    $this->eventManager()->dispatch($event);
                    if ($event->isStopped()) {
                        throw new \Exception('Errore durante il caricamento del file');    
                    }
                    
                    $finalName = isset($event->result['newFileName'])?$event->result['newFileName']:$this->getFinalName($temp->extension);
                    $moved = @rename($temp->tempname, $finalName);
                    
                    $event = new Event('Uploader.upload.afterMove', $this, [
                        'temp' => $temp,
                        'new_file' => $finalName
                    ]);
                    $this->eventManager()->dispatch($event);
                    if ($event->isStopped()) {
                        throw new \Exception('Errore durante il caricamento del file');    
                    }
                    
                    if(!$moved) {
                        throw new \Exception('Errore durante lo spostamento del file');
                    }
                    $connection->commit();
                    $temp->removeFile();
                    return $finalName;
                }
                throw new \Cake\Datasource\Exception\RecordNotFoundException('File non trovato');
            } 
            catch(Exception $e) {
                $connection->rollback();
                \Cake\Log\Log::write('error', $e->getMessage(), ['upload']);
                $errors['commit'] = $e->getMessage();
                $this->errors($errors);
                return false;
            }       
        }
        
        
        
        /**
         * verify
         *
         * effettua la sola validazione del file uploadato
         * 
         * @return bool
         */
        public function verify() {
            
            $validator  = new Validation\Validator();
            $validator->provider('default', new Validation\Validation());
            $validator->add($this->_field, 'isValidUpload', [
                'rule' => [$this, 'isValidUpload'],
                'last' => true
            ]);
            $validator->add($this->_field, 'mimetype', ['rule' => ['mimeType', $this->allowedMimeTypes()]]);
            $validator->add($this->_field, 'fileSize', ['rule' => ['fileSize', '<=', $this->maxSize()]]);
            $validator->add($this->_field, 'uploadError', ['rule' => ['uploadError', false], 'last' => true]);
            
            if(!empty($this->allowedExtensions())) {
                $validator->add($this->_field, 'extension', ['rule' => ['extension', $this->allowedExtensions()]]);          
            }
            
            return $validator->errors($this->data(null, null, true));
        }
        
    }

?>
