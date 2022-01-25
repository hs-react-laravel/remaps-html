<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\FileService;
use App\Models\Timezone;
use App\Mail\FileServiceOpened;

class MinuteUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan upload pending file services';

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
        $entries = FileService::where('status', 'P')->get();
        $this->info(count($entries));
        foreach($entries as $entry) {
            $company = $entry->user->company;
            $timezone = $company->timezone;
            $tz = Timezone::find($timezone ?? 1);

            $day = lcfirst(date('l'));
            $daymark_from = substr($day, 0, 3).'_from';
            $today_start = date('Y-m-d ').$company->$daymark_from.':00';

            $utc_from = Carbon::parse(new \DateTime($today_start, new \DateTimeZone($tz->name)))->tz('UTC')->format('Y-m-d H:i:s');
            $now = date('Y-m-d H:i:s');
            $entry_time = Carbon::parse(new \DateTime($entry->created_at))->format('Y-m-d H:i:s');
            if ($now >= $utc_from) {
                if ($company->open_check) {
                    if ($company->$daymark_from && $today_start >= $entry_time) {
                        $entry->update(['status' => 'O']);
                        $this->line('found on checking company');
                        try{
                            Mail::to($entry->user->email)->send(new FileServiceOpened($entry));
                        }catch(\Exception $e){
                            session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
                        }
                    }
                } else {
                    $entry->update(['status' => 'O']);
                    $this->line('found on non-checking company');
                }
            }
        }
        Log::info("cron is running");
        return Command::SUCCESS;
    }
}
