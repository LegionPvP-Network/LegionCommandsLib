<?php

namespace zPearls\example;

use pocketmine\plugin\{Plugin, PluginBase};
use zPearls\example\commands\{NoArgumentsExampleCommand, ArgumentExampleCommand};

class ExamplePlugin extends PluginBase
{
    
    public function onEnable(): void
    {
        $this->getServer()->getCommandMap()->register('/example1', new NoArgumentsExampleCommand($this)); //$this === Plugin === PluginBase//
    }
    
    public function onDisable(): void
    {
        
    }
}
