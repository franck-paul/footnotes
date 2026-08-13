<?php

/**
 * @brief footnotes, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul contact@open-time.net
 * @copyright GPL-2.0
 */
declare(strict_types=1);

if (isset($this) && is_object($this) && method_exists($this, 'registerModule') && isset($this->id) && is_string($this->id)) {
    $this->registerModule(
        'footnotes',
        'Footnotes',
        'Franck Paul',
        '4.0',
        [
            'date'        => '2003-08-13T13:42:00+04.0',
            'requires'    => [['core', '2.39']],
            'permissions' => 'My',
            'type'        => 'plugin',
            'settings'    => [
                'blog' => '#params.footnotes',
            ],

            'details'    => 'https://open-time.net/?q=footnotes',
            'support'    => 'https://github.com/franck-paul/footnotes',
            'repository' => 'https://raw.githubusercontent.com/franck-paul/footnotes/main/dcstore.xml',
            'license'    => 'gpl2',
        ]
    );
}
