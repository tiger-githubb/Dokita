<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->string('title');
            $table->text('description');

            $table->integer('price');
            $table->string('country');
            $table->string('city');
            $table->string('district');

            $table->integer('surface_area');
            $table->json('image')->nullable();

            $table->integer('no_rooms')->nullable();
            $table->integer('no_bedrooms')->nullable();
            $table->integer('no_bathrooms')->nullable();
            $table->integer('no_garages')->nullable();
            
            $table->enum('type', ['appartement', 'villa', 'maison', 'terrain']);
            $table->enum('status', ['vente', 'location']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
