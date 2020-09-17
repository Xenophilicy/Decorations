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

use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use Xenophilicy\Decorations\decoration\DecorationCategory;
use Xenophilicy\Decorations\Decorations;
use Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms\Form;
use Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms\SimpleForm;

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
            $price = $decoration->getPrice();
            $price = $unit . ($price > 0 ? $price : "FREE");
            $this->addButton(TF::DARK_AQUA . $decoration->getFormat() . TF::GRAY . " | " . TF::DARK_GREEN . $price, $id);
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
            $archive = Decorations::getInstance()->getArchiveManager()->getArchive($player->getName());
            $owned = $archive->getTotalOwned($decoration->getId());
            $limit = ($decoration->getPlayerLimit() ?? 64) - $owned;
            if($limit === 0){
                $form = new AlertForm(TF::RED . "You already have the maximum allowed amount of this decoration. You cannot purchase any more until you remove some or sell some from your archive", $this);
            }else{
                $form = new AmountForm($decoration, $limit, $this);
            }
        }
        $player->sendForm($form);
    }
}
