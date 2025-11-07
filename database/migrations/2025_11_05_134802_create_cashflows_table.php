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
        Schema::create('cashflows', function (Blueprint $table) {
    $table->id();
    $table->bigInteger('user_id')->unsigned();
    $table->string('title'); // nama transaksi
    $table->enum('type', ['income', 'expense']); // jenis: pemasukan/pengeluaran
    $table->decimal('amount', 15, 2); // nominal uang
    $table->text('description')->nullable();
    $table->string('receipt')->nullable(); // untuk gambar bukti
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashflows');
    }
};
