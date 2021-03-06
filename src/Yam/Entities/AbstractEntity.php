<?php

/**
 * This File is part of the Yam\Entities package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Entities;

use \Yam\Utils\Traits\Getter;
use \Aura\Marshal\Lazy\LazyInterface;
use \Aura\Marshal\Entity\GenericEntity;
use \Illuminate\Support\Contracts\JsonableInterface;
use \Illuminate\Support\Contracts\ArrayableInterface;

/**
 * @class AbstractEntity extends GenericEntity implements ArrayableInterface, JsonableInterface
 * @see ArrayableInterface
 * @see JsonableInterface
 * @see GenericEntity
 *
 * @package Yam\Entities
 * @version $Id$
 * @author Thomas Appel <mail@thomas-appel.com>
 * @license MIT
 */
class AbstractEntity extends GenericEntity implements EntityInterface, ArrayableInterface, JsonableInterface
{
    use Getter;

    /**
     * dirty
     *
     * @var boolean
     */
    protected $dirty = false;

    /**
     * original
     *
     * @var array
     */
    protected $original;

    /**
     * @param array $data
     *
     * @access public
     */
    public function __construct(array $data)
    {
        $this->initializeData($data);
        $this->original = $this->data;
    }

    /**
     * fill
     *
     * @param array $data
     *
     * @access portected
     * @return void
     */
    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * we are dirty or not. lets play.
     *
     * @access public
     * @return bool
     */
    public function isDirty()
    {
        $o = $this->original;

        if (!$this->dirty) {
            foreach ($this->data as $key => $d) {
                if (//$d === null ||
                    $d instanceof LazyInterface ||
                    (array_key_exists($key, $o) && $o[$key] === $d)
                ) {
                    continue;
                }
                $this->dirty = true;
                break;
            }
        }
        return (boolean)$this->dirty;
    }

    /**
     * getAttributeValue
     *
     * @param mixed $attr
     * @param mixed $value
     *
     * @access public
     * @return mixed
     */
    public function getAttributeValue($attr, $value)
    {
        if (method_exists($this, $method = 'get'.ucfirst(camel_case($attr)).'AttributeValue')) {
            return call_user_func([$this, $method], $value);
        }

        return $value;
    }

    /**
     * setAttributeValue
     *
     * @param mixed $attr
     * @param mixed $value
     *
     * @access public
     * @return mixed
     */
    public function setAttributeValue($attr, $value)
    {
        if (method_exists($this, $method = 'set'.ucfirst(camel_case($attr)).'AttributeValue')) {
            return call_user_func([$this, $method], $value);
        }

        return $value;
    }

    /**
     * setAttribute
     *
     * @param mixed $attr
     * @param mixed $value
     *
     * @access public
     * @return void
     */
    public function setAttribute($attr, $value = null)
    {
        return $this->offsetSet($attr, $value);
    }

    /**
     * getAttribute
     *
     * @param mixed $attr
     * @param mixed $default
     *
     * @access public
     * @return mixed
     */
    public function getAttribute($attr, $default = null)
    {
        return $this->offsetGet($attr);
    }

    /**
     * offsetGet
     *
     * @param mixed $attr
     *
     * @access public
     * @return mixed
     */
    public function offsetGet($attr)
    {
        if (null === $this->getDefault($this->data, $attr, null)) {
            return;
        }
        return parent::offsetGet($attr);
    }

    /**
     * getData
     *
     * @access public
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * toArray
     *
     * @access public
     * @return array
     */
    public function toArray()
    {
        return $this->dataGetClean();
    }

    /**
     * toJson
     *
     * @param int $options
     *
     * @access public
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * dataGetClean
     *
     * @access protected
     * @return mixed
     */
    protected function dataGetClean()
    {
        $clean = [];

        foreach ($this->data as $key => $data) {
            if ($data instanceof LazyInterface) {
                $value = null;
            } elseif ($data instanceof ArrayableInterface) {
                $value = $data->toArray();
            } elseif (is_object($data)) {
                $value = (array)$data;
            } else {
                $value = $data;
            }
            $clean[$key] = $this->getAttributeValue($key, $value);
            //$clean[$key] = $value;
        }
        return $clean;
    }

    /**
     * setDirty
     *
     * @param mixed $dirty
     *
     * @access protected
     * @return void
     */
    protected function setDirty($dirty)
    {
        $this->dirty = (boolean)$dirty;
    }

    /**
     * initializeData
     *
     * @param array $data
     *
     * @access protected
     * @return mixed
     */
    protected function initializeData(array $data)
    {
        return $this->fill($data);
    }

}
