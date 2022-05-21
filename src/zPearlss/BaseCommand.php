<?php

namespace zPearlss;

use pocketmine\plugin\Plugin;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\utils\TextFormat;

abstract class BaseCommand extends Command
{
    private array $arguments = [];

    public function __construct(Plugin $plugin, string $name, string $description = "", string $usage = "", array $aliases = [])
    {
        parent::__construct($name, $description, $usage, $aliases);
    }

    public function registerArgument(BaseArgument $argument): void
    {
        $this->arguments[$argument->name] = $argument;
    }

    final public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if(!$this->testPermission($sender)){
            return false;
        }

        if(empty($this->arguments)){
            $this->onExecute($sender, $args);
            return true;
        }

        if (!isset($args[0])) {
            $sender->sendMessage(TextFormat::RED . "Please specify an argument.");
            return false;
        }

        $argument = strtolower($args[0]);
        if (!isset($this->arguments[$argument])) {
            $sender->sendMessage(TextFormat::RED . "No argument found with the name '" . $argument . "'");
            return false;
        }

        $subcommand = $this->arguments[$argument];
        array_shift($args);

        if($sender instanceof ConsoleCommandSender && !$subcommand->canConsoleExecute()){
            $sender->sendMessage(TextFormat::RED . "This command can only be executed in-game!");
            return false;
        }

        if($subcommand->hasPermission() && !$sender->hasPermission($subcommand->getPermission())){
            $sender->sendMessage($sender->getServer()->getLanguage()->translateString(TextFormat::RED . "%commands.generic.permission"));
            return false;
        }

        $subcommand->execute($sender, $args);
        return true;
    }

    abstract public function onExecute(CommandSender $sender, array $arguments): bool;
}