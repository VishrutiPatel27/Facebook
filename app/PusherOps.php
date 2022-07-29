<?php
    namespace App;
    trait PusherOps {
        public function push($event,$data)
        {
            $options = array(
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => false
            );
            $pusher = new \Pusher\Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

            $pusher->trigger('blog', $event, $data);
        }
    }
