<?php
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms;

abstract class ModalForm extends Form {
    
    /** @var string */
    private $content = "";
    
    
    public function __construct(string $title = "", ?Form $previousForm = null){
        parent::__construct(self::TYPE_MODAL, $title, $previousForm);
        $this->data["content"] = $this->content;
        $this->data["button1"] = "";
        $this->data["button2"] = "";
    }
    
    /**
     * @return string
     */
    public function getContent(): string{
        return $this->data["content"];
    }
    
    /**
     * @param string $content
     */
    public function setContent(string $content): void{
        $this->data["content"] = $content;
    }
    
    /**
     * @param string $text
     */
    public function setButton1(string $text): void{
        $this->data["button1"] = $text;
    }
    
    /**
     * @return string
     */
    public function getButton1(): string{
        return $this->data["button1"];
    }
    
    /**
     * @param string $text
     */
    public function setButton2(string $text): void{
        $this->data["button2"] = $text;
    }
    
    /**
     * @return string
     */
    public function getButton2(): string{
        return $this->data["button2"];
    }
}
