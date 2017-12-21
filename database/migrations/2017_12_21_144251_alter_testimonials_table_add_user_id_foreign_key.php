<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTestimonialsTableAddUserIdForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('rinvex.testimonials.tables.testimonials'), function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on(config('rinvex.fort.tables.users'))
                  ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('rinvex.testimonials.tables.testimonials'), function (Blueprint $table) {
            $table->dropForeign('testimonials_user_id_foreign');
        });
    }
}
