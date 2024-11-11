<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\LiveStreamController; // کنترلری که تابع در آن است

class SaveArchiveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archive:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save archive videos from ArvanCloud every 5 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new LiveStreamController(); // ایجاد شیء از کنترلر
        $controller->saveArchive(request()); // فراخوانی تابع

        return 0;
    }
}

