<?php

namespace App\Mail;

use App\Models\JobVacancy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewResponseAddedToJobVacancy extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public JobVacancy $vacancy; // vacancy title, number of responses since vacancy was posted
    public $user;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(JobVacancy $vacancy)
    {
        $this->vacancy = $vacancy;
        $this->user = auth()->user()->name;
        $this->date = now();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.responses');
    }
}
