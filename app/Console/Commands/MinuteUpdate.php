<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\FileService;
use App\Models\Timezone;
use App\Mail\FileServiceOpened;
use App\Mail\FileServiceModified;

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
            try {
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
                        }
                    } else {
                        $entry->update(['status' => 'O']);
                        $this->line('found on non-checking company');
                    }
                }
            }catch(\Exception $e){
                continue;
            }
        }

        $delayEntries = FileService::where('status', 'W')->where('is_delay', 1)->get();
        Log::info("delayed file services: ".count($delayEntries));
        foreach($delayEntries as $entry) {
            $updatedTime = strtotime($entry->getRawOriginal('updated_at'));
            $now = strtotime('now');
            Log::info($entry->getRawOriginal('updated_at'));
            Log::info("delayed time difference ".$now.' '.$updatedTime);
            if (($now - $updatedTime) / 60 > $entry->delay_time) {
                $entry->status = 'C';
                $entry->save();
                $company = $entry->user->company;
                if ($company->mail_host && $company->mail_port && $company->mail_username && $company->mail_password) {
                    Config::set('mail.default', $company->mail_driver);
                    Config::set('mail.mailers.smtp.host', $company->mail_host);
                    Config::set('mail.mailers.smtp.port', $company->mail_port);
                    Config::set('mail.mailers.smtp.encryption', $company->mail_encryption);
                    Config::set('mail.mailers.smtp.username', $company->mail_username);
                    Config::set('mail.mailers.smtp.password', $company->mail_password);
                    Config::set('mail.from.address',$company->mail_username );
                } else {
                    Config::set('mail.default', 'smtp');
                    Config::set('mail.mailers.smtp.host', 'mail.remapdash.com');
                    Config::set('mail.mailers.smtp.port', 25);
                    Config::set('mail.mailers.smtp.encryption', '');
                    Config::set('mail.mailers.smtp.username', 'no-reply@remapdash.com');
                    Config::set('mail.mailers.smtp.password', '5Cp38@gj2');
                    Config::set('mail.from.address', 'no-reply@remapdash.com');
                }
                try{
                    Mail::to($entry->user->email)->send(new FileServiceModified($entry));
                }catch(\Exception $e){
                    session()->flash('error', 'Error in SMTP: '.__('admin.opps'));
                }
            }
        }
        Log::info("cron is running");
        return Command::SUCCESS;
    }
}
