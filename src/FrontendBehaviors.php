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
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\footnotes;

use Dotclear\App;
use Dotclear\Helper\Html\Html;

class FrontendBehaviors
{
    public static function publicHeadContent(): string
    {
        $settings = My::settings();
        if (!$settings->enabled) {
            return '';
        }

        if ($settings->single) {
            // Single mode only, check if post/page context
            $urlTypes = ['post'];
            if (App::plugins()->moduleExists('pages')) {
                $urlTypes[] = 'pages';
            }

            if (!in_array(App::url()->getType(), $urlTypes)) {
                return '';
            }
        }

        // Prepare footnotes background color
        $color = '';
        if ($settings->colors) {
            $light = $settings->color_light;
            $dark  = $settings->color_dark;
            $color = sprintf(
                'light-dark(%s, %s)',
                (string) $light,
                (string) $dark
            );
        }

        echo
        Html::jsJson('flightnotes', [
            'background' => $settings->background ?? true,
            'color'      => $color,
            'area'       => $settings->area,
        ]) .
        My::cssLoad('footnotes.css') .
        My::jsLoad('footnotes.js');

        return '';
    }
}
