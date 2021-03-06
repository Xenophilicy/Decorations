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

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\entity\Skin;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use Xenophilicy\Decorations\Decorations;
use Xenophilicy\Decorations\entity\DecorationEntity;

/**
 * Class Decoration
 * @package Xenophilicy\Decorations\decoration
 */
class Decoration {
    
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
    /** @var array|null */
    private $rotation;
    /** @var array|null */
    private $range;
    
    public function __construct(DecorationCategory $category, string $id, array $datum){
        $this->category = $category;
        $this->id = $datum["id"] ?? null;
        $this->model = $datum["model"] ?? [];
        $this->scale = $datum["scale"] ?? 1;
        $this->format = $datum["format"] ?? $id;
        $this->price = $datum["price"] ?? 0;
        $this->limit = $datum["limit"] ?? null;
        $this->nametag = $datum["nametag"] ?? null;
        $this->rotation = $datum["rotation"] ?? [];
        $this->range = $datum["scale-range"] ?? null;
    }
    
    public function getPlayerLimit(): ?int{
        return $this->limit;
    }
    
    public function getCategory(): DecorationCategory{
        return $this->category;
    }
    
    public function getPrice(): int{
        return $this->price;
    }
    
    public function getScaleRange(): ?array{
        return $this->range;
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
    
    public function convertToItem(int $amount): Item{
        $item = Item::get(Decorations::$settings["item"]["id"], Decorations::$settings["item"]["damage"], $amount);
        $item->setCustomName($this->getFormat());
        $item->setLore([Decorations::$settings["item"]["lore"]]);
        $enchant = new EnchantmentInstance(new Enchantment(105, "Decoration", 0, 0, 0, 1), 1);
        if(Decorations::$settings["item"]["enchantment"]) $item->addEnchantment($enchant);
        $item->getNamedTag()->setString(DecorationEntity::DECO_ID, $this->getId());
        return $item;
    }
    
    public function getFormat(): string{
        return $this->format;
    }
    
    public function getId(): string{
        return $this->id;
    }
    
    public function spawn(Player $player, Block $block): ?Entity{
        Decorations::getInstance()->getArchiveManager()->getArchive($player->getName())->addSpawned($this->getId(), 1);
        $nbt = Entity::createBaseNBT($block->ceil()->add(.5, 1, .5), null, $this->getYaw() ?? 0, $this->getPitch() ?? 0);
        $nbt->setString(DecorationEntity::DECO_ID, $this->getId());
        $nbt->setString(DecorationEntity::OWNER, $player->getName());
        $player->saveNBT();
        $skinTag = $player->namedtag->getCompoundTag("Skin");
        assert($skinTag !== null);
        $nbt->setTag($skinTag);
        /** @var DecorationEntity $entity */
        $entity = Entity::createEntity("Decoration", $block->getLevel(), $nbt);
        $entity->getDataPropertyManager()->setFloat(Entity::DATA_SCALE, $this->getScale());
        $entity->setSkin(new Skin("Decorations", $this->skinData[0], "", $this->model["identifier"], $this->skinData[1]));
        $entity->sendSkin();
        if(!is_null($this->nametag)) $entity->setNameTag($this->nametag);
        $entity->saveNBT();
        $entity->spawnToAll();
        $entity->sendData($entity->getViewers());
        return $entity;
    }
    
    public function getYaw(): ?int{
        return $this->rotation["yaw"] ?? null;
    }
    
    public function getPitch(): ?int{
        return $this->rotation["pitch"] ?? null;
    }
    
    public function getScale(): float{
        return $this->scale;
    }
}