<?php
use Josantonius\Logger\Logger;


class SubscribeController {
    static function subscribeForCreateTask ()
    {

        $redisClient = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => 'localhost',
            'port'   => 6379,
        ]);

        set_time_limit(0);
        header('Content-Type: text/event-stream');
        header('Connection: keep-alive');
        header('Cache-Control: no-store');

        header('Access-Control-Allow-Origin: *');

        $pubsub = $redisClient->pubSubLoop();
        $pubsub->subscribe('queue_tasks');  // Subscribe to channel named 'queue_tasks'

        foreach ($pubsub as $message) {
        var_dump($message);
            switch ($message->kind) {
                case 'subscribe':
//                  $data = "Subscribed to {$message->channel}";
                    $data = "Data = {$message->payload}";
                    $jsonArrTasks = json_decode($message->payload);
                    file_put_contents('logger.txt', 'subscribe='.$message->payload);
                    break;
                case 'message':
                    $data = date('Y-m-d H:i:s') . ": " . $message->payload;
                    file_put_contents('logger.txt', 'message='.$message->payload);
                    break;
            }

            echo "data: " . $data . "\n\n";

            ob_flush();
            flush();
        }

        unset($pubsub);

    }
}