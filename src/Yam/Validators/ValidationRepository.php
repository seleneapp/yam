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

use \Yam\Utils\Traits\Getter;
use \Illuminate\Validation\Factory as Validator;

/**
 * @class ValidationRepository  ValidationRepository
 *
 * @package Yam\Entities\Validation
 * @version $Id$
 * @author Thomas Appel <mail@thomas-appel.com>
 * @license MIT
 */
class ValidationRepository
{
    use Getter;

    /**
     * storate
     *
     * @var mixed
     */
    protected $storage;

    /**
     * registry
     *
     * @var array
     */
    protected $registry;

    /**
     * @param Validator $validator
     *
     * @access public
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * register
     *
     * @param mixed $validator
     * @param mixed $implementation
     *
     * @access public
     * @return mixed
     */
    public function register($validator, $class)
    {
        $this->registry[$validator] = function () use ($class) {
            return new $class($this->validator);
        };
    }

    /**
     * get
     *
     * @param mixed $validator
     *
     * @access public
     * @return mixed
     */
    public function get($validator)
    {
        if ($validator = $this->getDefault($this->registry, $validator, false)) {
            return call_user_func($validator);
        }

        throw new \InvalidArgumentException(sprintf('no registered validator %s', $validator));
    }
}
