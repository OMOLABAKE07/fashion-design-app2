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
 Schema::table('designs', function (Blueprint $table) {
    if (!Schema::hasColumn('designs', 'photo')) {
        $table->string('photo')->nullable()->after('description');
    }
});

}

    /**
     * Reverse the migrations.
     */
  public function down(): void
{
    Schema::table('designs', function (Blueprint $table) {
        $table->dropColumn('photo');
    });
}
};
