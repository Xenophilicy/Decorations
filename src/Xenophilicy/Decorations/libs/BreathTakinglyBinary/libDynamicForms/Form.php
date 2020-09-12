<?php
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms;

use pocketmine\form\Form as IForm;
use pocketmine\Player;

abstract class Form implements IForm {
    
    const TYPE_CUSTOM = 2;
    const TYPE_MODAL = 1;
    const TYPE_SIMPLE = 0;
    
    /** @var array */
    protected $data = [];
    
    /** @var ?Form */
    private $previousForm;
    
    public function __construct(int $type, string $title = "", ?Form $previousForm = null){
        $this->setType($type);
        $this->data["title"] = $title;
        $this->previousForm = $previousForm;
    }
    
    /**
     * @param int $type
     * @throws \InvalidArgumentException
     */
    final private function setType(int $type){
        $typeString = "";
        switch($type){
            case 0:
                $typeString = "form";
                break;
            case 1:
                $typeString = "modal";
                break;
            case 2:
                $typeString = "custom_form";
                break;
            default:
                throw new \InvalidArgumentException("Invalid value of $type passed to Form::setType()");
        }
        $this->data["type"] = $typeString;
    }
    
    /**
     * @param string $title
     */
    public function setTitle(string $title): void{
        $this->data["title"] = $title;
    }
    
    /**
     * @return string
     */
    public function getTitle(): string{
        return (isset($this->data["title"]) and is_string($this->data["title"])) ? (string)$this->data["title"] : "";
    }
    
    /**
     * @return ?Form
     */
    public function getPreviousForm(): ?Form{
        return $this->previousForm;
    }
    
    public function handleResponse(Player $player, $data): void{
        $this->processData($data);
        if($data === null){
            $this->onClose($player);
            return;
        }
        $this->onResponse($player, $data);
    }
    
    public function processData(&$data): void{
    }
    
    /**
     * This method is called when a player closes the form without sending an response.
     * @param Player $player
     */
    public function onClose(Player $player): void{
    
    }
    
    /**
     * Children classes should implement this method to properly
     * deal with non-null player responses.
     * @param Player $player
     * @param        $data
     */
    public abstract function onResponse(Player $player, $data): void;
    
    public function jsonSerialize(){
        return $this->data;
    }
}
