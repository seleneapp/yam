<?php

/**
 * This File is part of the Yam\Content\Validators package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Validators;

use \Illuminate\Validation\Validator;

/**
 * @class SlugValidator
 * @package Yam\Content\Validators
 * @version $Id$
 */
class SlugValidator extends Validator
{
    protected $messages = [
        'validation.handle' => ':handle has invalid characters'
    ];
    /**
     * validateSlug
     *
     * @param mixed $attribute
     * @param mixed $value
     * @param mixed $parameters
     *
     * @access public
     * @return boolean
     */
    public function validateSlug($attribute, $value, $parameters)
    {
        return !(bool)preg_match('~([^a-z0-9\-\_]|[^\x00-\x7F])~', $value);
    }

    /**
     * validateHandle
     *
     * @param mixed $attribute
     * @param mixed $value
     * @param mixed $parameters
     *
     * @access public
     * @return mixed
     */
    public function validateHandle($attribute, $value, $parameters)
    {
        return !(bool)preg_match('~([^a-z0-9\_]|[^\x00-\x7F])~', $value);
    }

    /**
     * replaceSlug
     *
     * @param mixed $message
     * @param mixed $attribute
     * @param mixed $rule
     * @param mixed $parameters
     *
     * @access protected
     * @return string
     */
    protected function replaceSlug($message, $attribute, $rule, $parameters)
    {
        return str_replace(':slug', $attribute, $message);
    }

    /**
     * replaceHandle
     *
     * @param mixed $message
     * @param mixed $attribute
     * @param mixed $rule
     * @param mixed $parameters
     *
     * @access protected
     * @return mixed
     */
    protected function replaceHandle($message, $attribute, $rule, $parameters)
    {
        return str_replace(':handle', $attribute, $message);
    }
}
