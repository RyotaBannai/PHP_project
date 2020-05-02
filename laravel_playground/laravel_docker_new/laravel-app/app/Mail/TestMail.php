<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        #return $this->emails('emails.name');
        return $this
            //->from("ryotabanani0528@gmail.com") // required to add sender's address, or define .env file
            ->subject('Test Completed!')
            ->view('emails.test');
        //-> ファイルシステムのディスクへファイルを保存してあり、それをメールに添付する場合attachFromStorage　を使う
        //->attachFromStorage('/path/to/file', 'name.pdf', [
        //'mine' => 'application/pdf'
        //];)
        // ->attachFromStorageDisk('s3', '/path/to/file'); // storageにs3を使っていれば。

        //遅延送信
        //$when = Carbon\Carbon::now(0->addMinutes(10);
        //Mail::to('ryotala0528@gmail.com')->later($when, new App\Mail\TestMail());
    }
}
