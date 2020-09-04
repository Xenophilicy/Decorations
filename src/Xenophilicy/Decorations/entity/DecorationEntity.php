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

namespace Xenophilicy\Decorations\entity;

use pocketmine\entity\Human;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use Xenophilicy\Decorations\decoration\Decoration;
use Xenophilicy\Decorations\Decorations;

/**
 * Class DecorationEntity
 * @package Xenophilicy\Decorations\entity
 */
class DecorationEntity extends Human {
    
    const DECO_ID = "decoID";
    const OWNER = "owner";
    protected $gravity = 0;
    public $height = 0;
    public $width = 0;
    
    public function __construct(Level $level, CompoundTag $nbt){
        parent::__construct($level, $nbt);
    }
    
    public function getOwner(): string{
        return $this->namedtag->getString(self::OWNER);
    }
    
    public function getDecoration(): Decoration{
        return Decorations::getInstance()->getDecorationManager()->getDecoration($this->namedtag->getString(self::DECO_ID));
    }
}