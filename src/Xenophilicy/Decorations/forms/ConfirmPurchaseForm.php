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

use BreathTakinglyBinary\libDynamicForms\Form;
use BreathTakinglyBinary\libDynamicForms\ModalForm;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use Xenophilicy\Decorations\decoration\Decoration;
use Xenophilicy\Decorations\Decorations;

/**
 * Class ConfirmPurchaseForm
 * @package Xenophilicy\Decorations\forms
 */
class ConfirmPurchaseForm extends ModalForm implements FormConstants {
    
    /** @var Decoration */
    private $decoration;
    /** @var int */
    private $amount;
    
    
    public function __construct(Decoration $decoration, int $amount, Form $previousForm){
        $this->decoration = $decoration;
        $this->amount = $amount;
        parent::__construct(self::TITLE, $previousForm);
        $unit = Decorations::getInstance()->getEconomy()->getMonetaryUnit();
        $price = $decoration->getPrice() > 0 ? $decoration->getPrice() : "FREE";
        $this->setContent(TF::YELLOW . "Please confirm you'd like to buy " . TF::AQUA . $amount . "x " . $decoration->getFormat() . TF::YELLOW . " for " . TF::DARK_GREEN . $unit . $price);
        $this->setButton1(TF::GREEN . "Confirm");
        $this->setButton2(TF::RED . "Back");
    }
    
    /**
     * Children classes should implement this method to properly
     * deal with non-null player responses.
     * @param Player $player
     * @param        $data
     */
    public function onResponse(Player $player, $data): void{
        if(!$data){
            $form = $this->getPreviousForm()->getPreviousForm();
        }else{
            $form = new AlertForm(TF::GREEN . "Decoration has been added to your archive", new MainForm());
        }
        $player->sendForm($form);
    }
}
