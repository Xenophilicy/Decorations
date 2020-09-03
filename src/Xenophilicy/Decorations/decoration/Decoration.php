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

namespace Xenophilicy\Decorations\decoration;

use pocketmine\entity\Entity;
use pocketmine\entity\Skin;
use pocketmine\Player;
use Xenophilicy\Decorations\Decorations;
use Xenophilicy\Decorations\entity\DecorationEntity;

/**
 * Class Decoration
 * @package Xenophilicy\Decorations\decoration
 */
class Decoration {
    
    const DECO_ID = "decoID";
    
    /** @var DecorationCategory */
    private $category;
    /** @var string */
    private $id;
    /** @var array */
    private $model;
    /** @var float */
    private $scale;
    /** @var string */
    private $format;
    /** @var int */
    private $price;
    /** @var array */
    private $skinData;
    /** @var string|null */
    private $nametag;
    /** @var int|null */
    private $limit;
    
    public function __construct(DecorationCategory $category, string $id, array $model, float $scale, string $format, int $price, ?int $limit, string $nametag = null){
        $this->category = $category;
        $this->id = $id;
        $this->model = $model;
        $this->scale = $scale;
        $this->format = $format;
        $this->price = $price;
        $this->limit = $limit;
        $this->nametag = $nametag;
    }
    
    public function getPlayerLimit(): ?int{
        return $this->limit;
    }
    
    public function getFormat(): string{
        return $this->format;
    }
    
    public function getCategory(): DecorationCategory{
        return $this->category;
    }
    
    public function getScale(): float{
        return $this->scale;
    }
    
    public function getPrice(): int{
        return $this->price;
    }
    
    public function buildImage(): bool{
        $path = Decorations::getInstance()->getDecorationDirectory(false);
        if(!file_exists($path . $this->model["texture"])) return false;
        if(!file_exists($path . $this->model["geometry"])) return false;
        $image = imagecreatefrompng($path . $this->model["texture"]);
        $l = (int)@getimagesize($path . $this->model["texture"])[1];
        if(!$l || !$image) return false;
        $bytes = "";
        for($y = 0; $y < $l; $y++){
            for($x = 0; $x < 64; $x++){
                $rgba = @imagecolorat($image, $x, $y);
                $a = ((~((int)($rgba >> 24))) << 1) & 0xff;
                $r = ($rgba >> 16) & 0xff;
                $g = ($rgba >> 8) & 0xff;
                $b = $rgba & 0xff;
                $bytes .= chr($r) . chr($g) . chr($b) . chr($a);
            }
        }
        @imagedestroy($image);
        $this->skinData = [$bytes, file_get_contents($path . $this->model["geometry"])];
        return true;
    }
    
    public function spawn(Player $player): ?Entity{
        $nbt = Entity::createBaseNBT($player, null, $player->getYaw(), $player->getPitch());
        $nbt->setString(self::DECO_ID, $this->getId());
        $player->saveNBT();
        $skinTag = $player->namedtag->getCompoundTag("Skin");
        assert($skinTag !== null);
        $nbt->setTag($skinTag);
        /** @var DecorationEntity $entity */
        $entity = Entity::createEntity("DecorationEntity", $player->getLevel(), $nbt);
        $entity->setSkin(new Skin("Decorations", $this->skinData[0], "", $this->model["identifier"], $this->skinData[1]));
        $entity->sendSkin();
        if(!is_null($this->nametag)) $entity->setNameTag($this->nametag);
        $entity->spawnToAll();
        return $entity;
    }
    
    public function getId(): string{
        return $this->id;
    }
}