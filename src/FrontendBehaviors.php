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
                $urlTypes[] = 'page';
            }

            if (!in_array(App::url()->getType(), $urlTypes)) {
                return '';
            }
        }

        echo
        My::cssLoad('footnotes.css') .
        My::jsLoad('footnotes.js');

        return '';
    }
}
