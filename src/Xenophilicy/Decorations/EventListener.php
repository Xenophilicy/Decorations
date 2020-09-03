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

namespace Xenophilicy\Decorations;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntitySpawnEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use Xenophilicy\Decorations\entity\DecorationEntity;
use Xenophilicy\Decorations\forms\SettingsForm;

/**
 * Class EventListener
 * @package Xenophilicy\Decorations
 */
class EventListener implements Listener {
    
    /** @var Decorations */
    private $plugin;
    
    public function __construct(Decorations $plugin){
        $this->plugin = $plugin;
    }
    
    public function onDamage(EntityDamageEvent $event): void{
        $entity = $event->getEntity();
        if(!$entity instanceof DecorationEntity) return;
        $event->setCancelled();
    }
    
    public function onDecorationSpawn(EntitySpawnEvent $event): void{
        $entity = $event->getEntity();
        if(!$entity instanceof DecorationEntity) return;
        $decoration = $entity->getDecoration();
        $entity->getDataPropertyManager()->setFloat(Entity::DATA_SCALE, $decoration->getScale());
        $entity->sendData($entity->getViewers());
    }
    
    /**
     * @priority HIGHEST
     * @param PlayerInteractEvent $event
     */
    public function onInteract(PlayerInteractEvent $event): void{
        if($event->isCancelled()) return;
        $item = $event->getItem();
        $player = $event->getPlayer();
        if($event->getAction() !== PlayerInteractEvent::RIGHT_CLICK_BLOCK) return;
        if($item->getId() !== Item::BED) return;
        if(!$item->getNamedTag()->hasTag(DecorationEntity::DECO_ID)) return;
        $event->setCancelled();
        $id = $item->getNamedTag()->getString(DecorationEntity::DECO_ID);
        $decoration = Decorations::getInstance()->getDecorationManager()->getDecoration($id);
        $archive = Decorations::getInstance()->getArchiveManager()->getArchive($player->getName());
        $owned = $archive->getEntry($id)->getSpawned();
        $limit = ($decoration->getPlayerLimit() ?? 64) - $owned;
        if($limit === 0){
            $player->sendMessage(TF::GREEN . "You already have the maximum allowed amount of this decoration.");
            return;
        }
        $decoration->spawn($player, $event->getBlock());
        $player->sendMessage(TF::GREEN . "Decoration has been placed");
        $player->getInventory()->removeItem($item->setCount(1));
    }
    
    /**
     * @ignoreCancelled true
     * @param EntityDamageByEntityEvent $event
     */
    public function onDecorationHit(EntityDamageByEntityEvent $event): void{
        $damager = $event->getDamager();
        $entity = $event->getEntity();
        if(!$entity instanceof DecorationEntity) return;
        $event->setCancelled();
        if(!$damager instanceof Player) return;
        if($entity->getOwner() !== $damager->getName()) return;
        $decoration = $entity->getDecoration();
        $form = new SettingsForm($decoration, null, $entity);
        $damager->sendForm($form);
    }
}