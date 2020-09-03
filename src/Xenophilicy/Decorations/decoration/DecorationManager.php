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

use pocketmine\utils\Config;
use Xenophilicy\Decorations\Decorations;

/**
 * Class DecorationManager
 * @package Xenophilicy\Decorations\decoration
 */
class DecorationManager {
    
    /** @var DecorationCategory[] */
    private $categories = [];
    
    public function __construct(){
        $file = new Config(Decorations::getInstance()->getDataFolder() . "decorations.json", Config::JSON);
        foreach($file->getAll() as $name => $data){
            $category = new DecorationCategory($name, $data);
            $this->categories[$name] = $category;
        }
    }
    
    public function getAllCategories(): array{
        return $this->categories;
    }
    
    public function getCategory(string $name): ?DecorationCategory{
        return $this->categories[$name] ?? null;
    }
    
    public function getDecoration(string $targetId): ?Decoration{
        foreach($this->categories as $name => $category){
            foreach($category->getAllDecorations() as $id => $item){
                if($item->getId() === $targetId) return $item;
            }
        }
        return null;
    }
}