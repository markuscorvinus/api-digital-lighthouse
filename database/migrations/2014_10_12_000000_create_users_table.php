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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('system_user_type')->comment('1:super_admin|2:admin|3-user');
            $table->boolean('is_active')->default(false)->comment('0:inactive(requires approval)|1:active');
            $table->rememberToken();
            $table->softDeletes();
            $table->string('remarks', 250)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('updated_user_id');
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
