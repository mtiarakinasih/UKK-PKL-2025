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
            
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->foreignId('industri_id')->constrained('industris')->onDelete('cascade');
            
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
            $table->dropForeign(['industri_id']); // Drop foreign key
        });

        Schema::dropIfExists('pkls'); // Drop table pkls
    }

};
