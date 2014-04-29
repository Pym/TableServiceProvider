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

            $app['table.dbs'] = isset($app['table.dbs']) ? $app['table.dbs'] : array();

            $app['table.tables'] = isset($app['table.tables']) ? $app['table.tables'] : array();

            $tablesCollection = array();

            $initTables = function ($tables, $db = null) use ($app, &$tablesCollection) {
                if ($db !== null) $tablesCollection[$db] = array();
                foreach ($tables as $tableAlias => $tableName) {
                    if (is_int($tableAlias)) $tableAlias = null;
                    $table = new Table(
                        $db !== null ? $app['dbs'][$db] : $app['db'],
                        $tableName,
                        $tableAlias,
                        array_keys($app['table.tables'])
                    );
                    if ($db === null) {
                        $tablesCollection[$tableName] = $table;
                    } else {
                        $tablesCollection[$db][$tableName] = $table;
                    }
                    unset($table);
                }
            };

            if (isset($app['dbs.options'])) {
                foreach ($app['table.dbs'] as $db => $tables) {
                    if (isset($app['dbs'][$db])) $initTables($tables, $db);
                }
            } else {
                $initTables($app['table.tables']);
            }

            return $tablesCollection;
        });
    }

    public function boot(Application $app)
    {
    }
}
