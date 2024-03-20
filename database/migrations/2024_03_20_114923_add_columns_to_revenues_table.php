<?php

use App\Models\Revenue;
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
        Schema::table('revenues', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->after('id');
            $table->string('type')->after('user_id');
            $table->double('amount')->after('type');
            $table->tinyInteger('status')->default(Revenue::STATUS_PENDING)->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('revenues', function (Blueprint $table) {
            //
        });
    }
};
