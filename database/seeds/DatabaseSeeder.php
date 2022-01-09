<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public static $seeders = [];

    public function run()
    {
        foreach (self::$seeders as $row) {

            $this->call($row);
        }

    }
}
