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
use Dotclear\Helper\Html\Form\Color;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Note;
use Dotclear\Helper\Html\Form\Number;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Table;
use Dotclear\Helper\Html\Form\Tbody;
use Dotclear\Helper\Html\Form\Td;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Form\Tr;

class BackendBehaviors
{
    public static function adminBlogPreferencesHeaders(): string
    {
        return My::cssLoad('admin.css');
    }

    public static function adminBlogPreferencesForm(): string
    {
        $settings = My::settings();

        $color_light = $settings->color_light ?? '#ffffff';
        $color_dark  = $settings->color_dark  ?? '#000000';

        echo
        (new Fieldset('footnotes'))
        ->legend((new Legend(__('Footnotes'))))
        ->fields([
            (new Para())
                ->items([
                    (new Checkbox('footnotes_enabled', (bool) $settings->enabled))
                        ->value(1)
                        ->label((new Label(__('Enable Footnotes'), Label::INSIDE_TEXT_AFTER))),
                ]),
            (new Text('h5', __('Options'))),
            (new Para())
                ->items([
                    (new Checkbox('footnotes_single', (bool) $settings->single))
                        ->value(1)
                        ->label((new Label(__('Activate only in single entry context'), Label::INSIDE_TEXT_AFTER))),
                ]),
            (new Para())
                ->items([
                    (new Checkbox('footnotes_background', (bool) $settings->background))
                        ->value(1)
                        ->label((new Label(__('Set footnotes background'), Label::INSIDE_TEXT_AFTER))),
                ]),
            (new Note())
                ->class(['form-note', 'info'])
                ->text(__('The background color of the actual footnotes, or the user-defined colors if enabled (see below) will be used.')),
            (new Para())
                ->items([
                    (new Checkbox('footnotes_colors', (bool) $settings->colors))
                        ->value(1)
                        ->label((new Label(__('Use an user-defined background color'), Label::INSIDE_TEXT_AFTER))),
                    (new Table())
                        ->class(['fitcontent', 'secondlevel'])
                        ->tbody(
                            (new Tbody())
                            ->rows([
                                (new Tr())
                                    ->items([
                                        (new Td())
                                            ->items([
                                                (new Label(__('Backgound color for footnotes:'), Label::OL_TF))
                                                    ->for('footnotes_color_light'),
                                            ]),
                                        (new Td())
                                            ->items([
                                                (new Color('footnotes_color_light', $color_light)),
                                            ]),
                                    ]),
                                (new Tr())
                                    ->items([
                                        (new Td())
                                            ->items([
                                                (new Label(__('Backgound color for footnotes (dark mode):'), Label::OL_TF))
                                                    ->for('footnotes_color_dark'),
                                            ]),
                                        (new Td())
                                            ->items([
                                                (new Color('footnotes_color_dark', $color_dark)),
                                            ]),
                                    ]),
                            ])
                        ),
                ]),
            (new Para())->items([
                (new Number('footnotes_area', 10, 90, $settings->area))
                    ->default(60)
                    ->label((new Label(__('Size of triggering area:'), Label::INSIDE_TEXT_BEFORE))->suffix(__('%'))),
            ]),
            (new Note())
                ->class('form-note')
                ->text(__('This refers to the size of the upper part of the display viewport where the content of a footnote link will be displayed. Recommended values range from 50% to 60% (default). Minimum value allowed is 10%, maximum allowed value is 90%.')),
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
        $settings->put('colors', !empty($_POST['footnotes_colors']), App::blogWorkspace()::NS_BOOL);
        $settings->put('color_light', App::backend()->themeConfig()->adjustColor($_POST['footnotes_color_light']), 'string');
        $settings->put('color_dark', App::backend()->themeConfig()->adjustColor($_POST['footnotes_color_dark']), 'string');
        $settings->put('area', (int) $_POST['footnotes_area'], App::blogWorkspace()::NS_INT);

        return '';
    }
}
