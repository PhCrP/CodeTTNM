@extends('backend.layouts.master')

@section('title', 'BuyPhone || Đang phát triển')

@section('main-content')
<!-- Development Section -->
<section class="development-section section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Trang đang trong quá trình phát triển</h1>
                <p>Nhóm đang nỗ lực xây dựng nội dung đẳng cấp nhất cho bro. Bro hãy quay lại sau!</p>
                <img src="{{ asset('frontend/img/under_development.png') }}" alt="OH NO" class="img-fluid" style="max-width: 500px; margin-top: 20px;">
                <div class="mt-4">
                    <a href="{{ route('admin') }}" class="btn btn-primary rounded">Về trang chủ</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Development Section -->
@endsection

@push('styles')
<style>
    .development-section {
        padding: 100px 0;
        background-color: transparent;
    }

    .development-section h1 {
        font-size: 2.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    .development-section p {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 30px;
    }

    .development-section img {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }

    .btn-primary {
        background-color: #4A90E2;
        border-color: #4A90E2;
        padding: 10px 20px;
        font-size: 1.1rem;
    }

    .btn-primary:hover {
        background-color: #357ABD;
        border-color: #357ABD;
    }
</style>
@endpush