<?php

/**
 * This File is part of the Yam\Validators package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Validators;

use \Illuminate\Support\ServiceProvider;

/**
 * @class ValidationServiceProvider extends ServiceProvider
 * @see ServiceProvider
 *
 * @package Yam\Validators
 * @version $Id$
 * @author Thomas Appel <mail@thomas-appel.com>
 * @license MIT
 */
class ValidationServiceProvider extends ServiceProvider
{
    /**
     * deferred
     *
     * @var mixed
     */
    protected $deferred = true;

    /**
     * @access public
     * @return mixed
     */
    public function register()
    {
        $this->app->bindShared('yam.validators', function () {
            return new ValidationRepository(\Validator::getFacadeRoot());
        });
    }

    /**
     * boot
     *
     * @access public
     * @return mixed
     */
    public function boot()
    {
        $results = $this->app['events']->fire('yam.validators.register');
        $validator = $this->app->make('yam.validators');

        foreach ((array)$results as $result) {
            $validator->register($result['name'], $result['class'], $result['rules']);
        }
    }

    public function provides()
    {
        return ['yam.validators'];
    }
}
