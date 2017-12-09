<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $this->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->call(UsersTableSeeder::class);
    }

    private function truncate()
    {
        $tables = DB::select("SELECT table_name FROM information_schema.tables where table_schema='" . env('DB_DATABASE') . "' and table_name <> 'migrations'");

        foreach ($tables as $table) {
            DB::table($table->table_name)->truncate();
        }
    }
}
