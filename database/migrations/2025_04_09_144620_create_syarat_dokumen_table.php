<?php

// database/migrations/xxxx_xx_xx_create_syarat_dokumen_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
       Schema::create('syarat_dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('tipe_input', ['file', 'text', 'number', 'date', 'textarea', 'select'])->default('file');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::table('syarat_dokumen', function (Blueprint $table) {
            $table->dropForeign(['jenis_surat_id']);
            $table->dropColumn('jenis_surat_id');
        });
    }
};
