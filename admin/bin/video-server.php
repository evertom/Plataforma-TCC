<?php
/* $ php bin/chat-server.php *///comando Shell de ativação
use Video\Video as Video;
use Ratchet\App as App;

require dirname(__DIR__) . '/vendor/autoload.php';

// Your shell script
$server = new App("localhost", 9090);
$server->route('/Video',new Video);
$server->run();