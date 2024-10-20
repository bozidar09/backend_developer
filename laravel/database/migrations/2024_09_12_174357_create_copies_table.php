<?php

use App\Models\Format;
use App\Models\Movie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('copies', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->boolean('available')->default(true);
            $table->foreignIdFor(Movie::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Format::class)->constrained();
            $table->timestamps();
            $table->unique(['id', 'barcode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('copies');
    }
};
