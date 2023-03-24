<?php  
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

use rabbitMQClient;

function event_logger($event, $message) {
    $fp = "events.log";
    $event = "[" . date('Y-m-d H:i:s') . "] Event'" . $event . "': " . $message . "\n";
    $fh = fopen($fp, "a");
    fwrite($fh, $event);
    fclose($fh);
    $client = new rabbitMQClient();
    $req = array(
        'type' => 'log',
        'log_type' => $event,
        'log_message' => $message
    );
    $response = $client->send_request($req);
}



?>
