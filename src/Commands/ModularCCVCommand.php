<?php

namespace ModularCCV\ModularCCV\Commands;

use Illuminate\Console\Command;

class ModularCCVCommand extends Command
{
    public $signature = 'modular-middleware-template';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
