<?php
    require_once(LIB_PATH.DS.'dbdml.php');      
    require_once(LIB_PATH.DS.'configuration.php');
    require_once(LIB_PATH.DS.'autoload.php');
    require_once(LIB_PATH.DS.'dboperation.php');

    use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;
     
    class Photograph extends DatabaseObject {

        protected static $table_name = "photos";
        protected static $db_fields = array('id', 'filename', 'type', 'size');
        public static $max_file_size = 1048576;
        public $id;
        public $filename;
        public $type;
        public $size;
        public $captured_file;
        private $tmp_path;
        protected $upload_directory = "uploaded_images";
        public $errors = array();

        protected $upload_error = array(
            UPLOAD_ERR_OK => "No errors",
            UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
            UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE",
            UPLOAD_ERR_PARTIAL => "Partial upload",
            UPLOAD_ERR_NO_FILE => "No File",
            UPLOAD_ERR_NO_TMP_DIR => "No temporary directory",
            UPLOAD_ERR_CANT_WRITE => "Can't write to disk",
            UPLOAD_ERR_EXTENSION => "File upload stopped by extension"
        );

       public function attach_file($file) {
            $this->captured_file = $file;

            if(!$file || empty($file) || !is_array($file)) {
                $this->errors[] = "No file was uploaded.";
                return false;
            }else if($file['error'] != 0) {
                    $this->errors[] = $this->upload_error[$file['error']];
                    return false;
            }else {
                    $this->temp_path    = $file['tmp_name'];
                    $this->filename     = basename($file['name']);
                    $this->type         = $file['type'];
                    $this->size         = $file['size'];
                    return true;
            }
       } 

       public function save_image_to_db($file) {
           if(isset($this->id)) {
                $this->update();
           }else {
                if(!empty($this->errors)) {
                    return false;
                }

                if(empty($this->filename) || empty($this->temp_path)){
                    $this->errors[] = "The file location was not available.";
                    return false;
                }

                /*  
                *   
                *   Replace the following S3 credentials with your own
                *   S3_BUCKETNAME:    Your bucketname   
                *   S3_KEY:    Your AWS authentication key
                *   S3_SECRET:    Your AWS SECRET keyword
                *
                */
                $bucketname = "";
                $key = "";
                $secret = "";

                $target_path = 'https://s3.us-east-2.amazonaws.com/' . $bucketname .'/cainam/' . $this->filename;


                if(file_exists($target_path)) {
                    $this->errors[] = "The file {$this->filename} already exists.";
                    return false;
                }

                $db_object = new DatabaseObject();
                $db_object->add_to_AWS($file);
                if($this->create()) {
                    $session = new Session();
                    $session->message("Photo uploaded successfully");
                    redirect_to("../../index.php");
                }
            }
        }

        public function delete_photo($filename) {
            if($this->delete()) {
                $db_object = new DatabaseObject();
                $db_object->delete_image_in_S3($filename);
                // redirect_to("../index.php");
                // redirect_to("../../index.php");
            }else {
                return false;
            }
        }

        public function image_path(){
            return $this->upload_directory.DS.$this->filename;
        }

        public function load_image_to_display(){
            return 'public'.DS.'photo'.DS.$this->upload_directory.DS.$this->filename;
        }

        public function load_photo_from_aws($bucketname, $filename){
            $pathInS3 = 'https://s3.us-east-2.amazonaws.com/' . $bucketname .'/cainam/' . $filename;
            return $pathInS3;
        }

        public function size_as_text() {
            if($this->size < 1024) {
                return "{$this->size} bytes";
            }else if($this->size < 1048576) {
                $size_kb = round($this->size/1024);
                return "{$size_kb} KB";
            }else {
                $size_mb = round($this->size/1048576, 1);
                return "{$size_mb} MB";
            }
        }
    }
?>