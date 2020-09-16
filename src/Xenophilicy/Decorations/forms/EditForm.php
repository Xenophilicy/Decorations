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
use Xenophilicy\Decorations\entity\DecorationEntity;
use Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms\CustomForm;
use Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms\Form;

/**
 * Class EditForm
 * @package Xenophilicy\Decorations\forms
 */
class EditForm extends CustomForm implements FormConstants {
    
    /** @var Decoration */
    private $decoration;
    /** @var DecorationEntity */
    private $entity;
    /** @var array */
    private $steps = [self::X => [], self::Y => [], self::Z => []];
    
    public function __construct(Decoration $decoration, DecorationEntity $entity, Form $previousForm){
        $this->decoration = $decoration;
        $this->entity = $entity;
        parent::__construct(self::TITLE, $previousForm);
        $this->addSlider(TF::GOLD . "Yaw", 0, 360, self::YAW, -1, (int)$entity->getYaw());
        $this->addSlider(TF::GOLD . "Pitch", 0, 180, self::PITCH, -1, (int)$entity->getPitch());
        for($i = -0.5; $i < 0.6; $i += 0.1){
            array_push($this->steps[self::X], (string)($i + $entity->getX()));
            array_push($this->steps[self::Y], (string)($i + $entity->getY()));
            array_push($this->steps[self::Z], (string)($i + $entity->getZ()));
        }
        $this->addStepSlider(TF::GOLD . "X", self::X, $this->steps[self::X], array_search($entity->getX(), $this->steps[self::X]));
        $this->addStepSlider(TF::GOLD . "Y", self::Y, $this->steps[self::Y], array_search($entity->getY(), $this->steps[self::Y]));
        $this->addStepSlider(TF::GOLD . "Z", self::Z, $this->steps[self::Z], array_search($entity->getZ(), $this->steps[self::Z]));
    }
    
    /**
     * Children classes should implement this method to properly
     * deal with non-null player responses.
     * @param Player $player
     * @param        $data
     */
    public function onResponse(Player $player, $data): void{
        $this->entity->yaw = $data[self::YAW];
        $this->entity->pitch = $data[self::PITCH];
        $this->entity->x = (float)($this->steps[self::X][$data[self::X]]);
        $this->entity->y = (float)($this->steps[self::Y][$data[self::Y]]);
        $this->entity->z = (float)($this->steps[self::Z][$data[self::Z]]);
        $form = new AlertForm(TF::GREEN . "Your options have been saved", $this->getPreviousForm());
        $player->sendForm($form);
    }
}
