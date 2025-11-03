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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('mmr_1v1')->nullable()->after('about_me');
            $table->integer('mmr_2v2')->nullable()->after('mmr_1v1');
            $table->integer('mmr_3v3')->nullable()->after('mmr_2v2');
            $table->integer('mmr_hoops')->nullable()->after('mmr_3v3');
            $table->integer('mmr_rumble')->nullable()->after('mmr_hoops');
            $table->integer('mmr_dropshot')->nullable()->after('mmr_rumble');
            $table->integer('mmr_snowday')->nullable()->after('mmr_dropshot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'mmr_1v1',
                'mmr_2v2',
                'mmr_3v3',
                'mmr_hoops',
                'mmr_rumble',
                'mmr_dropshot',
                'mmr_snowday',
            ]);
        });
    }
};
