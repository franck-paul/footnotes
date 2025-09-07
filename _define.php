<?php

/**
 * @brief footnotes, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0
 */
$this->registerModule(
    'footnotes',
    'Footnotes',
    'Franck Paul',
    '1.1',
    [
        'date'        => '2003-08-13T13:42:00+01.1',
        'requires'    => [['core', '2.36']],
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
