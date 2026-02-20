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
        $text  = '';
        if ($settings->colors) {
            $isBrightColor = function (
                string $color,  // Must be in hexadecimal form (ex: #ab65c3), with or without # prefix ; may be shorten (ex: #fff)
            ): bool {
                $color = trim($color, '#');
                if (strlen($color) === 3) {
                    $color .= $color;
                }

                // Calculate the brightness of the color
                $red   = hexdec(substr($color, 0, 2));
                $green = hexdec(substr($color, 2, 2));
                $blue  = hexdec(substr($color, 4, 2));

                $brightness = (($red * 299) + ($green * 587) + ($blue * 114)) / 1000;

                // Return true if color is light, false if dark
                return $brightness >= 128;
            };

            $light = $settings->color_light;
            $dark  = $settings->color_dark;
            $color = sprintf(
                'light-dark(%s, %s)',
                (string) $light,
                (string) $dark
            );

            // We will use white or black color, depending on brightness of background
            $text = sprintf(
                'light-dark(%s, %s)',
                $isBrightColor((string) $light) ? '#000' : '#fff',
                $isBrightColor((string) $dark) ? '#000' : '#fff',
            );
        }

        echo
        Html::jsJson('flightnotes', [
            'background' => $settings->background ?? true,
            'color'      => $color,
            'text'       => $text,
            'area'       => $settings->area,
        ]) .
        My::cssLoad('footnotes.css') .
        My::jsLoad('footnotes.js');

        return '';
    }
}
