<?php

/*
 * Copyright (c) 2019 tim03we  < https://github.com/tim03we >
 * Discord: tim03we | TP#9129
 *
 * This software is distributed under "GNU General Public License v3.0".
 * This license allows you to use it and/or modify it but you are not at
 * all allowed to sell this plugin at any cost. If found doing so the
 * necessary action required would be taken.
 *
 * KitUI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 *
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 */

namespace tim03we\kitui;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class KitCommand extends Command {

    public function __construct(KitUI $plugin, string $name, string $description, string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$this->testPermission($sender)) {
            return false;
        }
        if($sender instanceof Player) {
            $this->plugin->openKits($sender);
        } else {
            $sender->sendMessage("Run this command InGame.");
        }
        return false;
    }
}

