<?php  
require_once('../rabbitmqphp_example/path.inc');
require_once('../rabbitmqphp_example/get_host_info.inc');
require_once('../rabbitmqphp_example/rabbitMQLib.inc');
    

    function event_logger($event,$message){
                $fp = "events.log";
        $event = "[" . date('Y-m-d H:i:s') . "] Event'" . $event . "': " . $message . "\n";
        $fh = fopen($fp, "a");
        fwrite($fh, $event);
        fclose($fh);
        $client = new rabbitMQClient();
        $req = array(
            'type' => 'log',
            'log_type' => $event,
            'log_message' => $log_message);
        $response = $client->send_request($req);
    }

?>
