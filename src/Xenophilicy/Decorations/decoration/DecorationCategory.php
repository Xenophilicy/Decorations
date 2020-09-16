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

use Xenophilicy\Decorations\Decorations;

/**
 * Class DecorationCategory
 * @package Xenophilicy\Decorations\decoration
 */
class DecorationCategory {
    
    /** @var string */
    private $name;
    /** @var Decoration[] */
    private $decorations = [];
    /** @var string */
    private $format;
    
    public function __construct(string $name, array $data){
        $this->name = $name;
        $this->format = $data["format"] ?? $name;
        foreach($data["entities"] as $datum){
            $id = $datum["id"] ?? null;
            $model = $datum["model"] ?? [];
            $limit = $datum["limit"] ?? null;
            if(is_null($id) || count($model) !== 3 || (!is_null($limit) && $limit < 1)){
                $id = is_null($id) ? "no ID" : $id;
                Decorations::getInstance()->getLogger()->critical("Decoration $id has invalid values");
                continue;
            }
            $decoration = new Decoration($this, $id, $datum);
            if(!$decoration->buildImage()){
                Decorations::getInstance()->getLogger()->critical("Decoration $id has invalid or missing geometry data");
                continue;
            }
            $this->decorations[$id] = $decoration;
        }
    }
    
    public function getDecoration(string $targetId): ?Decoration{
        return $this->decorations[$targetId] ?? null;
    }
    
    public function getAllDecorations(): array{
        return $this->decorations;
    }
    
    public function getName(): string{
        return $this->name;
    }
    
    public function getFormat(): string{
        return $this->format;
    }
}