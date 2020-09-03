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
use pocketmine\utils\TextFormat as TF;
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
    
    public function getCategory(): DecorationCategory{
        return $this->category;
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
    
    public function convertToItem(int $amount): Item{
        $item = Item::get(Item::BED, 0, $amount);
        $item->setCustomName($this->getFormat());
        $enchant = new EnchantmentInstance(new Enchantment(105, "Decoration", 0, 0, 0, 1), 1);
        $item->setLore([TF::AQUA . "Tap the ground to place me"]);
        $item->addEnchantment($enchant);
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
        $nbt = Entity::createBaseNBT($block->ceil()->add(.5, 1, .5));
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
        $entity->setImmobile(true);
        if(!is_null($this->nametag)) $entity->setNameTag($this->nametag);
        $entity->saveNBT();
        $entity->spawnToAll();
        $entity->sendData($entity->getViewers());
        return $entity;
    }
    
    public function getScale(): float{
        return $this->scale;
    }
}