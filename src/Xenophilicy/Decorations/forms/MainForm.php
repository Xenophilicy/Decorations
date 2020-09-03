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

namespace Xenophilicy\Decorations\forms;

use BreathTakinglyBinary\libDynamicForms\SimpleForm;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use Xenophilicy\Decorations\Decorations;

/**
 * Class MainForm
 * @package Xenophilicy\Decorations\forms
 */
class MainForm extends SimpleForm implements FormConstants {
    
    public function __construct(){
        parent::__construct(self::TITLE);
        $this->setContent(TF::LIGHT_PURPLE . "Welcome to the Decorations menu");
        if(Decorations::getSetting("enable-shop")) $this->addButton(TF::GREEN . "Shop", self::SHOP);
        $this->addButton(TF::YELLOW . "My decorations", self::MANAGE);
        $this->addButton(self::CLOSE_TEXT, self::CLOSE);
    }
    
    /**
     * Children classes should implement this method to properly
     * deal with non-null player responses.
     * @param Player $player
     * @param        $data
     */
    public function onResponse(Player $player, $data): void{
        switch($data){
            case self::SHOP:
                $form = new ShopForm($this);
                break;
            case self::MANAGE:
                break;
            default:
                return;
        }
        $player->sendForm($form);
    }
}
