<?php

namespace App\Mail;

use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\FileService;

class JobAssigned extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The file service instance.
     *
     * @var FileService
     */

    public $fileService;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->fileService->staff;
        $emailTemplate = EmailTemplate::where('company_id', 1)->where('label', 'staff-job-assigned')->first(['subject', 'body']);
		if($emailTemplate){
            $subject = $emailTemplate->subject;
            $body = $emailTemplate->body;

            $body = str_replace('##USER_NAME', $user->full_name, $body);
            $body = str_replace('##JOB_LINK', route('stafftk.edit', ['stafftk' => $this->fileService->id]), $body);
            $body = str_replace('##COMPANY_NAME', $user->company->name, $body);
            $body = str_replace('##APP_NAME', $user->name, $body);

            $this->subject($subject)
                ->view('emails.layout')
                ->with(['body'=>$body]);

        }
    }
}
