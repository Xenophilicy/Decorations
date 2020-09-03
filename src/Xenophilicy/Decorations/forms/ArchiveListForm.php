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
 * Class ArchiveListForm
 * @package Xenophilicy\Decorations\forms
 */
class ArchiveListForm extends SimpleForm implements FormConstants {
    
    public function __construct(Player $player, Form $previousForm){
        parent::__construct(self::TITLE, $previousForm);
        $this->setContent(TF::LIGHT_PURPLE . "Choose a decoration to view");
        $archive = Decorations::getInstance()->getArchiveManager()->getArchive($player->getName());
        foreach($archive->getAllStored() as $id => $entry){
            $this->addButton(TF::GREEN . "(" . $entry->getStored() . ") " . TF::GREEN . $entry->getDecoration()->getFormat(), $id);
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
            $decoration = Decorations::getInstance()->getDecorationManager()->getDecoration($data);
            $form = new SettingsForm($decoration, $this);
        }
        $player->sendForm($form);
    }
}
