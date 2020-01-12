<?php

namespace AlvinMask\BankUI\Form;

class SimpleForm extends Form{

    private $content = "";
    private $labelMap = [];

    public function __construct(?callable $callable){
     parent::__construct($callable);
     $this->data["type"] = "form";
     $this->data["title"] = "";
     $this->data["content"] = $this->content;
    }

    public function processData(&$data):void{
     $data = $this->labelMap[$data] ?? null;
    }

    public function setTitle(string $title):void{
     $this->data["title"] = $title;
    }

    public function setContent(string $content):void{
     $this->data["content"] = $content;
    }

    public function addButton(string $text):void{
     $content = ["text" => $text];
     $this->data["buttons"][] = $content;
     $this->labelMap[] = $label ?? count($this->labelMap);
    }

}
