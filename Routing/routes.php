<?php

use Dom\HTMLElement;
use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;

return [
    'snippets/new' => function(): HTMLRenderer{
        return new HTMLRenderer('component/snippets-new');
    },
    'api/snippets/create' => function(): JSONRenderer{
        $url = DatabaseHelper::saveSnippet();
        return new JSONRenderer(['url'=>$url]);
    },
    'snippets/get' => function(): HTMLRenderer{
        $slug = $_GET['slug'];
        return new HTMLRenderer('component/snippets-view', ['slug'=>$slug]);
    },
    'api/snippets/get' => function(): JSONRenderer{
        $snippetInfo = DatabaseHelper::getContent();
        return new JSONRenderer(['snippetInfo'=>$snippetInfo]);
    },
];