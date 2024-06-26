<?php
declare(strict_types=1);

namespace BeeAZZ\SimpleHubDelay;

use pocketmine\command\{Command, CommandSender};
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    public function onEnable() : void {
        $this->saveDefaultConfig();
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
        if (in_array($command->getName(), ["hub", "lobby", "spawn"])) {
            if (!$sender instanceof Player) {
                $sender->sendMessage($this->getConfig()->get("message-useingame"));
                return true;
            }
            if ($sender->hasPermission("simplehubdelay.command")) {
                $delay = (int)$this->getConfig()->get("delay");
                $message = str_replace("{SECOND}", (string)$delay, $this->getConfig()->get("message-delay"));
                $sender->sendMessage($message);
                $this->getScheduler()->scheduleDelayedTask(new UpdateTask($this, $sender), 20 * $delay);
            }
        }
        return true;
    }
}
