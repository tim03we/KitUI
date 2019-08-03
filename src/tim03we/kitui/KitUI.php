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

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class KitUI extends PluginBase implements Listener {

    public $playerfile, $kits;

    public function onEnable()
    {
        $this->saveResource("config.yml");
        $this->saveResource("kits.yml");
        $this->kits = new Config($this->getDataFolder() . "kits.yml", Config::YAML);
        $this->getServer()->getCommandMap()->register("kit", new KitCommand($this, "kit", "KitUI Command", "/kit"));
    }

    public function openKits($player) {
        $form = new SimpleForm(function (Player $player, $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            $kit = $data;
            if($player->getArmorInventory()->getHelmet()) {
                if($player->getInventory()->canAddItem(Item::get($player->getArmorInventory()->getHelmet()->getId()))) {
                    $player->getInventory()->addItem(Item::get($player->getArmorInventory()->getHelmet()->getId()));
                    $player->getArmorInventory()->clear(0);
                } else {
                    $player->sendMessage($this->getConfig()->getNested("messages.not-addable"));
                    return true;
                }
            }
            if($player->getArmorInventory()->getChestplate()) {
                if($player->getInventory()->canAddItem(Item::get($player->getArmorInventory()->getChestplate()->getId()))) {
                    $player->getInventory()->addItem(Item::get($player->getArmorInventory()->getChestplate()->getId()));
                    $player->getArmorInventory()->clear(1);
                } else {
                    $player->sendMessage($this->getConfig()->getNested("messages.not-addable"));
                    return true;
                }
            }
            if($player->getArmorInventory()->getLeggings()) {
                if($player->getInventory()->canAddItem(Item::get($player->getArmorInventory()->getLeggings()->getId()))) {
                    $player->getInventory()->addItem(Item::get($player->getArmorInventory()->getLeggings()->getId()));
                    $player->getArmorInventory()->clear(2);
                } else {
                    $player->sendMessage($this->getConfig()->getNested("messages.not-addable"));
                    return true;
                }
            }
            if($player->getArmorInventory()->getBoots()) {
                if($player->getInventory()->canAddItem(Item::get($player->getArmorInventory()->getBoots()->getId()))) {
                    $player->getInventory()->addItem(Item::get($player->getArmorInventory()->getBoots()->getId()));
                    $player->getArmorInventory()->clear(3);
                } else {
                    $player->sendMessage($this->getConfig()->getNested("messages.not-addable"));
                    return true;
                }
            }
            foreach ($this->kits->getNested($kit . ".items") as $items) {
                $ex = explode(":", $items);
                $player->getInventory()->addItem(Item::get($ex[0], $ex[1], $ex[2]));
            }
            $player->getArmorInventory()->setHelmet(Item::get($this->kits->getNested($kit . ".helmet")));
            $player->getArmorInventory()->setChestplate(Item::get($this->kits->getNested($kit . ".chestplate")));
            $player->getArmorInventory()->setLeggings(Item::get($this->kits->getNested($kit . ".leggings")));
            $player->getArmorInventory()->setBoots(Item::get($this->kits->getNested($kit . ".boots")));
            $player->sendMessage(str_replace("{kit}", "$kit", $this->getConfig()->getNested("messages.success")));
        });
        $form->setTitle($this->getConfig()->getNested("messages.forms.title"));
        $form->setContent($this->getConfig()->getNested("messages.forms.content"));
        foreach ($this->kits->getAll() as $kit => $name) {
            $form->addButton($kit, -1, "", $kit);
        }
        $form->sendToPlayer($player);
    }
}