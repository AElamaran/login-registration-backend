<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nic') -> nullable();
            $table->string('name');
            $table->string('Address');
            $table->string('Contact_number');
            $table->string('Vehicle_type') -> nullable();
            $table->string('Vehicle_brand') -> nullable();
            $table->string('Vehicle_color') -> nullable();
            $table->string('Vehicle_number') -> nullable();
            $table->string('Numberofpassenger') -> nullable();
            $table->string('email')->unique();
            $table->enum('role', ['company', 'driver','vehicle'])->default('company');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
