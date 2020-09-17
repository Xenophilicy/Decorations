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
use Xenophilicy\Decorations\decoration\Decoration;
use Xenophilicy\Decorations\Decorations;
use Xenophilicy\Decorations\entity\DecorationEntity;
use Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms\Form;
use Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms\SimpleForm;

/**
 * Class SettingsForm
 * @package Xenophilicy\Decorations\forms
 */
class SettingsForm extends SimpleForm implements FormConstants {
    
    /** @var DecorationEntity */
    private $entity;
    /** @var Decoration */
    private $decoration;
    
    public function __construct(Decoration $decoration, Form $previousForm = null, DecorationEntity $entity = null){
        $this->decoration = $decoration;
        $this->entity = $entity;
        parent::__construct(self::TITLE, $previousForm);
        if(is_null($entity)){
            $this->addButton(TF::GREEN . "Spawn", self::SPAWN);
        }else{
            $this->addButton(TF::GREEN . "Pick up", self::PICKUP);
            $this->addButton(TF::GOLD . "Archive", self::ARCHIVE);
            $this->addButton(TF::BLUE . "Edit", self::EDIT);
        }
        $this->addButton(TF::YELLOW . "Sell", self::SELL);
        $button = is_null($previousForm) ? self::CLOSE_TEXT : self::BACK_TEXT;
        $this->addButton($button, self::CLOSE);
    }
    
    /**
     * Children classes should implement this method to properly
     * deal with non-null player responses.
     * @param Player $player
     * @param        $data
     */
    public function onResponse(Player $player, $data): void{
        switch($data){
            case self::SPAWN:
                $entry = Decorations::getInstance()->getArchiveManager()->getArchive($player->getName())->getEntry($this->decoration->getId());
                $form = new RemoveFromArchiveForm($entry, new MainForm());
                break;
            case self::EDIT:
                $form = new EditForm($this->decoration, $this->entity, $this);
                break;
            case self::ARCHIVE:
                $this->entity->flagForDespawn();
                Decorations::getInstance()->getArchiveManager()->getArchive($this->entity->getOwner())->removeSpawned($this->decoration->getId(), 1);
                Decorations::getInstance()->getArchiveManager()->getArchive($player->getName())->addStored($this->decoration->getId(), 1);
                $form = new AlertForm(TF::GREEN . "Decoration has been added to your archive");
                break;
            case self::PICKUP:
                $this->entity->flagForDespawn();
                $item = $this->decoration->convertToItem(1);
                Decorations::getInstance()->getArchiveManager()->getArchive($this->entity->getOwner())->removeSpawned($this->decoration->getId(), 1);
                $player->getInventory()->canAddItem($item) ? $player->getInventory()->addItem($item) : $player->dropItem($item);
                $form = new AlertForm(TF::GREEN . "Decoration has been moved to your inventory");
                break;
            case self::SELL:
                $modifier = Decorations::getSetting("sell-percentage") / 100;
                $price = $this->decoration->getPrice() * $modifier;
                Decorations::getInstance()->getEconomy()->addMoney($player, $price);
                if(is_null($this->entity)){
                    Decorations::getInstance()->getArchiveManager()->getArchive($player->getName())->removeStored($this->decoration->getId(), 1);
                }else{
                    $this->entity->flagForDespawn();
                    Decorations::getInstance()->getArchiveManager()->getArchive($this->entity->getOwner())->removeSpawned($this->decoration->getId(), 1);
                }
                $unit = Decorations::getInstance()->getEconomy()->getMonetaryUnit();
                $form = new AlertForm(TF::YELLOW . "Decoration has been sold for " . TF::DARK_GREEN . ($unit . ($price > 0 ? $price : "FREE")));
                break;
            default:
                if(is_null($this->getPreviousForm())) return;
                $form = $this->getPreviousForm();
        }
        $player->sendForm($form);
    }
}
