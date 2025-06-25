<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah model QuizQuestionOption agar menggunakan tabel yang benar
        if (!Schema::hasTable('quiz_question_options') && Schema::hasTable('quiz_options')) {
            Schema::rename('quiz_options', 'quiz_question_options');
            
            // Update foreign key constraints
            if (Schema::hasTable('quiz_answers')) {
                Schema::table('quiz_answers', function (Blueprint $table) {
                    // Hapus constraint lama jika ada
                    $sm = Schema::getConnection()->getDoctrineSchemaManager();
                    $foreignKeys = collect($sm->listTableForeignKeys('quiz_answers'))
                        ->filter(function ($key) {
                            return $key->getLocalColumns() === ['selected_option_id'];
                        });
                    
                    if ($foreignKeys->count() > 0) {
                        $foreignKeyName = $foreignKeys->first()->getName();
                        $table->dropForeign($foreignKeyName);
                    }

                    // Tambahkan foreign key baru ke tabel yang benar
                    $table->foreign('selected_option_id')
                        ->references('id')
                        ->on('quiz_question_options')
                        ->onDelete('set null');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke kondisi sebelumnya jika perlu rollback
        if (!Schema::hasTable('quiz_options') && Schema::hasTable('quiz_question_options')) {
            Schema::rename('quiz_question_options', 'quiz_options');
            
            // Update foreign key constraints
            if (Schema::hasTable('quiz_answers')) {
                Schema::table('quiz_answers', function (Blueprint $table) {
                    // Hapus constraint yang baru ditambahkan
                    $sm = Schema::getConnection()->getDoctrineSchemaManager();
                    $foreignKeys = collect($sm->listTableForeignKeys('quiz_answers'))
                        ->filter(function ($key) {
                            return $key->getLocalColumns() === ['selected_option_id'];
                        });
                    
                    if ($foreignKeys->count() > 0) {
                        $foreignKeyName = $foreignKeys->first()->getName();
                        $table->dropForeign($foreignKeyName);
                    }

                    // Kembalikan ke foreign key original
                    $table->foreign('selected_option_id')
                        ->references('id')
                        ->on('quiz_options')
                        ->onDelete('set null');
                });
            }
        }
    }
};
