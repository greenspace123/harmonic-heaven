<?php
// app/Http/Controllers/SubscriptionController.php
namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request) {
        $user = Auth::user();
        $plan = $request->plan;

        // В реальном проекте здесь была бы интеграция с платежной системой
        // Для демо просто создаем подписку

        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->plan = $plan;
        $subscription->status = 'active';
        $subscription->start_date = now();

        // Устанавливаем срок подписки
        if ($plan == 'pro') {
            $subscription->end_date = now()->addMonth();
        } elseif ($plan == 'collector') {
            $subscription->end_date = now()->addYear();
        }

        // Новые поля (для будущих платежей)
        $subscription->amount = $plan == 'pro' ? 299 : 599;
        $subscription->currency = 'RUB';
        $subscription->payment_method = 'demo'; // заглушка для демо

        $subscription->save();

        return back()->with('success', 'Подписка успешно оформлена!');
    }

    public function cancel() {
        $user = Auth::user();
        $subscription = $user->subscriptions()->where('status', 'active')->first();

        if ($subscription) {
            $subscription->status = 'cancelled';
            $subscription->save();

            return back()->with('success', 'Подписка отменена. Доступ сохранится до конца оплаченного периода.');
        }

        return back()->with('error', 'Активная подписка не найдена.');
    }

    /**
     * Продление подписки
     */
    public function renew(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->subscriptions()->where('status', 'active')->first();

        if (!$subscription) {
            return back()->with('error', 'Активная подписка не найдена');
        }

        // Продлеваем на тот же срок
        if ($subscription->plan == 'pro') {
            $subscription->end_date = $subscription->end_date->addMonth();
        } elseif ($subscription->plan == 'collector') {
            $subscription->end_date = $subscription->end_date->addYear();
        }

        $subscription->amount = $subscription->plan == 'pro' ? 299 : 599;
        $subscription->currency = 'RUB';
        $subscription->payment_method = 'demo';

        $subscription->save();

        return back()->with('success', 'Подписка продлена!');
    }

    /**
     * История подписок пользователя
     */
    public function history()
    {
        $user = Auth::user();
        $subscriptions = $user->subscriptions()->latest()->get();
        
        return view('profile.subscriptions', compact('subscriptions'));
    }

    /**
     * Активная подписка (проверка статуса)
     */
    public function checkStatus()
    {
        $user = Auth::user();
        $subscription = $user->subscriptions()
            ->where('status', 'active')
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>', now());
            })
            ->first();

        return response()->json([
            'has_active' => $subscription !== null,
            'plan' => $subscription?->plan,
            'ends_at' => $subscription?->end_date?->toIso8601String(),
            'is_on_trial' => $subscription?->isOnTrial() ?? false
        ]);
    }
}