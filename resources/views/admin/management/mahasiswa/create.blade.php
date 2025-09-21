@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk menambahkan data mahasiswa baru.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.management.mahasiswa.index') }}" class="hover:text-green-600">Manajemen
                        Mahasiswa</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Tambah Mahasiswa</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-md border border-red-400">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.management.mahasiswa.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700">Nama</label>
                <input type="text" name="name"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('name') border-red-500 @enderror"
                    value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('password') border-red-500 @enderror"
                    required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">No HP</label>
                <input type="text" name="no_hp"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('no_hp') border-red-500 @enderror"
                    value="{{ old('no_hp') }}">
                @error('no_hp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">NIM</label>
                <input type="number" name="NIM"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('NIM') border-red-500 @enderror"
                    value="{{ old('NIM') }}" required>
                @error('NIM')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Prodi</label>
                <div class="relative">
                    <input type="text" name="prodi" id="prodi-input"
                        class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('prodi') border-red-500 @enderror"
                        value="{{ old('prodi', $mahasiswa->prodi ?? '') }}" required
                        placeholder="Ketik untuk mencari Program Studi">
                    <div id="prodi-suggestions"
                        class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto">
                    </div>
                </div>
                @error('prodi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Foto</label>
                <input type="file" name="foto"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                @error('foto')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2 pt-4">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">Simpan</button>
                <a href="{{ route('admin.management.mahasiswa.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">Batal</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>const staticProdiList=['Informatika','Teknik Industri','Bisnis Digital','Sains Data','Digital Neuropsikologi','Komunikasi Digital','Teknologi Industri Pertanian',];const staticBidangKeahlianList=['Informatika','Teknik Industri','Bisnis Digital','Sains Data','Digital Neuropsikologi','Komunikasi Digital','Teknologi Industri Pertanian',];function renderSuggestions(data,suggestionsContainer,inputElement){suggestionsContainer.innerHTML='';if(data.length>0){data.forEach(item=>{const suggestionItem=document.createElement('div');suggestionItem.textContent=item;suggestionItem.classList.add('px-4','py-2','cursor-pointer','hover:bg-green-100');suggestionItem.addEventListener('mousedown',(e)=>{e.preventDefault();inputElement.value=item;suggestionsContainer.classList.add('hidden')});suggestionsContainer.appendChild(suggestionItem)});suggestionsContainer.classList.remove('hidden')}else{suggestionsContainer.classList.add('hidden')}}
function setupStaticAutocomplete(inputId,suggestionsId,dataList){const input=document.getElementById(inputId);const suggestionsContainer=document.getElementById(suggestionsId);let debounceTimeout;if(!input||!suggestionsContainer){return}
input.addEventListener('focus',function(){renderSuggestions(dataList,suggestionsContainer,input)});input.addEventListener('input',function(){clearTimeout(debounceTimeout);const keyword=this.value.trim().toLowerCase();debounceTimeout=setTimeout(()=>{const filteredData=dataList.filter(item=>item.toLowerCase().includes(keyword));renderSuggestions(filteredData,suggestionsContainer,input)},300)});document.addEventListener('click',function(e){if(!input.contains(e.target)&&!suggestionsContainer.contains(e.target)){suggestionsContainer.classList.add('hidden')}})}
document.addEventListener('DOMContentLoaded',function(){if(document.getElementById('prodi-input')){setupStaticAutocomplete('prodi-input','prodi-suggestions',staticProdiList)}
if(document.getElementById('bidang-keahlian-input')){setupStaticAutocomplete('bidang-keahlian-input','bidang-keahlian-suggestions',staticBidangKeahlianList)}});</script>
@endpush
