<?php
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace Xenophilicy\Decorations\libs\BreathTakinglyBinary\libDynamicForms;

abstract class SimpleForm extends Form {
    
    const IMAGE_TYPE_PATH = 0;
    const IMAGE_TYPE_URL = 1;
    
    /** @var string */
    private $content = "";
    
    private $labelMap = [];
    
    
    public function __construct(string $title = "", ?Form $previousForm = null){
        parent::__construct(self::TYPE_SIMPLE, $title, $previousForm);
        $this->data["content"] = $this->content;
    }
    
    public function processData(&$data): void{
        $data = $this->labelMap[$data] ?? null;
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
     * @param string|null $label
     * @param int $imageType
     * @param string $imagePath
     */
    public function addButton(string $text, ?string $label = null, int $imageType = -1, string $imagePath = ""): void{
        $content = ["text" => $text];
        if($imageType !== -1){
            $content["image"]["type"] = $imageType === 0 ? "path" : "url";
            $content["image"]["data"] = $imagePath;
        }
        $this->data["buttons"][] = $content;
        $this->labelMap[] = $label ?? count($this->labelMap);
    }
    
}
