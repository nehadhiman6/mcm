<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CorrectSections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'correct:sections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes correction in duplicate sections';

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
        $sec = 'C';
        $sec_id = 3;
        $dupes = DB::connection(getYearlyDbConn())->select("select course_id,subject_id,min(id) as keep_id,max(id) as repl_id,sum(1) as cnt from subject_sections " .
            "where section_id in (SELECT id FROM sections where section='{$sec}') " .
            "and id in (select sub_sec_id from marks) " .
            "group by 1,2 having sum(1)>1 " .
            "order by course_id,subject_id");

        foreach ($dupes as $ss) {
            $q = "update marks set sub_sec_id=" . $ss->keep_id .
                " where sub_sec_id = " . $ss->repl_id;
            $this->info($q);
            DB::connection(getYearlyDbConn())->update($q);
        };

        $q = "update subject_sections " .
            "set section_id={$sec_id} " .
            "where section_id in (SELECT id FROM sections where section='{$sec}') " .
            "and id in (select sub_sec_id from marks)";
        $this->info($q);
        DB::connection(getYearlyDbConn())->update($q);

        $q = "delete from subject_sections where id not in (select sub_sec_id from marks)";
        $this->info($q);
        DB::connection(getYearlyDbConn())->delete($q);

        $q = "delete from sections  where id not in (select section_id from subject_sections)";
        $this->info($q);
        DB::connection(getYearlyDbConn())->delete($q);
    }
}
