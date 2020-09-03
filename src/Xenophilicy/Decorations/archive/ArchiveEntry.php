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

use Xenophilicy\Decorations\decoration\Decoration;

/**
 * Class ArchiveEntry
 * @package Xenophilicy\Decorations\decoration
 */
class ArchiveEntry {
    
    /** @var Decoration */
    private $decoration;
    /**@var int */
    private $stored;
    /**@var int */
    private $spawned;
    
    public function __construct(Decoration $decoration, int $spawned, int $stored){
        $this->decoration = $decoration;
        $this->stored = $stored;
        $this->spawned = $spawned;
    }
    
    public function getDecoration(): Decoration{
        return $this->decoration;
    }
    
    public function getSpawned(): int{
        return $this->spawned;
    }
    
    public function setSpawned(int $count): void{
        $this->spawned = $count;
    }
    
    public function getStored(): int{
        return $this->stored;
    }
    
    public function setStored(int $count): void{
        $this->stored = $count;
    }
}