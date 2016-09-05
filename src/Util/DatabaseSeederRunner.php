<?php

namespace Sledgehammer\Laravel\Util;
use Symfony\Component\Console\Output\BufferedOutput;

use DirectoryIterator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Facade;
use Sledgehammer\Core\Url;
use Sledgehammer\Core\Html;
use Sledgehammer\Devutils\Util;
use Sledgehammer\Mvc\Component\Alert;
use Sledgehammer\Mvc\Component\Nav;

class DatabaseSeederRunner extends Util
{

    public function __construct()
    {
        parent::__construct('artisan db:seed');
    }

    function generateContent()
    {
        if (empty($_GET['class'])) {
            return $this->listSeeders();
        }
        
        return $this->runSeed($_GET['class']);
    }

    protected function listSeeders()
    {
        $dir = new DirectoryIterator(\Sledgehammer\PATH.'database/seeds');
        $seeds = [];
        $url = Url::getCurrentURL();
        foreach ($dir as $entry) {
            if ($entry->getExtension() === 'php') {
                $seeds[(string) $url->parameter('class', $entry->getBasename('.php'))] = $entry->getBasename('.php');
            }
        }
        return new Nav($seeds);
    }

    protected function runSeed($class)
    {
        // Boot Laravel Framework
        $app = require_once(\Sledgehammer\PATH.'bootstrap/app.php');
        $request = \Illuminate\Http\Request::capture();
        $app['request'] = $request;
        $app->bootstrapWith([
            'Illuminate\Foundation\Bootstrap\DetectEnvironment',
            'Illuminate\Foundation\Bootstrap\LoadConfiguration',
            'Illuminate\Foundation\Bootstrap\ConfigureLogging',
//            'Illuminate\Foundation\Bootstrap\HandleExceptions',
            'Illuminate\Foundation\Bootstrap\RegisterFacades',
            'Illuminate\Foundation\Bootstrap\RegisterProviders',
            'Illuminate\Foundation\Bootstrap\BootProviders',
        ]);
        
        // Run the seeder
        $command = new DevutilsCommand();
        // @todo implement formatter
        $command->setOutput(new BufferedOutput());

        $seeder = new Seeder();
        $seeder->setCommand($command);
        $seeder->setContainer($app);
        $seeder->call($class);
        
        // Return the result
        return new Alert(nl2br(Html::escape($command->getOutput()->fetch())), ['class' =>'alert alert-info']);
    }

}
