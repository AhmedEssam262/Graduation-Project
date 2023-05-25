<?php

namespace App\Console\Commands;

use App\Models\Chat;
use Illuminate\Console\Command;

class openChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'open_chat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open chat when the time comes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $chats=Chat::all();

        foreach ($chats as $chat){

            $chat->is_open=$chat->is_open+1;
            $chat->save();
        }
    }
}
