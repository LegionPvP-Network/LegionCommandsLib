<?php

namespace zPearls\example\commands;

use zPearlss\{BaseCommand, BaseArgument}; // my lib

use zPearls\example\ExamplePlugin;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class NoArgumentsExampleCommand extends BaseCommand
{
    
    public function __construct(ExamplePlugin $plugin)
    {
        //format: $plugin, $name, $description, $usage, $aliases
        parent::__construct(HCF::getInstance(), "example1", "A command example with no arguments");
    }

    public function execute(CommandSender $sender, array $args): bool
    {
        $sender->sendMessage("Sexy lady <3");
        return true;
    }
}
