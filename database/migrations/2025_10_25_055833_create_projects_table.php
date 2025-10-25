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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->date('deadline')->default(now());
            $table->longText("description")->nullable();
            $table->decimal('price')->default(0);
            $table->string("agreement")->nullable();
            $table->string("signed_agreement")->nullable();
            $table->foreignIdFor(App\Models\Client::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
