<?php
namespace Pym\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Pym\Table;

class TableServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['table'] = $app->share(function ($app) {

            $app['table.tables'] = isset($app['table.tables']) ? $app['table.tables'] : array();

            $tables = array();
            foreach ($app['table.tables'] as $tableAlias => $tableName) {
                if (is_int($tableAlias)) $tableAlias = null;
                $tables[$tableName] = new Table($app['db'], $tableName, $tableAlias, array_keys($app['table.tables']));
            }

            return $tables;
        });
    }

    public function boot(Application $app)
    {
    }
}
