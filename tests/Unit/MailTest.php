<?php

namespace Tests\Unit;

use App\Mail\NewLogMail;
use App\Models\Log;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class   MailTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testMailSend()
    {
        Mail::fake();
        $log = Log::create([
            'coment' => "esto solo es una prueba rara",
            'task_id' => Task::all()->random(1)->first()->id,
        ]);
        Mail::send(new NewLogMail($log));

        Mail::assertSent(NewLogMail::class);

        Mail::assertSent(NewLogMail::class, function ($mail) {
            $mail->build();
            $this->assertTrue($mail->hasFrom('TWGroup@hello.com'));

            return true;
        });
    }
}
