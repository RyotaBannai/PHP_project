<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Playground\ExampleCollection2;
use App\Models\User;
use App\Http\Resources\User as UserResource;


class CollectionComamnd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collection:example';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Collection Playground';

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
        # return (new ExampleCollection2)->main();
        $result = new UserResource(User::find(1));
        dd($result);
    }
}
