<?php

namespace Ponponumi\BreadcrumbCreate;

class Create
{
    private string $listTag = "ul";
    private string $itemTag = "li";
    private $spanMode = false;

    public function __construct(string $tagMode = "ul", $spanMode = false)
    {
        switch($tagMode){
            case "ol":
                $this->listTag = "ol";
                break;
            case "div":
                $this->listTag = "div";
                $this->itemTag = "div";
                break;
        }

        $this->spanMode = $spanMode;
    }

    public function htmlCreate(array $data, array $option=[])
    {
        $html = "<" . $this->listTag;
    }
}
