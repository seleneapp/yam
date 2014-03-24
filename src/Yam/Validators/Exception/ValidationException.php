<?php

/**
 * This File is part of the Yam\Validators\Exception package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Validators\Exception;

use \Illuminate\Support\MessageBag;

/**
 * @class ValidationException
 * @package Yam\Validators\Exception
 * @version $Id$
 */
class ValidationException extends \RuntimeException
{
    protected $errors;

    public function __construct($message, $errors)
    {
        $this->errors = [];
        $this->setErrors($errors);
        parent::__construct($message);
    }

    /**
     * getErrors
     *
     * @access public
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * setErrors
     *
     * @param mixed $errors
     * @param mixed $key
     *
     * @access protected
     * @return mixed
     */
    protected function setErrors($errors, $key = null) {
        if (is_array($errors)) {
            foreach ($errors as $key => $error) {
                $error = $error instanceof ArrayableInterface ? $error->toArray() : $error;
                $this->setError($error, $key);
            }
            return;
        }

        $this->setError($key ?: count($this->errors), $errors);

    }

    protected function setError($error, $key) {
        $this->errors[$key] = $error;
    }
}
