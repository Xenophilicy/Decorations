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

use pocketmine\utils\TextFormat as TF;

/**
 * Interface FormConstants
 * @package Xenophilicy\Decorations\forms
 */
interface FormConstants {
    
    const TITLE = TF::BOLD . TF::GOLD . "Decorations";
    const CLOSE_TEXT = TF::BOLD . TF::RED . "Close";
    const BACK_TEXT = TF::BOLD . TF::RED . "Back";
    
    const CLOSE = "close";
    const BACK = "back";
    
    const SHOP = "shop";
    const MANAGE = "manage";
    
    const AMOUNT = "amount";
    const LOCATION = "location";
    
    const ARCHIVE = "archive";
    const SELL = "sell";
    const SPAWN = "spawn";
    const PICKUP = "pickup";
    const EDIT = "edit";
    
    const YAW = "yaw";
    const PITCH = "pitch";
    const X = "x";
    const Y = "y";
    const Z = "z";
}