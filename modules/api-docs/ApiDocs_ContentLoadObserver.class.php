<?php

class ApiDocs_ContentLoadObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // редактор документации
        Engine::GetContentDataSource()->registerContent(
            'doc-editor',
            array(
                'title' => 'Doc-editor',
                'url' => array('/doc-editor/', '/doc-editor/{key}'),
                'filehtml' => dirname(__FILE__).'/contents/doc_editor.html',
                'filejs' => dirname(__FILE__).'/contents/doc_editor.js',
                'filecss' => dirname(__FILE__).'/contents/doc_editor.css',
                'filephp' => dirname(__FILE__).'/contents/doc_editor.php',
                'moveto' => 'doc-editor-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'doc-editor-tpl',
            array(
                'filehtml' => dirname(__FILE__).'/contents/doc_editor_tpl.html',
                'filephp' => dirname(__FILE__).'/contents/doc_editor_tpl.php',
                'level' => '2',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
            ),
            'override'
        );
    }

}