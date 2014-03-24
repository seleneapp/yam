<?php

/**
 * This File is part of the Yam\Entities\Validation package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Validators;

/**
 * @class ValidatorInterface
 * @package Yam\Entities\Validation
 * @version $Id$
 */
interface ValidatorInterface
{
    /**
     * with
     *
     * @param array $input
     *
     * @access public
     * @return mixed
     */
    public function validate(array $data);

    /**
     * passes
     *
     * @access public
     * @return mixed
     */
    public function fails();

    /**
     * fail
     *
     * @param array $messages
     *
     * @access public
     * @return mixed
     */
    public function fail(array $messages);

    /**
     * errors
     *
     * @access public
     * @return mixed
     */
    public function getErrors();
}
