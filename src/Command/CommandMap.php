<?php

namespace Twisted\YasminWrapper\Command;

use ReflectionClass;
use ReflectionException;
use function glob;
use function mb_strtolower;
use function str_replace;

class CommandMap{

    /**
     * Prefix the client will listen to for commands
     * @var string
     */
    public $prefix;

    /**
     * All the registered commands for the client
     * @var BaseCommand[]
     */
    private $registeredCommands = [];

    /**
     * CommandMap constructor.
     *
     * @param string $prefix
     *
     */
    public function __construct($prefix){
        $this->prefix = $prefix;
    }

    /**
     * Returns all of the registered commands in the command map
     *
     * @return BaseCommand[]
     */
    function getAllCommands(){
        return $this->registeredCommands;
    }

    /**
     * Attempts to get the provided command from the command map, returns null if the command is not found
     *
     * @param $name
     *
     * @return BaseCommand|null
     */
    function getCommand($name){
        return isset($this->registeredCommands[mb_strtolower($name)]) ? $this->registeredCommands[mb_strtolower($name)] : null;
    }

    /**
     * Attempts to register all the .php files as commands within the provided directory
     *
     * @param string $dir
     * @param string $basePath
     *
     * @throws ReflectionException
     */
    function registerAllInDir($dir, $basePath){
        foreach(glob($dir . "/*.php") as $file){
            require_once $file;

            $class = str_replace([$dir . "/", ".php"], "", $file);
            $classPath = $basePath . "\\" . $class;
            $reflection = new ReflectionClass($classPath);
            if(!$reflection->isAbstract() && !$reflection->isInterface()){
                $command = new $classPath;
                if($command instanceof BaseCommand){
                    $this->registerCommand($command);
                }
            }
        }
    }

    /**
     * Adds the provided command to the command map
     *
     * @param BaseCommand $command
     */
    function registerCommand(BaseCommand $command){
        $this->registeredCommands[mb_strtolower($command->getName())] = $command;
    }

    /**
     * Removes all the commands from the command map
     */
    function unregisterAll(){
        $this->registeredCommands = [];
    }

    /**
     * Attempts to remove the provided command from the command map
     *
     * @param BaseCommand $command
     */
    function unregisterCommand(BaseCommand $command){
        unset($this->registeredCommands[mb_strtolower($command->getName())]);
    }
}