<?php

namespace ModularTemplate\ModularTemplate\Commands;

use Illuminate\Console\Command;

class ModularTemplateCommand extends Command
{
    public $signature = 'modular-middleware-template';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
