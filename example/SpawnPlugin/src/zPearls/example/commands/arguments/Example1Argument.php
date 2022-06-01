<?php

namespace zPearls\example\commands\arguments;

use libs\zPearlss\BaseArgument; // (my lib)

use pocketmine\command\CommandSender;
use pocketmine\Server;

class Example1Argument extends BaseArgument
{

    public function execute(CommandSender $sender, array $args): bool
    {
        $sender->sendMessage("§a§lYou succesfully executed Example Argument #1.");
        return true;
    }
}
