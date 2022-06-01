<?php

namespace zPearls\example\commands\arguments;

use libs\zPearlss\BaseArgument; // (my lib)

use pocketmine\command\CommandSender;
use pocketmine\Server;

class Example2Argument extends BaseArgument
{

    public function execute(CommandSender $sender, array $args): bool
    {
        $sender->sendMessage("§a§lYou succesfully executed Example Argument #2.");
      
        $sender->sendTip("poopy whoopy");
        $sender->teleport($player->getPosition()->asVector3()->add(0, 6, 0));
        return true;
    }
}
