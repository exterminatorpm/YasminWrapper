<?php

namespace Twisted\YasminWrapper;

use CharlotteDunois\Yasmin\Models\Message;
use React\EventLoop\LoopInterface;
use Twisted\YasminWrapper\Command\CommandMap;
use function array_shift;
use function explode;
use function substr;
use function time;

class Client extends \CharlotteDunois\Yasmin\Client{

    /**
     * Client's command map, stores all registered commands
     * @var CommandMap
     */
    public $commandMap;

    public function __construct(string $prefix, array $options = [], LoopInterface $loop = null){
        parent::__construct($options, $loop);

        $this->commandMap = new CommandMap($prefix);
    }

    /**
     * The client uptime (in UNIX time) since the last ready event (or 0 if none yet).
     * @return int
     */
    function getUptime(){
        return $this->readyTimestamp !== null ? time() - $this->readyTimestamp : 0;
    }

    public function on(string $event, callable $listener){
        if($event === "message"){
            $commandMap = $this->commandMap;

            parent::on($event, function($message) use ($commandMap){
                if($message instanceof Message){
                    $content = $message->content;
                    if(mb_strpos($content, $commandMap->prefix) === 0){
                        $args = explode(" ", $content);
                        $command = substr(array_shift($args), mb_strlen($commandMap->prefix));
                        $command = $commandMap->getCommand($command);
                        if($command !== null){
                            $command->onExecute($message, $args);
                        }
                    }
                }
            });
        }
        parent::on($event, $listener);
    }
}