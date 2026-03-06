<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            // Добавляем индексы для ускорения поиска
            $table->index('user_id');
            $table->index('status');
            $table->index('plan');
            
            // Дополнительные поля для платежей
            $table->string('payment_method')->nullable()->after('plan'); // способ оплаты
            $table->decimal('amount', 10, 2)->default(0)->after('payment_method'); // сумма
            $table->string('currency', 3)->default('RUB')->after('amount'); // валюта
            
            // Пробный период
            $table->timestamp('trial_ends_at')->nullable()->after('end_date');
            
            // Мягкое удаление (для восстановления) - добавляем после created_at
            $table->softDeletes()->after('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['plan']);
            $table->dropColumn(['payment_method', 'amount', 'currency', 'trial_ends_at']);
            $table->dropSoftDeletes();
        });
    }
};
