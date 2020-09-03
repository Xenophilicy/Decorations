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
use Xenophilicy\Decorations\Decorations;
use Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms\Form;
use Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms\SimpleForm;

/**
 * Class ShopForm
 * @package Xenophilicy\Decorations\forms
 */
class ShopForm extends SimpleForm implements FormConstants {
    
    public function __construct(Form $previousForm){
        parent::__construct(self::TITLE, $previousForm);
        $this->setContent(TF::LIGHT_PURPLE . "Choose a category to browse");
        foreach(Decorations::getInstance()->getDecorationManager()->getAllCategories() as $name => $category){
            $this->addButton($category->getFormat(), $name);
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
            $category = Decorations::getInstance()->getDecorationManager()->getCategory($data);
            $form = new ListDecorationsForm($category, $this);
        }
        $player->sendForm($form);
    }
}
