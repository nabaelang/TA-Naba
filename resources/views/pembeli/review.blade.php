@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Reviews for {{ $product->name }}</h1>

        <div class="reviews">
            @forelse($reviews as $review)
                <div class="review">
                    <h5>{{ $review->user->name }}</h5>
                    <div>Rating: {{ $review->rating }} / 5</div>
                    <p>{{ $review->review }}</p>
                </div>
            @empty
                <p>No reviews yet.</p>
            @endforelse
        </div>

        @if (auth()->check())
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="transaction_id" value="{{ request('transaction_id') }}">

                <div class="form-group">
                    <label for="review">Review</label>
                    <textarea name="review" id="review" class="form-control" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        @endif
    </div>
@endsection
