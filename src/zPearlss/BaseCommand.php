<?php

namespace zPearlss;

use pocketmine\plugin\Plugin;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\utils\TextFormat;

class BaseCommand extends Command
{
    private array $arguments = [];

    public function __construct(Plugin $plugin, string $name, string $description = "", string $usage = "", array $aliases = [])
    {
        parent::__construct($name, $description, $usage, $aliases);
    }

    private function registerArgument(BaseArgument $arg, string $name): void
    {
        $this->arguments[$name] = $arg;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if (!isset($args[0])) {
            $sender->sendMessage(TextFormat::RED . "Please specify an argument.");
            return false;
        }

        $argument = strtolower($args[0]);
        if (!isset($this->arguments[$argument])) {
            $sender->sendMessage(TextFormat::RED . "No argument found with the name '" . $argument . "'");
            return false;
        }

        $command = $this->arguments[$argument];
        array_shift($args);

        if($sender instanceof ConsoleCommandSender && !$command->canConsoleExecute()){
            $sender->sendMessage(TextFormat::RED . "This command can only be executed in-game!");
            return false;
        }

        if($command->hasPermission() && !$sender->hasPermission($command->getPermission())){
            $sender->sendMessage($sender->getServer()->getLanguage()->translateString(TextFormat::RED . "%commands.generic.permission"));
            return false;
        }

        $command->execute($sender, $args);
        return true;
    }
}