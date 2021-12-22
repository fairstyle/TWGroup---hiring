<?php

namespace App\Mail;

use App\Models\Log;
use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewLogMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $task;
    private $user;
    private $email;

    public function __construct(Log $log)
    {
        $this->task = Task::find($log->task_id);
        $this->user = User::find($this->task->user_id);
        $this->email = $this->user->email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('TWGroup@hello.com')->to($this->email)
            ->view('email.newLog');
    }
}
