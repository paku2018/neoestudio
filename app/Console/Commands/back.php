<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;
use Illuminate\Http\Request;
class back extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:back';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $request = Request::create(route('idd'), 'GET');
        $response = app()->handle($request);
        $responseBody = json_decode($response->getContent(), true);
        $this->info('idd route has been dispatched successfully');
        

        /*
        $date=Carbon::now()->toDateString();
        File::put('backups/'.$date.'backup.sql','');
        MySql::create()->setDbName('neoappes')
        ->setUserName('neoes_')
        ->setPassword('aA115yr4.')
        ->setHost('mysql-5703.dinaserver.com')
        ->setPort('3306')
        ->dumpToFile(base_path('backups/'.$date.'backup.sql'));

        File::put('backupsdown/'.$date.'backup.txt','');
        MySql::create()->setDbName('neoappes')
        ->setUserName('neoes_')
        ->setPassword('aA115yr4.')
        ->setHost('mysql-5703.dinaserver.com')
        ->setPort('3306')
        ->dumpToFile(base_path('backupsdown/'.$date.'backup.txt'));*/
    }
}
