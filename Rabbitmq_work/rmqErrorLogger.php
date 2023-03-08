<?php  
require_once('../rabbitmqphp_example/path.inc');
require_once('../rabbitmqphp_example/get_host_info.inc');
require_once('../rabbitmqphp_example/rabbitMQLib.inc');
    
    function error_logger($error, $fileName){
        
            $file = fopen( $fileName . '.txt', "a" );
            for ($x = 0; $x < count($error); $x++){fwrite( $file, $error[$x] );}
            return true;
        }

?>
