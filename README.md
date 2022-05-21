# LegionCommandsLib
Custom Command Library to easily handle Arguments/SubCommands.

**INFORMATION:**
This library allows you to easily handle Arguments/SUbCommands,
BaseCommand automaticly does checks on the CommandSender, such as:
 - Permissions check (for subcommand and normal command)
 - Sends a message to the sender if there are arguments registered but no given arguments by the sender.
 - Sends a message to the sender if the given argument is invalid.
 - Checks if the command/subcommand can be used via console. if not the ConsoleCommandSender will receive a message.

**NOTE:** Works but still kinda WIP.

#Command Example.

```php
class YourCommand extends BaseCommand
{

    public function __construct()
    {
        parent::__construct(Plugin $plugin, string $commandName, string $commandDescription, string $usage = "", array $aliases = []); //$commandDescription, $usage, $aliases are Optional.
        
        $this->registerArgument(new TestArgument(bool $allowConsole, string $permission = ""), string $subCommandName); //$permission is Optional.
        
        //adding an argument is Optional. if none are added, the command will execute itself normally and not check for registered BaseArgument arguments.
    }

    public function onExecute(CommandSender $sender, array $arguments): bool
    {
        return true; //return a value according to the command. 
        //as example: if the player does not have the right item in his inventory you will return it as false.
    }
}
```

#Argument Example.
```php
<?php
class TestArgument extends BaseArgument
{

    public function execute(CommandSender $sender, array $args): bool
    {
        return true; //return a value according to the command. 
        //as example: if the player does not have the right item in his inventory you will return it as false.
    }
}
```
