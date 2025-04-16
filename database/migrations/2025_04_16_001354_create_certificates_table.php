<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("language");
            $table->integer('fontSize')->default(24);
            $table->string('fontWeight')->default('normal');
            $table->foreignId('family_id')
                ->nullable()
                ->constrained('families')
                ->nullOnDelete();

            $table->string('textColor')->default("#000000");
            $table->string('textAlign')->default("left");
            $table->string('textWidth');
            $table->string("textX");
            $table->string('textY');
            $table->string('image');

            $table->float('lat')->nullable();
            $table->float('long')->nullable();
            $table->float("range")->nullable()->comment("allowed range in km");
            $table->foreignId('business_id')
                ->constrained('businesses')->nullOnDelete();
            $table->dateTime('expiresAt');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
};
