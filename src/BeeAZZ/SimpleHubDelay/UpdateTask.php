<?php
declare(strict_types=1);

namespace BeeAZZ\SimpleHubDelay;

use pocketmine\scheduler\Task;
use pocketmine\player\Player;

class UpdateTask extends Task {

    protected Main $main;
    protected Player $player;

    public function __construct(Main $main, Player $player) {
        $this->main = $main;
        $this->player = $player;
    }

    public function onRun() : void {
        if ($this->player->isOnline()) {
            $this->player->teleport($this->main->getServer()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
            $this->player->sendMessage($this->main->getConfig()->get("message-success"));
        }
    }
}
