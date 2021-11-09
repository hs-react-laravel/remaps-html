<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FileService;
use Illuminate\Support\Facades\Log;

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
        foreach($entries as $entry) {
            $company = $entry->user->company;
            $day = lcfirst(date('l'));
            $daymark_from = substr($day, 0, 3).'_from';
            $today_start = date('Y-m-d ').$company->$daymark_from.':00';
            $now = date('Y-m-d H:i:s');
            Log::info("fileservice: ".$entry->id);
            if ($now >= $today_start) {
                if ($company->open_check) {
                    if ($company->$daymark_from && $today_start >= $entry->created_at) {
                        $entry->update(['status' => 'O']);
                    }
                } else {
                    $entry->update(['status' => 'O']);
                }
            }
        }
        return Command::SUCCESS;
    }
}
