<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_task', function (Blueprint $table) {
            $table->id(); // id INT AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('title', 100); //required, max 100 characters
            $table->text('content'); //required, no max length specified
            $table->enum('task_status', ['done', 'inprogress', 'todo']); //required, can be 'done', 'inprogress', or 'todo'
            $table->enum('publish_status', ['draft', 'published', 'trashed'])->default('draft');
            $table->unsignedBigInteger('created_by');

            $table->dateTime('date_created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('date_updated')->nullable();
            $table->dateTime('date_published')->nullable();
            $table->string('attachment', 200)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_task');
    }
};
