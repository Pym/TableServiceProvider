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

            $app['tables'] = isset($app['tables']) ? $app['tables'] : array();

            $tables = array();
            foreach ($app['tables'] as $tableAlias => $tableName) {
                if (is_int($tableAlias)) $tableAlias = null;
                $tables[$tableName] = new Table($app['db'], $tableName, $tableAlias);
            }

            return $tables;
        });
    }

    public function boot(Application $app)
    {
    }
}
