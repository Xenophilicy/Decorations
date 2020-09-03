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

/**
 * Class AlertForm
 * @package Xenophilicy\Decorations\forms
 */
class AlertForm extends SimpleForm implements FormConstants {
    
    public function __construct(string $text, Form $previousForm = null){
        parent::__construct(self::TITLE, $previousForm);
        $this->setContent($text);
        $button = is_null($previousForm) ? self::BACK_TEXT : self::CLOSE_TEXT;
        $this->addButton($button, self::CLOSE);
    }
    
    /**
     * Children classes should implement this method to properly
     * deal with non-null player responses.
     * @param Player $player
     * @param        $data
     */
    public function onResponse(Player $player, $data): void{
        if($data === self::CLOSE) return;
        $form = $this->getPreviousForm();
        $player->sendForm($form);
    }
}
