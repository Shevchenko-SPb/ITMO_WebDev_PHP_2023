<?php

class PublishController {
    static function publicTaskInRedis ($id_task)
    {

        $redisClient = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => 'localhost',
            'port'   => 6379,
//            'pass' => 'sOmE_sEcUrE_pAsS'
        ]);

// Accept message
        $message = $id_task ?? null;
        $success = false;

        if ($message) {
            try {
                // Publish to 'message_update' channle whenever there is a new message
                $redisClient->publish('message_update', $message);
                $success = true;
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }

        header("Content-Type: application/json");
        echo json_encode(['success' => $success, 'message' => $message]);
//        exit();
    }
}
