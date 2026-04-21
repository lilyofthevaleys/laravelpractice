<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->nullableMorphs('buyable');
        });

        DB::table('transaction_items')
            ->whereNotNull('pokemon_id')
            ->update([
                'buyable_type' => 'App\\Models\\Pokemon',
                'buyable_id'   => DB::raw('pokemon_id'),
            ]);

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pokemon_id');
        });
    }

    public function down(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->foreignId('pokemon_id')->nullable()->after('transaction_id')->constrained('pokemons')->nullOnDelete();
        });

        DB::table('transaction_items')
            ->where('buyable_type', 'App\\Models\\Pokemon')
            ->update(['pokemon_id' => DB::raw('buyable_id')]);

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropMorphs('buyable');
        });
    }
};
