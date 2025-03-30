<?php
use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;

return [
    'index' => function(): JSONRenderer{
        $url = DatabaseHelper::saveSnippet();
        return new JSONRenderer(['url'=>$url]);
    },
    'api' => function(): JSONRenderer{
        $snippetInfo = DatabaseHelper::getContent();
        return new JSONRenderer(['snippetInfo'=>$snippetInfo]);
    },
    'snippets' => function(): HTMLRenderer{
        $slug = $_GET['slug'];
        return new HTMLRenderer('component/snippets', ['slug'=>$slug]);
    }
];