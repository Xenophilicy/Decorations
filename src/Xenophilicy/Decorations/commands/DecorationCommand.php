<?php
# MADE BY:
#  __    __                                          __        __  __  __
# /  |  /  |                                        /  |      /  |/  |/  |
# $$ |  $$ |  ______   _______    ______    ______  $$ |____  $$/ $$ |$$/   _______  __    __
# $$  \/$$/  /      \ /       \  /      \  /      \ $$      \ /  |$$ |/  | /       |/  |  /  |
#  $$  $$<  /$$$$$$  |$$$$$$$  |/$$$$$$  |/$$$$$$  |$$$$$$$  |$$ |$$ |$$ |/$$$$$$$/ $$ |  $$ |
#   $$$$  \ $$    $$ |$$ |  $$ |$$ |  $$ |$$ |  $$ |$$ |  $$ |$$ |$$ |$$ |$$ |      $$ |  $$ |
#  $$ /$$  |$$$$$$$$/ $$ |  $$ |$$ \__$$ |$$ |__$$ |$$ |  $$ |$$ |$$ |$$ |$$ \_____ $$ \__$$ |
# $$ |  $$ |$$       |$$ |  $$ |$$    $$/ $$    $$/ $$ |  $$ |$$ |$$ |$$ |$$       |$$    $$ |
# $$/   $$/  $$$$$$$/ $$/   $$/  $$$$$$/  $$$$$$$/  $$/   $$/ $$/ $$/ $$/  $$$$$$$/  $$$$$$$ |
#                                         $$ |                                      /  \__$$ |
#                                         $$ |                                      $$    $$/
#                                         $$/                                        $$$$$$/

namespace Xenophilicy\Decorations\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat as TF;
use Xenophilicy\Decorations\Decorations;
use Xenophilicy\Decorations\forms\MainForm;

/**
 * Class DecorationCommand
 * @package Xenophilicy\Decorations\commands
 */
class DecorationCommand extends Command implements PluginIdentifiableCommand {
    
    public function __construct(){
        parent::__construct("decoration");
        $this->setAliases(["deco"]);
        $this->setPermission("decorations.menu");
        $this->setDescription("Decorations menu");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(TF::RED . "You don't have permission to view the decoration menu");
            return false;
        }
        if(!$sender instanceof Player){
            $sender->sendMessage(TF::RED . "This is an in-game command only");
            return false;
        }
        $form = new MainForm();
        $sender->sendForm($form);
        return true;
    }
    
    public function getPlugin(): Plugin{
        return Decorations::getInstance();
    }
}