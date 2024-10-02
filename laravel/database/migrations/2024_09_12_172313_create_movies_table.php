<?php

use App\Models\Genre;
use App\Models\Price;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedSmallInteger('year');
            $table->foreignIdFor(Genre::class)->constrained();
            $table->foreignIdFor(Price::class)->constrained(); 
            $table->timestamps();
            $table->unique(['title', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
