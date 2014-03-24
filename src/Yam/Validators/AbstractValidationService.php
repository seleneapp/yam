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

use \Illuminate\Support\MessageBag;
use \Illuminate\Validation\Factory as Validator;

/**
 * @class AbstractValidationService
 * @package Yam\Entities\Validation
 * @version $Id$
 */
abstract class AbstractValidationService implements ValidatorInterface
{
    /**
     * validaor
     *
     * @var mixed
     */
    protected $validaor;

    /**
     * errors
     *
     * @var mixed
     */
    protected $errors;

    /**
     * delegates
     *
     * @var mixed
     */
    protected $delegates;

    /**
     * __construct
     *
     * @param Validator $validator
     * @param mixed $
     * @param mixed $rules
     *
     * @access public
     * @return mixed
     */
    public function __construct(Validator $validator = null)
    {
        $this->delegates = [];
        $this->validator = $validator;
    }

    /**
     * with
     *
     * @param array $input
     *
     * @access public
     * @return mixed
     */
    public function with(array $input)
    {
        $this->data = $input;
    }

    /**
     * passes
     *
     * @access public
     * @return mixed
     */
    public function validate(array $data)
    {
        $errored = false;
        $this->errors = null;

        $validator = $this->createValidator($data);

        if ($validator->fails()) {
            $this->errors = $validator->messages();
            $errored = true;
        }

        $this->data = null;
        return !$errored;
    }

    /**
     * fails
     *
     * @access public
     * @return boolean
     */
    public function fails()
    {
        return null !== $this->errors;
    }

    /**
     * fail
     *
     * @param array $messages
     *
     * @access public
     * @return mixed
     */
    public function fail(array $messages)
    {
        $errors = new MessageBag($messages);

        if ($this->errors) {
            $errors->merge($this->errors);
        }

        $this->errors = $errors;
    }

    /**
     * errors
     *
     * @access public
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * createValidator
     *
     * @access protected
     * @return mixed
     */
    protected function createValidator(array $data)
    {
        return $this->getValidator()->make($data, static::$rules);
    }

    /**
     * getValidator
     *
     * @access protected
     * @return Validator
     */
    protected function getValidator()
    {
        if (null === $this->validator) {
            $this->validator = \Validator::getFacadeRoot();
        }

        return $this->validator;
    }
}
