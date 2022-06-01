<?php

namespace zPearls\example;

use pocketmine\plugin\{Plugin, PluginBase};
use zPearls\example\commands\{NoArgumentsExampleCommand, ArgumentExampleCommand};

class ExamplePlugin extends PluginBase
{
    
    public function onEnable(): void
    {
        $this->getServer()->getCommandMap()->register('/logs', new NoArgumentsExampleCommand());
    }
    
    public function onDisable(): void
    {
        
    }
}
