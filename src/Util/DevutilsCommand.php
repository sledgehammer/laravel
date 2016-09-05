<?php

namespace Sledgehammer\Laravel\Util;

use Illuminate\Console\Command;

class DevutilsCommand extends Command
{

    protected $name = 'Command run from devutils';

    public function setOutput($output) {
        $this->output = $output;
    }
}
