<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use jdavidbakr\MailTracker\Model\SentEmail;

class AddOpenedAtToSentEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection((new SentEmail)->getConnectionName())->table('sent_emails', function(Blueprint $table) {
            $table->timestamp('first_opened_at')->nullable();
            $table->timestamp('last_opened_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection((new SentEmail)->getConnectionName())->table('sent_emails', function(Blueprint $table) {
            $table->dropColumn('first_opened_at');
            $table->dropColumn('last_opened_at');
        });
    }
}
