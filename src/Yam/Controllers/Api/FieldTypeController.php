<?php

/**
 * This File is part of the Yam\Controllers\Api package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Controllers\Api;

/**
 * @class FieldTypeController
 * @package Yam\Controllers\Api
 * @version $Id$
 */
class FieldTypeController extends \BaseController
{
    public function getTypes()
    {
        $result = \DB::table('field_types')->get();

        return $result;
    }
}
