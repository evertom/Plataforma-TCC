<?php
/* $ php bin/chat-server.php *///comando Shell de ativação
use Chat\Chat as Chat;
use Ratchet\App as App;

require dirname(__DIR__) . '/vendor/autoload.php';

// Your shell script
$server = new App("localhost");
$server->route('/Chat',new Chat);
$server->run();