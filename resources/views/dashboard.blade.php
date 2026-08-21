@extends('layouts.app')

@section('title', 'Dashboard - ' . $school->school_name)

@section('content')
<div class="mb-8">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-4xl font-bold text-blue-800">સ્વાગત છે, {{ $school->principal_name }}</h2>
                <p class="text-xl text-gray-600 mt-2">{{ $school->school_name }}</p>
            </div>
            <a href="{{ url('/logout') }}" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition font-semibold">
                લૉગઆઉટ
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-gray-600 font-semibold">ઈમેઈલ</p>
                <p class="text-lg">{{ $school->email }}</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-gray-600 font-semibold">ફોન</p>
                <p class="text-lg">{{ $school->phone }}</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-gray-600 font-semibold">સરનામું</p>
                <p class="text-lg">{{ $school->address }}</p>
            </div>
        </div>
    </div>
</div>

<section class="bg-gradient-to-r from-blue-400 to-teal-400 text-white rounded-xl p-16 mb-16 text-center">
    <h2 class="text-5xl font-bold mb-6">વિદ્યાર્થીઓની હાજરી સરળતાથી મેનેજ કરો</h2>
    <p class="text-2xl mb-8">આ સિસ્ટમ વિદ્યાર્થીઓની હાજરી સરળ, ઝડપી અને અસરકારક બનાવે છે.</p>
    <a href="{{ url('/student/register') }}" class="bg-yellow-400 text-gray-900 py-3 px-8 rounded-lg text-2xl font-semibold hover:bg-yellow-300 transition">હવે નોંધણી કરો</a>
    <a href="{{ url('/students') }}" class="ml-4 bg-green-400 text-white py-3 px-8 rounded-lg text-2xl font-semibold hover:bg-green-300 transition">વિદ્યાર્થી યાદી જુઓ</a>
</section>

<section class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition text-center">
        <h3 class="text-3xl font-bold mb-4 text-blue-700">સરળ નોંધણી</h3>
        <p class="text-xl text-gray-700">વિદ્યાર્થીઓને ઝડપી અને સરળ રીતે નોંધાવી શકો છો.</p>
    </div>
    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition text-center">
        <h3 class="text-3xl font-bold mb-4 text-blue-700">QR Attendance</h3>
        <p class="text-xl text-gray-700">વિદ્યાર્થીઓના QR સ્કેનથી હાજરી તરત નોંધાય છે.</p>
    </div>
    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition text-center">
        <h3 class="text-3xl font-bold mb-4 text-blue-700">રિપોર્ટ</h3>
        <p class="text-xl text-gray-700">સંક્ષિપ્ત રિપોર્ટ અને વિગતવાર માહિતી સરળતાથી મેળવો.</p>
    </div>
</section>
@endsection
