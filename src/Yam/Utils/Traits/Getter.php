<?php

/**
 * This File is part of the lib\yam\src\Yam\Utils\Traits package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Utils\Traits;

/**
 * Shamelesly stolen from the selene framework.
 * @class Getter
 * @package lib\yam\src\Yam\Utils\Traits
 * @version $Id$
 */
trait Getter
{
    /**
     * getDefault
     *
     * @param array $propertyList
     * @param string $key
     * @param mixed $default
     *
     * @access public
     * @return mixed
     */
    protected function getDefault($propertyList, $key, $default = null)
    {
        return isset($propertyList[$key]) ? $propertyList[$key] : $default;
    }

    /**
     * getDefaultUsing
     *
     * @param mixed $propertyList
     * @param mixed $key
     * @param callable $defaultGetter
     *
     * @access protected
     * @return mixed
     */
    protected function getDefaultUsing($propertyList, $key, callable $defaultGetter)
    {
        return isset($propertyList[$key]) ? $propertyList[$key] : call_user_func_array($defaultGetter, [$propertyList]);
    }

    /**
     * getDefaultUsingKeys
     *
     * @param mixed $propertyList
     * @param mixed $key
     * @param mixed $default
     *
     * @access protected
     * @return mixed
     */
    protected function getDefaultUsingKeys($propertyList, $key, $default = null)
    {
        return array_key_exists($key, $propertyList) ? $propertyList[$key] : $default;
    }
}
