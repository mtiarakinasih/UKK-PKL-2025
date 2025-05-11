<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePklStatusTrigger extends Migration
{
    public function up()
    {
        // Trigger untuk INSERT
        DB::statement("
            CREATE TRIGGER update_status_pkl_after_insert
            AFTER INSERT ON pkls
            FOR EACH ROW
            BEGIN
                UPDATE siswas
                SET status_pkl = 1
                WHERE id = NEW.siswa_id;
            END
        ");

        // Trigger untuk DELETE
        DB::statement("
            CREATE TRIGGER update_status_pkl_after_delete
            AFTER DELETE ON pkls
            FOR EACH ROW
            BEGIN
                UPDATE siswas
                SET status_pkl = 0
                WHERE id = OLD.siswa_id;
            END
        ");
    }

    public function down()
    {
        DB::statement('DROP TRIGGER IF EXISTS update_status_pkl_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS update_status_pkl_after_delete');
    }
}
