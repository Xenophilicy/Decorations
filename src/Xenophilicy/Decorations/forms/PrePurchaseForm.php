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

use BreathTakinglyBinary\libDynamicForms\CustomForm;
use BreathTakinglyBinary\libDynamicForms\Form;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use Xenophilicy\Decorations\decoration\Decoration;

/**
 * Class PrePurchaseForm
 * @package Xenophilicy\Decorations\forms
 */
class PrePurchaseForm extends CustomForm implements FormConstants {
    
    /** @var Decoration */
    private $decoration;
    
    public function __construct(Decoration $decoration, Form $previousForm){
        $this->decoration = $decoration;
        parent::__construct(self::TITLE, $previousForm);
        $this->addLabel(TF::LIGHT_PURPLE . "How many do you want?");
        $limit = $decoration->getPlayerLimit() ?? 64;
        $this->addSlider(TF::BLUE . "Amount", 1, $limit, self::AMOUNT);
    }
    
    /**
     * Children classes should implement this method to properly
     * deal with non-null player responses.
     * @param Player $player
     * @param        $data
     */
    public function onResponse(Player $player, $data): void{
        $form = new ConfirmPurchaseForm($this->decoration, $data[self::AMOUNT], $this);
        $player->sendForm($form);
    }
}
