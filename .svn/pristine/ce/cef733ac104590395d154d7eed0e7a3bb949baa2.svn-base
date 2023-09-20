<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpdtImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:updt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For correcting college code in images.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        getYearlyDbConn(true);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = Storage::disk('local')->allFiles('photo');
        foreach ($files as $file) {
            $found = strpos(strtoupper($file), 'P178');
            if ($found !== false) {
                $new = str_replace('P178', 'P181', strtoupper($file));
                Storage::move($file, $new);
            } else {
                $found = strpos(strtoupper($file), 'S178');
                if ($found !== false) {
                    $new = str_replace('S178', 'S181', strtoupper($file));
                    Storage::move($file, $new);
                }
            }
        }
        $this->info('done!!!');
        return ;
        
    }
}
