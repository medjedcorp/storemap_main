<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
// use Log;

class RoleChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:RoleChange';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change new role over a year to free role';

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
     * @return int
     */
    public function handle()
    {
        // 登録後１年以内かを判定するための準備
        $newCusDay = config('services.newCustomerDays');
        $nowDateTime = new Carbon(); // 現在の日付 2021/12/16
        $maxDateTime = $nowDateTime->subDays($newCusDay); // 現在から３６５日前の日付

        $newUsers = User::where('role', 'new')->where('created_at', '<', $maxDateTime)->get();
        // Log::debug($newUsers);
        // Log::debug($maxDateTime);
        // Log::debug($newCusDay);
        // Log::debug($nowDateTime);

        foreach($newUsers as $newUser){
            $newUser->role = 'free';
            $newUser->save();
        }
    }
}
