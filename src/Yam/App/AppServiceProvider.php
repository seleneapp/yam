<?php

/**
 * This File is part of the Yam\App package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\App;

use \Illuminate\Support\ServiceProvider;

/**
 * @class AppServiceProvider extends ServiceProvider
 * @see ServiceProvider
 *
 * @package Yam\App
 * @version $Id$
 * @author Thomas Appel <mail@thomas-appel.com>
 * @license MIT
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * register
     *
     * @access public
     * @return void
     */
    public function register()
    {
        $this->app['config']->package('yam/yam', $path = realpath(__DIR__.'/../../../config'), 'Yam');
    }

    /**
     * boot
     *
     * @access public
     * @return void
     */
    public function boot()
    {
        $this->package('yam/yam', 'yam', realpath(__DIR__.'/../../../'));


        // Register Html engine
        $this->app['view']->addExtension('html', 'html', function ()
        {
            return new Html;
        });


        $container = $this->app;
        \View::composer(['yam::master'], function ($view) use ($container) {
            $view->with('user', new \StdClass);
            //$view->with('user', \Sentry::getUser());
            $view->with('menu', $container['config']->get('yam::main.menu'));
        });


        //dd($this->app['config']);
    }

    /**
     * provides
     *
     * @access public
     * @return array
     */
    public function provides()
    {
        return ['yam/yam'];
    }
}
