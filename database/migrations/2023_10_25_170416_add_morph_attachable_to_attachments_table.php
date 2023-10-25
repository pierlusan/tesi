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
        Schema::table('attachments', function (Blueprint $table) {
            $table->dropForeign('attachments_post_id_foreign');
            $table->dropColumn('post_id');
            $table->morphs('attachable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->dropMorphs('attachable');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
        });
    }
};
