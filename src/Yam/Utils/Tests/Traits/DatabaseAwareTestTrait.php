<?php

/**
 * This File is part of the Yam\Utils package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Utils\Tests\Traits;

use \PDO;
use \Mockery as m;
use \Illuminate\Container\Container;
use \Illuminate\Database\DatabaseManager;
use \Illuminate\Database\Connectors\ConnectionFactory;
use \Illuminate\Database\Schema\Builder as SchemaBuilder;

/**
 * @trait DatabaseAwareTestTrait
 *
 * @package Yam\Utils
 * @version $Id$
 * @author Thomas Appel <mail@thomas-appel.com>
 * @license MIT
 */
trait DatabaseAwareTestTrait
{
    /**
     * getDefaultConfig
     *
     *
     * @access protected
     * @return array
     */
    protected function getDefaultDBConfig()
    {
        return [
            'database.fetch' => PDO::FETCH_CLASS,
            'database.default' => 'sqlite',
            'database.connections' => [
                'sqlite' => [
                    'driver'   => 'sqlite',
                    'database' => ':memory:',
                    'prefix'   => '',
                ]
            ]
        ];
    }

    /**
     * prepareDatabase
     *
     * @param $array $config
     *
     * @access protected
     * @return void
     */
    protected function prepareDatabase(array $config = [])
    {
        $config = array_merge_recursive($this->getDefaultDBConfig(), $config);

        $container = m::mock('Illuminate\Container\Container');
        $container->shouldReceive('bound')->andReturn(false);

        $container->shouldReceive('offsetGet')->with('config')->andReturn($config);

        $db = new DatabaseManager(
            $container,
            new ConnectionFactory($container)
        );

        $connection = $db->connection('sqlite');
        $connection->setSchemaGrammar(new \Illuminate\Database\Schema\Grammars\SQLiteGrammar);
        $connection->setQueryGrammar(new \Illuminate\Database\Query\Grammars\SQLiteGrammar);

        $this->db = $db;
        $this->schema = new SchemaBuilder($connection);
    }
}
