<?php

/**
 * @brief bigfoot, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\footnotes;

use Dotclear\App;
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Text;

class BackendBehaviors
{
    public static function adminBlogPreferencesForm(): string
    {
        $settings = My::settings();

        echo
        (new Fieldset('footnotes'))
        ->legend((new Legend(__('Footnotes'))))
        ->fields([
            (new Para())->items([
                (new Checkbox('footnotes_enabled', (bool) $settings->enabled))
                ->value(1)
                ->label((new Label(__('Enable Footnotes'), Label::INSIDE_TEXT_AFTER))),
            ]),
            (new Text('h5', __('Options'))),
            (new Para())->items([
                (new Checkbox('footnotes_single', (bool) $settings->single))
                ->value(1)
                ->label((new Label(__('Activate only in single entry context'), Label::INSIDE_TEXT_AFTER))),
            ]),
            (new Para())->items([
                (new Checkbox('footnotes_background', (bool) $settings->background))
                ->value(1)
                ->label((new Label(__('Set footnotes background'), Label::INSIDE_TEXT_AFTER))),
            ]),
        ])
        ->render();

        return '';
    }

    public static function adminBeforeBlogSettingsUpdate(): string
    {
        $settings = My::settings();

        $settings->put('enabled', !empty($_POST['footnotes_enabled']), App::blogWorkspace()::NS_BOOL);
        $settings->put('single', !empty($_POST['footnotes_single']), App::blogWorkspace()::NS_BOOL);
        $settings->put('background', !empty($_POST['footnotes_background']), App::blogWorkspace()::NS_BOOL);

        return '';
    }
}
