<?php

namespace libs\zPearlss;

use Legion\player\HCFPlayer;
use pocketmine\command\CommandSender;

abstract class BaseArgument
{

    public string $name = "";
    private bool $allowConsole;
    private string $permission = "";
    private string $description = "";

    public function __construct(string $name, bool $allowConsole, string $permission = "", string $description = "")
    {
        $this->name = $name;
        $this->allowConsole = $allowConsole;
        $this->permission = $permission;
        $this->description = $description;
    }

    abstract public function execute(CommandSender $sender, array $args): bool;

    public function canConsoleExecute(): bool
    {
        return $this->allowConsole;
    }

    public function getPermission(): string
    {
        return $this->permission;
    }

    public function hasPermission(): bool
    {
        if(!empty($this->permission) && $this->permission !== "") return true;

        return false;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getName(): string
    {
        return $this->name;
    }
}