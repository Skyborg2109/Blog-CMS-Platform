@extends('layouts.public')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-screen-2xl mx-auto px-6 md:px-12 py-16 lg:py-24">
    <header class="mb-16 border-b-4 border-stone-900 pb-8">
        <h1 class="text-5xl md:text-7xl font-black font-serif text-stone-900 tracking-tight uppercase">
            Profil Saya.
        </h1>
        <p class="text-stone-500 font-bold uppercase tracking-[0.3em] mt-4">PENGATURAN AKUN REDAKSI</p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
        <div class="lg:col-span-8 space-y-16">
            <div class="p-8 md:p-12 border-2 border-stone-900 bg-white">
                <div class="max-w-xl">
                    <h3 class="text-2xl font-black font-serif text-stone-900 mb-8 lowercase italic">Informasi Jurnalistik</h3>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-8 md:p-12 border-2 border-stone-900 bg-white">
                <div class="max-w-xl">
                    <h3 class="text-2xl font-black font-serif text-stone-900 mb-8 lowercase italic">Keamanan Sandi</h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-8 md:p-12 border-2 border-stone-100 bg-stone-50">
                <div class="max-w-xl">
                    <h3 class="text-2xl font-black font-serif text-red-600 mb-8 lowercase italic">Penghapusan Arsip Akun</h3>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

        <aside class="lg:col-span-4 self-start sticky top-32">
            <div class="bg-stone-900 text-stone-100 p-10">
                <div class="w-24 h-24 bg-stone-700 rounded-full mb-8 flex items-center justify-center border-4 border-stone-800">
                    <span class="text-4xl font-black font-serif">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <h2 class="text-2xl font-black font-serif mb-2">{{ Auth::user()->name }}</h2>
                <p class="text-stone-400 text-xs font-bold uppercase tracking-widest mb-8">{{ Auth::user()->role === 'admin' ? 'Pemimpin Redaksi' : 'Kontributor / Penulis' }}</p>
                <div class="border-t border-stone-800 pt-6">
                    <p class="text-sm font-medium italic text-stone-500">
                        Bergabung sejak {{ Auth::user()->created_at->format('M Y') }}
                    </p>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
