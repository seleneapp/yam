<?php

/**
 * This File is part of the Yam package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Controllers;

use \Illuminate\View\Environment as View;

/**
 * @class LoginController
 * @package Yam
 * @version $Id$
 */
class ViewAwareController extends \BaseController
{
    /**
     * @param View $view
     *
     * @access public
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }
}
