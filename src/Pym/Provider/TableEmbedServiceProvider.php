<?php
namespace Pym\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Pym\TableEmbed;
use Pym\Table;

class TableEmbedServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['table.embed'] = $app->protect(function (Table $table) use ($app) {
            return new TableEmbed($app['db'], $table);
        });
    }

    public function boot(Application $app)
    {
    }
}
