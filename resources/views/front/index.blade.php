@extends('front.layouts.app')
@section('content')
    <div class="font-poppins text-[#030303] bg-[#F6F5FA] pb-[100px] px-4 sm:px-0">
    <x-nav/>
    <section id="header" class="container max-w-[1130px] mx-auto mt-[50px]">
    <div class="flex flex-col gap-8">
        <h1 class="font-extrabold text-[40px] leading-[45px] text-center sm:text-left">
            Temukan Peluang<br>
            Kerja di Balikpapan
        </h1>

        <!-- FORM FILTER DENGAN STYLE TAILWIND LANGSUNG -->
        <form action="{{ route('front.index') }}" method="GET" class="bg-[#fffff] rounded-2xl shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Filter Lowongan</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lowongan</label>
                    <input type="text" name="name" id="name" placeholder="Contoh: Jasa Desain Grafis" value="{{ request()->get('name') }}" 
                           class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6635F1] transition">
                   </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" id="category_id" 
                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6635F1] transition">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request()->get('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="job_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Pekerjaan</label>
                    <select name="job_type" id="job_type" 
                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6635F1] transition">
                        <option value="">Semua Jenis</option>
                        @foreach($job_types as $job_type)
                            <option value="{{ $job_type }}" {{ request()->get('job_type') == $job_type ? 'selected' : '' }}>
                                {{ $job_type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="location_district" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kecamatan</label>
                    <input type="text" name="location_district" id="location_district" placeholder="Contoh: Balikpapan Utara" value="{{ request()->get('location_district') }}" 
                           class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6635F1] transition">
                </div>

                <div class="md:col-span-2 flex gap-3 items-end">
                    <button type="submit" 
                            class="w-full font-bold bg-[#6635F1] text-white py-2 px-4 rounded-lg hover:bg-[#4314e8] transition-all duration-300">
                        Cari
                    </button>
                    <a href="{{ route('front.index') }}" 
                       class="w-full text-center font-bold bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 transition-all duration-300">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</section>


    <section id="categories" class="container max-w-[1130px] mx-auto flex flex-col gap-4 mt-[50px]">
        <h2 class="font-bold text-xl">Browse Categories</h2>
        <div class="grid grid-cols-1 sm:grid-cols-5 gap-5">
            @forelse ($categories as $category)
            <a href="{{route('front.category', $category->slug)}}" class="card">
                <div class="p-5 rounded-[20px] bg-white flex flex-col gap-[30px] hover:ring-2 hover:ring-[#6635F1] transition-all duration-300">
                    <div class="w-full sm:w-[150px] h-[100px] flex shrink-0 rounded-[20px] overflow-hidden bg-[#D9D9D9]">
                        <img src="{{Storage::url($category->icon)}}" class="w-full h-full object-cover ro" alt="thumbnail">

                    </div>
                    <div class="flex flex-col gap-[6px]">
                        <p href="" class="font-semibold text-lg">{{$category->name}}</p>
                        <p class="text-sm text-[#545768]">{{$category->projects->where('has_finished', false)->count()}} jobs available</p>
                    </div>
                </div>
            </a>
            @empty
            <p>Belum ada kategori</p>
            @endforelse
        </div>
    </section>

    @if($featured_clients->isNotEmpty())
    <section id="featured-clients" class="bg-[#F6F5FA] py-12 rounded-[20px] mt-[50px]">
        <div class="container max-w-[1130px] mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-2">
                <h2 class="font-bold text-xl text-[#030303]">Sorotan UKM Lokal</h2>
                <a href="#" class="font-semibold text-sm text-[#6635F1] hover:underline">Lihat Semua</a>
            </div>
            <!-- Horizontal Scroll Container -->
            <div class="flex gap-6 overflow-x-auto pb-2">
                @foreach ($featured_clients as $client)
                <a href="" class="card">
                <div class="p-5 rounded-[20px] bg-white flex flex-col gap-[30px] hover:ring-2 hover:ring-[#6635F1] transition-all duration-300">
                    <div class="w-full sm:w-[150px] h-[100px] flex shrink-0 rounded-[20px] overflow-hidden bg-[#D9D9D9]">
                        <img src="{{Storage::url($client->avatar)}}" class="w-full h-full object-cover ro" alt="thumbnail">

                    </div>
                   <div class="flex flex-col text-center gap-1">
                        <p class="font-bold text-base text-[#030303] truncate" title="{{ $client->name }}">{{ $client->name }}</p>
                        <p class="text-sm text-[#545768] truncate" title="{{ $client->occupation }}">{{ $client->occupation }}</p>
                    </div>
                </div>
            </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section id="featured" class="container max-w-[1130px] mx-auto flex flex-col gap-4 mt-[50px]">
        <h2 class="font-bold text-xl">Featured Projects</h2>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-5">
            
            @forelse ($projects as $project)
            <a href="{{route('front.details', $project)}}" class="card">
                <div class="p-5 rounded-[20px] bg-white flex flex-col gap-5 hover:ring-2 hover:ring-[#6635F1] transition-all duration-300">
                    <div class="w-full h-[140px] rounded-[20px] overflow-hidden relative">

                        @if ($project->has_finished)
                        <div class="font-bold text-xs leading-[18px] text-white bg-[#2E82FE] p-[2px_10px] rounded-full w-fit absolute top-[10px] left-[10px]">CLOSED</div>
                        @else
                            @if($project->has_started) 
                            <div class="font-bold text-xs leading-[18px] text-white bg-[#2E82FE] p-[2px_10px] rounded-full w-fit absolute top-[10px] left-[10px]">IN PROGRESS</div>
                            @else
                            <div class="font-bold text-xs leading-[18px] text-white bg-[#2E82FE] p-[2px_10px] rounded-full w-fit absolute top-[10px] left-[10px]">HIRING</div>
                            @endif
                        @endif
                        <img src="{{Storage::url($project->thumbnail)}}" class="w-full h-full object-cover" alt="thumbnail">
                    </div>
                    <div class="flex flex-col gap-[10px]">
                        <p class="title font-semibold text-lg min-h-[56px] line-clamp-2 hover:line-clamp-none">{{$project->name}}</p>
                        <div class="flex items-center gap-[6px]">
                            <div>
                                <img src="{{asset('assets/icons/dollar-circle.svg')}}" alt="icon">
                            </div>
                            <p class="font-semibold text-sm">Rp {{number_format($project->budget, 0, ',', '.')}}</p>
                        </div>
                        <div class="flex items-center gap-[6px]">
                            <div>
                                <img src="{{asset('assets/icons/verify.svg')}}" alt="icon">
                            </div>
                            <p class="font-semibold text-sm">Payment Verified</p>
                        </div>
                        <div class="flex items-center gap-[6px]">
                            <div>
                                <img src="{{asset('assets/icons/crown.svg')}}" alt="icon">
                            </div>
                            <p class="font-semibold text-sm">{{$project->skill_level}}</p>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <p>Belum ada </p>
            @endforelse
        </div>
    </section>
    <section id="newest" class="container max-w-[1130px] mx-auto flex flex-col sm:flex-row sm:flex-nowrap gap-5 mt-[50px]">
        <div class="flex flex-col gap-4 w-full">
            <h2 class="font-bold text-xl">Newest Projects</h2>
            <div class="flex flex-col gap-5">
                @forelse($projects as $project)
                <div class="card hover:ring-2 hover:ring-[#6635F1] transition-all duration-300 bg-white p-5 rounded-[20px] flex flex-col sm:flex-row sm:items-center gap-[18px] w-full">
                    <a href="{{route('front.details', $project)}}" class="w-full sm:w-[200px] h-[150px] flex shrink-0 rounded-[20px] overflow-hidden bg-[#D9D9D9]">
                        <img src="{{Storage::url($project->thumbnail)}}" class="w-full h-full object-cover" alt="thumbnail">
                    </a>
                    <div class="flex flex-col gap-[10px]">
                        @if ($project->has_finished)
                        <div class="font-bold text-xs leading-[18px] text-white bg-[#2E82FE] p-[2px_10px] rounded-full w-fit">CLOSED</div>
                        @else
                            @if($project->has_started) 
                            <div class="font-bold text-xs leading-[18px] text-white bg-[#2E82FE] p-[2px_10px] rounded-full w-fit">IN PROGRESS</div>
                            @else
                            <div class="font-bold text-xs leading-[18px] text-white bg-[#2E82FE] p-[2px_10px] rounded-full w-fit">HIRING</div>
                            @endif
                        @endif

                        <a href="{{route('front.details', $project)}}" class="font-semibold text-lg leading-[27px]">{{$project->name}}</a>
                        <p class="text-sm leading-7 line-clamp-2">{{$project->about}}</p>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <div class="flex items-center gap-[6px]">
                                <div>
                                    <img src="{{asset('assets/icons/dollar-circle.svg')}}" alt="icon">
                                </div>
                                <p class="font-semibold text-sm">Rp {{number_format($project->budget, 0, ',', '.')}}</p>
                            </div>
                            <div class="flex items-center gap-[6px]">
                                <div>
                                    <img src="{{asset('assets/icons/verify.svg')}}" alt="icon">
                                </div>
                                <p class="font-semibold text-sm">Payment Verified</p>
                            </div>
                            <div class="flex items-center gap-[6px]">
                                <div>
                                    <img src="{{asset('assets/icons/crown.svg')}}" alt="icon">
                                </div>
                                <p class="font-semibold text-sm">{{$project->skill_level}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p>Belum ada project terbaru</p>
                @endforelse
            </div>
        </div>
        <div class="flex flex-col sm:w-[300px] h-fit shrink-0 bg-white rounded-[20px] p-5 gap-[30px] sm:mt-[45px]">
            <div class="flex flex-col gap-3">
                <h3 class="font-semibold">Your Profile</h3>
                @auth
                <div class="flex items-center gap-3">
                    <div class="w-[50px] h-[50px] rounded-full overflow-hidden flex shrink-0">
                        <img src="{{Storage::url(Auth::user()->avatar)}}" class="w-full h-full object-cover" alt="photo">
                    </div>
                    <div class="flex flex-col gap-[2px]">
                        <p class="font-semibold">Hi, {{Auth::user()->name}}</p>
                        <p class="text-sm leading-[21px] text-[#545768]">911 Finished Projects</p>
                    </div>
                </div>
                <div class="flex items-center gap-[6px]">
                    <div class="flex items-center">
                        <div>
                            <img src="{{asset('assets/icons/Star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icons/Star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icons/Star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icons/Star.svg')}}" alt="star">
                        </div>
                        <div>
                            <img src="{{asset('assets/icons/Star-grey.svg')}}" alt="star">
                        </div>
                        <p class="font-semibold text-sm">(893)</p>
                    </div>
                </div>
            </div>
           @if(Auth::user()->is_freelancer)
            <div class="flex flex-col gap-[10px] rounded-[20px] p-[10px_14px] bg-[#030303]">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 flex shrink-0">
                        <img src="{{asset('assets/icons/story.svg')}}" alt="">
                    </div>
                    <p class="text-sm text-white">You have <span class="font-bold">{{Auth::user()->connect}}</span> connects available to get a new job</p>
                </div>
                <a href="" class="font-semibold text-white text-sm hover:underline text-center">Top Up Connect</a>
            </div>

            <div class="flex flex-col gap-3">
                <h3 class="font-semibold">Resources</h3>
                <div class="flex flex-col gap-[18px]">
                    <a href="" class="resources-card">
                        <div class="group flex gap-3 items-center">
                            <div class="w-[50px] h-[50px] flex shrink-0">
                                <img src="{{asset('assets/icons/perosnalcard.svg')}}" alt="icon">
                            </div>
                            <div class="flex flex-col justify-center gap-[2px]">
                                <p class="font-semibold group-hover:underline">Gawe Academy</p>
                                <p class="text-sm text-[#545768]">Improve your skills today</p>
                            </div>
                        </div>
                    </a>
                    <a href="" class="resources-card">
                        <div class="group flex gap-3 items-center">
                            <div class="w-[50px] h-[50px] flex shrink-0">
                                <img src="{{asset('assets/icons/note-add.svg')}}" alt="icon">
                            </div>
                            <div class="flex flex-col justify-center gap-[2px]">
                                <p class="font-semibold group-hover:underline">Invoice Marker</p>
                                <p class="text-sm text-[#545768]">Get the payment faster</p>
                            </div>
                        </div>
                    </a>
                    <a href="" class="resources-card">
                        <div class="group flex gap-3 items-center">
                            <div class="w-[50px] h-[50px] flex shrink-0">
                                <img src="{{asset('assets/icons/ruler&pen.svg')}}" alt="icon">
                            </div>
                            <div class="flex flex-col justify-center gap-[2px]">
                                <p class="font-semibold group-hover:underline">Assets Pixels Pro</p>
                                <p class="text-sm text-[#545768]">Design templates</p>
                            </div>
                        </div>
                    </a>
                    <a href="" class="resources-card">
                        <div class="group flex gap-3 items-center">
                            <div class="w-[50px] h-[50px] flex shrink-0">
                                <img src="{{asset('assets/icons/code.svg')}}" alt="icon">
                            </div>
                            <div class="flex flex-col justify-center gap-[2px]">
                                <p class="font-semibold group-hover:underline">Codelab Testing Unit</p>
                                <p class="text-sm text-[#545768]">Development</p>
                            </div>
                        </div>
                    </a>
                    <a href="" class="resources-card">
                        <div class="group flex gap-3 items-center">
                            <div class="w-[50px] h-[50px] flex shrink-0">
                                <img src="{{asset('assets/icons/user-octagon.svg')}}" alt="icon">
                            </div>
                            <div class="flex flex-col justify-center gap-[2px]">
                                <p class="font-semibold group-hover:underline">Interview Mocking</p>
                                <p class="text-sm text-[#545768]">Deal with your top clients</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @endauth
            <hr>
        </div>
    </section>
    </div>
@endsection
