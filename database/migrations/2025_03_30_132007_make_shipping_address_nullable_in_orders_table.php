<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQL ile doğrudan güncelleme yapıyoruz (Doctrine DBAL gerektirmiyor)
        DB::statement('ALTER TABLE orders MODIFY COLUMN shipping_address JSON NULL');
        DB::statement('ALTER TABLE orders MODIFY COLUMN billing_address JSON NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Geri alınırsa tekrar nullable olmayan hale getir
        DB::statement('ALTER TABLE orders MODIFY COLUMN shipping_address JSON NOT NULL');
        DB::statement('ALTER TABLE orders MODIFY COLUMN billing_address JSON NOT NULL');
    }
};
