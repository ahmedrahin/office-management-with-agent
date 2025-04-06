<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeesIdForeignToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Ensure the column exists before adding constraint
            if (!Schema::hasColumn('users', 'employees_id')) {
                $table->foreignId('employees_id')->nullable();
            }

            $table->foreign('employees_id')
                  ->references('id')
                  ->on('employees')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['employees_id']);
        });
    }
}
