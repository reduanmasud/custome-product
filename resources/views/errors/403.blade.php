@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="text-center">
        <div class="error mx-auto" data-text="403">403</div>
        <p class="lead text-gray-800 mb-4">Access Forbidden</p>
        <p class="text-gray-500 mb-0">It looks like you don't have permission to access this page.</p>
        <a href="{{ route('admin./') }}">&larr; Back to Dashboard</a>
    </div>
</div>

<style>
    .error {
        color: #5a5c69;
        font-size: 7rem;
        position: relative;
        line-height: 1;
        width: 12.5rem;
        margin: 0 auto;
    }
    
    .error:before {
        content: attr(data-text);
        position: absolute;
        left: -2px;
        text-shadow: 1px 0 #e74a3b;
        top: 0;
        color: #5a5c69;
        background: #f8f9fc;
        overflow: hidden;
        clip: rect(0, 900px, 0, 0);
        animation: noise-anim-2 3s infinite linear alternate-reverse;
    }
    
    .error:after {
        content: attr(data-text);
        position: absolute;
        left: 2px;
        text-shadow: -1px 0 #e74a3b;
        top: 0;
        color: #5a5c69;
        background: #f8f9fc;
        overflow: hidden;
        clip: rect(0, 900px, 0, 0);
        animation: noise-anim 2s infinite linear alternate-reverse;
    }
    
    @keyframes noise-anim {
        0% {
            clip: rect(31px, 9999px, 44px, 0);
        }
        5% {
            clip: rect(70px, 9999px, 71px, 0);
        }
        10% {
            clip: rect(29px, 9999px, 84px, 0);
        }
        15% {
            clip: rect(75px, 9999px, 39px, 0);
        }
        20% {
            clip: rect(57px, 9999px, 98px, 0);
        }
        25% {
            clip: rect(22px, 9999px, 53px, 0);
        }
        30% {
            clip: rect(86px, 9999px, 8px, 0);
        }
        35% {
            clip: rect(25px, 9999px, 82px, 0);
        }
        40% {
            clip: rect(95px, 9999px, 76px, 0);
        }
        45% {
            clip: rect(91px, 9999px, 59px, 0);
        }
        50% {
            clip: rect(80px, 9999px, 80px, 0);
        }
        55% {
            clip: rect(66px, 9999px, 98px, 0);
        }
        60% {
            clip: rect(60px, 9999px, 27px, 0);
        }
        65% {
            clip: rect(85px, 9999px, 47px, 0);
        }
        70% {
            clip: rect(23px, 9999px, 31px, 0);
        }
        75% {
            clip: rect(42px, 9999px, 25px, 0);
        }
        80% {
            clip: rect(48px, 9999px, 66px, 0);
        }
        85% {
            clip: rect(31px, 9999px, 37px, 0);
        }
        90% {
            clip: rect(56px, 9999px, 2px, 0);
        }
        95% {
            clip: rect(30px, 9999px, 88px, 0);
        }
        100% {
            clip: rect(54px, 9999px, 67px, 0);
        }
    }
    
    @keyframes noise-anim-2 {
        0% {
            clip: rect(12px, 9999px, 23px, 0);
        }
        5% {
            clip: rect(95px, 9999px, 35px, 0);
        }
        10% {
            clip: rect(8px, 9999px, 39px, 0);
        }
        15% {
            clip: rect(14px, 9999px, 3px, 0);
        }
        20% {
            clip: rect(63px, 9999px, 91px, 0);
        }
        25% {
            clip: rect(79px, 9999px, 73px, 0);
        }
        30% {
            clip: rect(46px, 9999px, 67px, 0);
        }
        35% {
            clip: rect(48px, 9999px, 146px, 0);
        }
        40% {
            clip: rect(61px, 9999px, 22px, 0);
        }
        45% {
            clip: rect(98px, 9999px, 7px, 0);
        }
        50% {
            clip: rect(51px, 9999px, 22px, 0);
        }
        55% {
            clip: rect(65px, 9999px, 64px, 0);
        }
        60% {
            clip: rect(23px, 9999px, 31px, 0);
        }
        65% {
            clip: rect(67px, 9999px, 74px, 0);
        }
        70% {
            clip: rect(64px, 9999px, 57px, 0);
        }
        75% {
            clip: rect(31px, 9999px, 81px, 0);
        }
        80% {
            clip: rect(46px, 9999px, 32px, 0);
        }
        85% {
            clip: rect(31px, 9999px, 44px, 0);
        }
        90% {
            clip: rect(15px, 9999px, 4px, 0);
        }
        95% {
            clip: rect(42px, 9999px, 2px, 0);
        }
        100% {
            clip: rect(60px, 9999px, 42px, 0);
        }
    }
</style>
@endsection
