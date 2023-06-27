<?php

class PublishController {
    public function actionIndex ()
    {
        $redisClient = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => 'localhost',
            'port'   => 6379
        ]);

// Accept message
        $message = $_POST['message'] ?? null;
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
