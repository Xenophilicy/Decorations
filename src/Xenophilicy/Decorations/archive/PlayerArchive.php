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

namespace Xenophilicy\Decorations\archive;

use Xenophilicy\Decorations\Decorations;

/**
 * Class PlayerArchive
 * @package Xenophilicy\Decorations\archive
 */
class PlayerArchive {
    
    /** @var string */
    private $name;
    /** @var ArchiveEntry[] */
    private $entries = [];
    
    public function __construct(string $name, array $data){
        $this->name = $name;
        foreach($data as $datum){
            $id = $datum["id"];
            $spawned = $datum["spawned"] ?? 0;
            $stored = $datum["stored"] ?? 0;
            $decoration = Decorations::getInstance()->getDecorationManager()->getDecoration($id);
            $entry = new ArchiveEntry($decoration, $spawned, $stored);
            $this->entries[$id] = $entry;
        }
    }
    
    public function getAllEntries(): array{
        return $this->entries;
    }
    
    public function removeStored(string $id, int $amount): void{
        if(!isset($this->entries[$id])){
            $decoration = Decorations::getInstance()->getDecorationManager()->getDecoration($id);
            $this->entries[$id] = new ArchiveEntry($decoration, 0, 0);
            return;
        }
        $this->entries[$id]->setStored($this->entries[$id]->getStored() - $amount);
    }
    
    public function addStored(string $id, int $amount): void{
        $decoration = Decorations::getInstance()->getDecorationManager()->getDecoration($id);
        $previous = $this->entries[$id] ?? $this->entries[$id] = new ArchiveEntry($decoration, 0, 0);
        $previous->setStored($previous->getStored() + $amount);
    }
    
    public function removeSpawned(string $id, int $amount): void{
        if(!isset($this->entries[$id])){
            $decoration = Decorations::getInstance()->getDecorationManager()->getDecoration($id);
            $this->entries[$id] = new ArchiveEntry($decoration, 0, 0);
            return;
        }
        $this->entries[$id]->setSpawned($this->entries[$id]->getSpawned() - $amount);
    }
    
    public function addSpawned(string $id, int $amount): void{
        $decoration = Decorations::getInstance()->getDecorationManager()->getDecoration($id);
        $previous = $this->entries[$id] ?? $this->entries[$id] = new ArchiveEntry($decoration, 0, 0);
        $previous->setSpawned($previous->getSpawned() + $amount);
    }
    
    public function getTotalOwned(string $target): int{
        $count = 0;
        foreach($this->entries as $id => $archiveEntry){
            if($id === $target) $count += $archiveEntry->getStored() + $archiveEntry->getSpawned();
        }
        return $count;
    }
    
    public function getEntry(string $id): ArchiveEntry{
        $decoration = Decorations::getInstance()->getDecorationManager()->getDecoration($id);
        return $this->entries[$id] ?? new ArchiveEntry($decoration, 0, 0);
    }
    
    public function getName(): string{
        return $this->name;
    }
    
    public function getAllSpawned(): array{
        $entries = [];
        foreach($this->entries as $id => $archiveEntry){
            if($archiveEntry->getSpawned() > 0) $entries[$id] = $archiveEntry;
        }
        return $entries;
    }
    
    public function getAllStored(): array{
        $entries = [];
        foreach($this->entries as $id => $archiveEntry){
            if($archiveEntry->getStored() > 0) $entries[$id] = $archiveEntry;
        }
        return $entries;
    }
}