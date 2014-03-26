<?php

/**
 * This File is part of the lib\yam\src\Yam\Controller\Api\V1 package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Controllers\Api;

use \Input;
use \Yam\Article\Exceptions\InvalidContentException;

class TemplateController extends \BaseController
{
    /**
     * getSlug
     *
     * @param mixed $name
     *
     * @access public
     * @return mixed
     */
    public function getTemplate($template, $extension = null)
    {
        try {
            return \View::make('yam::templates/'.$template, ['foo' => 'bar']);
        } catch (\Exception $e) {
            throw ($e);
            return \App::abort(404);
        }
    }
}
