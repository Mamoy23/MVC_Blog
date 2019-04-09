<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTimestampPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function($table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->datetime('created')->nullable();
            $table->datetime('updated')->nullable();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function($table) {
        $table->timestamps();
        $table->dropIfExists('created');
        $table->dropIfExists('updated');
        });
    }
}
