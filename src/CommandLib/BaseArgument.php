<?php

declare(strict_types=1);

namespace CommandLib;

use pocketmine\command\CommandSender;

abstract class BaseArgument
{

    private bool $allowConsole;
    private string $permission = "";

    public function __construct(bool $allowConsole, string $permission = "")
    {
        $this->allowConsole = $allowConsole;
        $this->permission = "";
    }

    abstract public function execute(CommandSender $sender, array $args);


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