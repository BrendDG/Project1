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
            $table->dropColumn([
                'division_1v1',
                'division_2v2',
                'division_3v3',
                'division_hoops',
                'division_rumble',
                'division_dropshot',
                'division_snowday',
                'division_tournament',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('division_1v1')->nullable()->after('mmr_1v1');
            $table->tinyInteger('division_2v2')->nullable()->after('mmr_2v2');
            $table->tinyInteger('division_3v3')->nullable()->after('mmr_3v3');
            $table->tinyInteger('division_hoops')->nullable()->after('mmr_hoops');
            $table->tinyInteger('division_rumble')->nullable()->after('mmr_rumble');
            $table->tinyInteger('division_dropshot')->nullable()->after('mmr_dropshot');
            $table->tinyInteger('division_snowday')->nullable()->after('mmr_snowday');
            $table->tinyInteger('division_tournament')->nullable()->after('mmr_tournament');
        });
    }
};
