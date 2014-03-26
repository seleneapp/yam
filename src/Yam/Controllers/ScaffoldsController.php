<?php

/**
 * This File is part of the Yam\Controllers package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Controllers;

class ScaffoldsController extends ViewAwareController
{
    public function showIndex()
    {
        return $this->view->make('yam::scaffolds.index');
    }
}
