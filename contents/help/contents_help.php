<?php
Engine::GetContentDataSource()->registerContent(
    'help-tpl',
    array(
        'filehtml' => dirname(__FILE__).'/help_tpl.html',
        'filejs' => dirname(__FILE__).'/help_tpl.js',
        'filephp' => dirname(__FILE__).'/help_tpl.php',
        'filecss' => dirname(__FILE__).'/help_tpl.css',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'help-menu',
    array(
        'filehtml' => dirname(__FILE__).'/help_menu.html',
        'filephp' => dirname(__FILE__).'/help_menu.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'help-index',
    array(
        'title' => 'Документация',
        'url' => '/doc/',
        'filehtml' => PROJECT_PATH.'/docs/index.html',
        'moveto' => 'help-tpl',
        'moveas' => 'content',
    ),
    'override'
);

$pageArray = Shop_ModuleLoader::Get()->getHelpItemArray();
foreach ($pageArray as $page) {
    $pageKey = $page['key'];
    $pageTitle = $page['title'];
    $pageFile = $page['file'];

    Engine::GetContentDataSource()->registerContent(
        'help-'.$pageKey,
        array(
            'title' => $pageTitle,
            'url' => '/doc/'.$pageKey,
            'filehtml' => $pageFile,
            'moveto' => 'help-tpl',
            'moveas' => 'content',
        ),
        'override'
    );
}