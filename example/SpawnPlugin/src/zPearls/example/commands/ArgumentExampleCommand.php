<?php

namespace zPearls\example\commands;

use zPearlss\{BaseCommand, BaseArgument}; // my lib

use zPearls\example\commands\arguments\{Example1Argument, Example2Argument};
use zPearls\example\ExamplePlugin;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class ArgumentExampleCommand extends BaseCommand
{
    
    public function __construct(ExamplePlugin $plugin)
    {
        parent::__construct(HCF::getInstance(), "example2", "A command example with 2 arguments");
        
        //to provide a permission for this command do: 
        //$this->setPermission("yourpermission.example");
        
        //you can also provide permissions PER argument.
        
        //how to register argument:
        //heres an argument list to create the command argument:
        // args #0: the command argument object. object|class|(required)
        // args #1: do you want console to be able to execute this command argument? bool|true:false|(required)
        // args #2: the permission to execute this command argument: string|(optional) <-- leave empty: "", if you want to add argument #3
        // args #3: the description of the command argument: string|(optional)
        
        $this->registerArgument(new Example1Argument("argument1"), true); // execute: /example2 argument1 <-- no permission required. since theres no args #3 (executeable via console)
        $this->registerArgument(new Example2Argument("argument2"), false, "example.argument1.permission", "test Command"); // execute: /example2 argument2 <-- permission 'example.argument1.permission' required (NOT executeable via console)
    }

    public function execute(CommandSender $sender, array $args): bool
    {
        return true;
    }
}
