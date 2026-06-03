<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Список всех отзывов для админки
     */
    public function index()
    {
        $reviews = Review::with(['user', 'barber'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $pendingCount = Review::where('is_approved', false)->count();

        return view('admin.reviews.index', compact('reviews', 'pendingCount'));
    }

    /**
     * Одобрить отзыв
     */
    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);

        return back()->with('success', 'Отзыв одобрен и опубликован');
    }

    /**
     * Удалить отзыв
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Отзыв удалён');
    }
}