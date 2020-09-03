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

use pocketmine\utils\Config;
use Xenophilicy\Decorations\Decorations;

/**
 * Class ArchiveManager
 * @package Xenophilicy\Decorations\archive
 */
class ArchiveManager {
    
    /** @var PlayerArchive[] */
    private $archives = [];
    /** @var array */
    private $data;
    /** @var Config */
    private $file;
    
    public function __construct(){
        Decorations::getInstance()->saveResource("archives.json");
        $this->file = new Config(Decorations::getInstance()->getDataFolder() . "archives.json");
        $this->data = $this->file->getAll();
    }
    
    public function getArchive(string $player): PlayerArchive{
        if(!isset($this->archives[$player])){
            $data = $this->data[$player] ?? [];
            $archive = new PlayerArchive($player, $data);
            $this->archives[$player] = $archive;
        }else{
            $archive = $this->archives[$player];
        }
        return $archive;
    }
    
    public function saveData(): void{
        foreach($this->archives as $player => $archive){
            $entries = [];
            foreach($archive->getAllEntries() as $id => $entry){
                $entryData = ["id" => $id, "spawned" => $entry->getSpawned(), "stored" => $entry->getStored()];
                array_push($entries, $entryData);
            }
            $this->data[$player] = $entries;
        }
        $this->file->setAll($this->data);
        $this->file->save();
    }
}