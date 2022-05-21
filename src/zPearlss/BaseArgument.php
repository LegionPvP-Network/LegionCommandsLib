<?php

namespace zPearlss;

use pocketmine\command\CommandSender;

abstract class BaseArgument
{

    public string $name = "";
    private bool $allowConsole;
    private string $permission = "";

    public function __construct(string $name, bool $allowConsole, string $permission = "")
    {
        $this->name = $name;
        $this->allowConsole = $allowConsole;
        $this->permission = "";
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
        if(!empty($this->permission)) return true;

        return false;
    }
}