<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Barber;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Показать форму добавления отзыва
     */
    public function create(Barber $barber)
    {
        // Находим завершённые записи пользователя к этому мастеру без отзыва
        $completedAppointments = Appointment::where('user_id', Auth::id())
            ->where('barber_id', $barber->id)
            ->where('status', 'completed')
            ->whereDoesntHave('review')
            ->orderBy('appointment_date', 'desc')
            ->get();

        if ($completedAppointments->isEmpty() && !Auth::user()->hasRole('admin')) {
            return redirect()->route('barbers.show', $barber)
                ->with('error', 'Вы можете оставить отзыв только после завершённой записи к этому мастеру.');
        }

        // Проверяем, нет ли уже отзыва (на любую запись)
        $existingReview = Review::where('user_id', Auth::id())
            ->where('barber_id', $barber->id)
            ->first();

        if ($existingReview && !Auth::user()->hasRole('admin')) {
            return redirect()->route('barbers.show', $barber)
                ->with('error', 'Вы уже оставляли отзыв этому мастеру.');
        }

        return view('reviews.create', compact('barber', 'completedAppointments'));
    }

    /**
     * Сохранить отзыв
     */
    public function store(Request $request, Barber $barber)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
            'appointment_id' => 'required|exists:appointments,id',
        ]);

        // Проверяем, что запись принадлежит пользователю и завершена
        $appointment = Appointment::where('id', $request->appointment_id)
            ->where('user_id', Auth::id())
            ->where('barber_id', $barber->id)
            ->where('status', 'completed')
            ->whereDoesntHave('review')
            ->first();

        if (!$appointment && !Auth::user()->hasRole('admin')) {
            return back()->with('error', 'Вы не можете оставить отзыв для этой записи.');
        }

        // Проверяем, нет ли уже отзыва
        $existingReview = Review::where('user_id', Auth::id())
            ->where('barber_id', $barber->id)
            ->first();

        if ($existingReview && !Auth::user()->hasRole('admin')) {
            return back()->with('error', 'Вы уже оставляли отзыв этому мастеру.');
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'barber_id' => $barber->id,
            'appointment_id' => $appointment->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => Auth::user()->hasRole('admin') ? true : false,
        ]);

        return redirect()->route('barbers.show', $barber)
            ->with('success', 'Спасибо за отзыв! Он будет опубликован после проверки.');
    }

    /**
     * Удалить отзыв
     */
    public function destroy(Review $review)
    {
        if (Auth::id() !== $review->user_id && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $barberId = $review->barber_id;
        $review->delete();

        return redirect()->route('barbers.show', $barberId)
            ->with('success', 'Отзыв удалён.');
    }
}