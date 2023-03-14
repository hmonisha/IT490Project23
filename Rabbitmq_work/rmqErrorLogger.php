<?php  
require_once('../rabbitmqphp_example/path.inc');
require_once('../rabbitmqphp_example/get_host_info.inc');
require_once('../rabbitmqphp_example/rabbitMQLib.inc');
    
    function error_logger($queue,$error){
        $fp = "error.log";
        $error = "[" . date('Y-m-d H:i:s') . "] There was an Error in queue '" . $queue . "': " . $error . "\n";
        $fh = fopen($fp, "a");
        fwrite($fh, $error);
        fclose($fh);

        }

?>
