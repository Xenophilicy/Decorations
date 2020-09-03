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
use BreathTakinglyBinary\libDynamicForms\SimpleForm;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use Xenophilicy\Decorations\decoration\DecorationCategory;
use Xenophilicy\Decorations\Decorations;

/**
 * Class ListDecorationsForm
 * @package Xenophilicy\Decorations\forms
 */
class ListDecorationsForm extends SimpleForm implements FormConstants {
    
    /** @var DecorationCategory */
    private $category;
    
    public function __construct(DecorationCategory $category, Form $previousForm){
        $this->category = $category;
        parent::__construct(self::TITLE, $previousForm);
        $this->setContent(TF::LIGHT_PURPLE . "Select a decoration to view");
        foreach($category->getAllDecorations() as $id => $decoration){
            $unit = Decorations::getInstance()->getEconomy()->getMonetaryUnit();
            $price = $decoration->getPrice() > 0 ? $decoration->getPrice() : "FREE";
            $this->addButton(TF::DARK_AQUA . $decoration->getFormat() . TF::GRAY . " | " . TF::DARK_GREEN . $unit . $price, $id);
        }
        $this->addButton(self::BACK_TEXT, self::BACK);
    }
    
    /**
     * Children classes should implement this method to properly
     * deal with non-null player responses.
     * @param Player $player
     * @param        $data
     */
    public function onResponse(Player $player, $data): void{
        if($data === self::BACK){
            $form = $this->getPreviousForm();
        }else{
            $decoration = $this->category->getDecoration($data);
            $form = new PrePurchaseForm($decoration, $this);
        }
        $player->sendForm($form);
    }
}
