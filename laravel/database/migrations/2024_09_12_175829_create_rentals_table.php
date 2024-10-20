<?php

use App\Models\Copy;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->timestamp('rental_date');
            $table->timestamp('return_date')->nullable()->default(null);
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });

        Schema::create('copy_rental', function (Blueprint $table) {
            $table->foreignIdFor(Copy::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Rental::class)->constrained();
            $table->timestamp('return_date')->nullable()->default(null);
            $table->primary(['rental_id', 'copy_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
        Schema::dropIfExists('copy_rental');
    }
};
