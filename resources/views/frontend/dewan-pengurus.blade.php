@extends('layouts.frontend')

@section('title', 'Dewan Pengurus - PUPR')

@section('content')
<!-- Header Banner with Gradient and Pattern -->
<div class="relative bg-gradient-to-br from-[#80311f] via-[#a33f28] to-[#ca4e33] py-20 lg:py-28 overflow-hidden">
    <!-- Decorative patterns -->
    <div class="absolute inset-0 opacity-10">
        <svg class="absolute left-0 top-0 h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0,100 C30,70 70,70 100,100 L100,0 L0,0 Z" fill="url(#grid-pattern)"></path>
        </svg>
        <defs>
            <pattern id="grid-pattern" width="10" height="10" patternUnits="userSpaceOnUse">
                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
            </pattern>
        </defs>
    </div>
    <!-- Floating blobs -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#e3725b] rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#f09684] rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block py-1 px-3 rounded-full bg-[#80311f]/50 border border-[#ca4e33]/30 text-orange-100 text-sm font-semibold tracking-wider mb-4 backdrop-blur-sm">STRUKTUR ORGANISASI</span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6 drop-shadow-md">
            Dewan Pengurus Pusat
        </h1>
        <p class="text-xl md:text-2xl text-orange-50 max-w-3xl mx-auto font-light">
            Pelaku Usaha Pekanbaru Riau (PUPR)
        </p>
    </div>
</div>

<div class="bg-gray-50/50 py-16 lg:py-24 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-32">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 xl:gap-12">
            @forelse($members as $index => $member)
                <!-- Make the first 2 members (Dewan Pendiri & Ketua Pembina) span more if desired, or just keep grid -->
                <div class="group relative bg-white/80 backdrop-blur-xl rounded-[2rem] p-8 shadow-xl shadow-[#ca4e33]/5 border border-white/60 hover:-translate-y-2 transition-all duration-500 overflow-hidden {{ $index < 2 ? 'sm:col-span-2 lg:col-span-1 ring-1 ring-[#ca4e33]/20' : '' }}">
                    <!-- Card decorative elements -->
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-[#fbece9] to-[#f4d1ca] rounded-full blur-2xl opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-[#ca4e33] via-[#d6654c] to-[#e07b64] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>

                    <div class="relative z-10 text-center flex flex-col h-full items-center">
                        <div class="relative w-36 h-36 mb-6">
                            <!-- Animated outer ring -->
                            <div class="absolute inset-0 rounded-full border-2 border-dashed border-[#ca4e33]/30 animate-[spin_10s_linear_infinite] group-hover:border-[#ca4e33] group-hover:animate-[spin_5s_linear_infinite]"></div>
                            
                            <!-- Image container -->
                            <div class="absolute inset-2 bg-white rounded-full p-1 shadow-lg overflow-hidden flex items-center justify-center group-hover:shadow-[#ca4e33]/25 transition-shadow duration-300">
                                @if($member->photo_id)
                                    <img src="{{ \App\Services\GoogleDriveService::getUrl($member->photo_id) }}" alt="{{ $member->name }}" class="w-full h-full rounded-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full rounded-full bg-gradient-to-br from-gray-50 to-gray-200 flex items-center justify-center text-gray-400">
                                        <i class="ri-user-smile-fill text-5xl transform group-hover:scale-110 group-hover:text-[#ca4e33] transition-all duration-300"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Rank badge -->
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-sm font-bold text-[#ca4e33] border border-[#ca4e33]/10">
                                {{ $index + 1 }}
                            </div>
                        </div>

                        <h3 class="text-lg xl:text-xl font-bold text-gray-800 mb-2 group-hover:text-[#ca4e33] transition-colors duration-300 w-full break-words whitespace-normal px-2" title="{{ $member->name }}">{{ $member->name }}</h3>
                        
                        <div class="mt-auto pt-4 w-full border-t border-gray-100">
                            <div class="block w-full px-4 py-2.5 rounded-xl text-sm font-medium bg-[#ca4e33]/10 text-[#ca4e33] border border-[#ca4e33]/20 shadow-sm group-hover:bg-[#ca4e33] group-hover:text-white transition-colors duration-300 text-center leading-relaxed break-words whitespace-normal">
                                {{ $member->position }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100 mt-20">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-[#ca4e33]/10 mb-6 relative">
                        <i class="ri-team-fill text-4xl text-[#ca4e33]"></i>
                        <div class="absolute -right-2 -bottom-2 w-8 h-8 bg-white rounded-full flex items-center justify-center">
                            <i class="ri-search-line text-gray-400"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum ada data pengurus</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Struktur dewan pengurus saat ini sedang dalam proses pembaruan data.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
