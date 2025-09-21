<?php

namespace App\Jobs;

use App\Helpers\NotifyHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $title;
    protected $message;
    protected $link;

    public function __construct($userId, $title, $message, $link)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->message = $message;
        $this->link = $link;
    }

    public function handle(): void
    {
        NotifyHelper::send($this->userId, $this->title, $this->message, $this->link);
    }
}