<?php

namespace libs\zPearlss;

use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\Server;
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
            if(isset($args[0]) && $args[0] === "help"){
                $sender->sendMessage(TextFormat::RED . "This command has no arguments.");
                return true;
            }

            $this->onExecute($sender, $args);
            return true;
        }

        if (!isset($args[0])) {
            $sender->sendMessage(TextFormat::RED . "Please specify an argument.");
            return false;
        }

        $argument = strtolower($args[0]);
        if($argument === "help"){
            $this->sendArgumentList($sender, $args[1] ?? null);
            return true;
        }elseif (!isset($this->arguments[$argument])) {
            $sender->sendMessage(TextFormat::RED . "No argument found with the name '" . $argument . "'");
            return false;
        }

        $subcommand = $this->arguments[$argument];
        array_shift($args);

        if($sender instanceof ConsoleCommandSender && !$subcommand->canConsoleExecute()){
            $sender->sendMessage(TextFormat::RED . "This command can only be executed in-game!");
            return false;
        }

        if($subcommand->hasPermission() && !Server::getInstance()->isOp($sender->getName()) && !$sender->hasPermission($subcommand->getPermission())){
            $sender->sendMessage($sender->getServer()->getLanguage()->translateString(TextFormat::RED . "%commands.generic.permission"));
            return false;
        }

        $subcommand->execute($sender, $args);
        return true;
    }

    public function sendArgumentList(Player|CommandSender $sender, null|int $givenPage): void
    {
        $subcommands = $this->arguments;

        $commandsPerPage = $sender instanceof Player ? 5 : count($subcommands);
        $maxPages = (int)ceil(count($subcommands) / $commandsPerPage);
        $page = $givenPage ?? 1;
        $page = min($page, $maxPages);
        $pageCommands = array_slice($subcommands, $commandsPerPage * ($page - 1), $commandsPerPage);

        $message = TextFormat::DARK_RED . TextFormat::BOLD . "Team Help: ". TextFormat::RESET . TextFormat::GRAY ."($page/$maxPages)";

        foreach ($pageCommands as $pageCommand) {
            $message .= "\n". TextFormat::RED . "/".$this->getName(). " " .$pageCommand->getName() . ($pageCommand->getDescription() !== "" ? TextFormat::GRAY . " - " . TextFormat::WHITE . $pageCommand->getDescription() : "");
        }

        $sender->sendMessage(TextFormat::DARK_GRAY."".str_repeat("-", 25));
        $sender->sendMessage($message);
        $sender->sendMessage(TextFormat::DARK_GRAY."".str_repeat("-", 25));
    }

    abstract public function onExecute(CommandSender $sender, array $arguments): bool;
}