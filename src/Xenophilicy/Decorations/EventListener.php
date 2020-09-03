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

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use Xenophilicy\Decorations\decoration\Decoration;
use Xenophilicy\Decorations\entity\DecorationEntity;

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
    
    /**
     * @ignoreCancelled true
     * @param EntityDamageByEntityEvent $event
     */
    public function onLootBoxHit(EntityDamageByEntityEvent $event): void{
        $damager = $event->getDamager();
        $entity = $event->getEntity();
        if(!$entity instanceof DecorationEntity) return;
        $event->setCancelled();
        if(!$damager instanceof Player) return;
        $id = $entity->namedtag->hasTag(Decoration::DECO_ID) ? $entity->namedtag->getString(Decoration::DECO_ID) : null;
    }
}