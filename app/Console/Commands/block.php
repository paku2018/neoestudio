<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Carbon\Carbon;
class block extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:block';

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
        $exists=\App\Pay::where('process','auto')->where('status','pending')->exists();
        if($exists==true){
            $pays=\App\Pay::where('process','auto')->where('status','pending')->get();
            $now=Carbon::now()->toDateTimeString();
            foreach ($pays as $key => $pay) {
                $user=\App\User::find($pay->userId);
                $field1x=$user->field1x;
                if(!empty($pay->scheduleTime)&&$field1x=="Desbloquear"){
                    $scheduleTime=Carbon::parse($pay->scheduleTime)->addDays(3)->toDateTimeString();
                    if(Carbon::parse($now)->gte(Carbon::parse($scheduleTime))){
                        $user->field1x="Bloquear";
                        $user->save();
                    }
                }
            }
        }
    }
}
