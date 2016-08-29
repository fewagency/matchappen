<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEvaluationSentToOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->timestamp('evaluation_notified_at')->nullable()->default(null)->after('contact_phone');
            $table->index(['evaluation_notified_at', 'end'], 'evaluation_notification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropIndex('evaluation_notification');
            $table->dropColumn('evaluation_notified_at');
        });
    }
}
