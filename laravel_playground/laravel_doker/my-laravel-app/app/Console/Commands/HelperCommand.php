<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Playground\Helpers;

class HelperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:helperexample';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Helper Playground';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dump((new Helpers())->_other());
    }
}
