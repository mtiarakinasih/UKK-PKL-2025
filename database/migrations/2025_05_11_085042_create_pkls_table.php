<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pkls', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('restrict');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('restrict');
            $table->foreignId('industri_id')->constrained('industris')->onDelete('restrict');
            
            $table->date('mulai');
            $table->date('selesai');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pkls', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropForeign(['guru_id']);
            $table->dropForeign(['industri_id']);
        });

        Schema::dropIfExists('pkls');
    }
};
