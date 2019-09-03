<?php

namespace Twisted\YasminWrapper\Command;

use CharlotteDunois\Yasmin\Models\Message;

abstract class BaseCommand{

    /**
     * Name (identifier) of the command
     * @return string
     */
    abstract public function getName();

    /**
     * Description of the command
     * @return string
     */
    abstract public function getDescription();

    /**
     * How to use the command
     * @return string
     */
    abstract public function getUsage();

    /**
     * @param Message  $message
     * @param string[] $args
     *
     * @return mixed
     */
    abstract public function onExecute(Message $message, $args);
}