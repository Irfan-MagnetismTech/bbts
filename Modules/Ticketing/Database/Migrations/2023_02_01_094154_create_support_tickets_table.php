<?php

use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Division;
use App\Models\Dataencoding\Thana;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Admin\Entities\Branch;
use Modules\Admin\Entities\Pop;
use Modules\Sales\Entities\Client;
use Modules\Ticketing\Entities\SupportComplainType;
use Modules\Ticketing\Entities\TicketSource;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Branch::class);
            $table->foreignIdFor(Pop::class);
            $table->foreignIdFor(Division::class);
            $table->foreignIdFor(District::class);
            $table->foreignIdFor(Thana::class);
            $table->string('client_no')->nullable();
            $table->string('ticket_no')->comment('format: YYMMDD-000001');
            $table->foreignId('fr_no')->comment('Feasibility details fr no');
            $table->dateTime('complain_time');
            $table->text('description')->nullable();
            $table->foreignIdFor(SupportComplainType::class);
            $table->foreignIdFor(TicketSource::class);
            $table->string('priority');
            $table->text('remarks')->nullable();
            $table->string('status')->default('Pending');
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id');
            $table->foreignId('reopened_by')->nullable()->constrained('users', 'id');
            $table->dateTime('reopening_date')->nullable();
            $table->integer('reopen_count')->default(0);
            $table->dateTime('opening_date');
            $table->dateTime('closing_date')->nullable();
            $table->foreignId('closed_by')->nullable();
            $table->integer('duration')->nullable();
            $table->boolean('is_temporary_close')->nullable();
            $table->text('feedback_to_bbts')->nullable();
            $table->text('feedback_to_client')->nullable();
            $table->text('clients_feedback')->nullable();
            $table->text('clients_feedback_details')->nullable();
            $table->text('clients_feedback_url')->nullable();
            $table->bigInteger('current_authorized_person')->nullable();
            $table->tinyInteger('mailNotification')->nullable();
            $table->tinyInteger('smsNotification')->nullable();

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
        Schema::dropIfExists('support_tickets');
    }
};
