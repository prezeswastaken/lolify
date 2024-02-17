<?php

use App\Models\Champion;
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
        Schema::table('skills', function (Blueprint $table) {
            $table->string('name');
            $table->string('letter');
            $table->string('image_link');
            $table->foreignIdFor(Champion::class)->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('letter');
            $table->dropColumn('image_link');
            $table->dropColumn('champion_id');
        });
    }
};
