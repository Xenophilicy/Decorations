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
use Xenophilicy\Decorations\archive\ArchiveEntry;
use Xenophilicy\Decorations\Decorations;
use Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms\CustomForm;
use Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms\Form;

/**
 * Class RemoveFromArchiveForm
 * @package Xenophilicy\Decorations\forms
 */
class RemoveFromArchiveForm extends CustomForm implements FormConstants {
    
    /** @var ArchiveEntry */
    private $entry;
    
    public function __construct(ArchiveEntry $entry, Form $previousForm){
        $this->entry = $entry;
        parent::__construct(self::TITLE, $previousForm);
        $this->addLabel(TF::LIGHT_PURPLE . "How many of this decoration would you like to move from your archive to your inventory?");
        $limit = $entry->getStored();
        $this->addSlider(TF::BLUE . "Amount", 1, $limit, self::AMOUNT);
    }
    
    /**
     * Children classes should implement this method to properly
     * deal with non-null player responses.
     * @param Player $player
     * @param        $data
     */
    public function onResponse(Player $player, $data): void{
        $amount = $data[self::AMOUNT];
        $item = $this->entry->getDecoration()->convertToItem($amount);
        $player->getInventory()->canAddItem($item) ? $player->getInventory()->addItem($item) : $player->dropItem($item);
        Decorations::getInstance()->getArchiveManager()->getArchive($player->getName())->removeStored($this->entry->getDecoration()->getId(), $amount);
        $form = new AlertForm(TF::GREEN . "You moved " . TF::AQUA . $amount . "x " . $this->entry->getDecoration()->getFormat() . TF::GREEN . " to your inventory", new
        ArchiveListForm($player, new MainForm()));
        $player->sendForm($form);
    }
}
