<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Principal</title>
</head>
<body>
    <x-app-layout>
        <div class="container px-12 py-8 mx-auto">
            @if(session()->has('success'))
                <script>
                    window.onload = function() {
                        alert("{{ session('success') }}");
                    };
                </script>
            @endif
    
            <h3 class="text-2xl font-bold text-gray-900">Últimos productos</h3>
            <div class="h-1 bg-gray-800 w-48"></div>
            <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    <div class="w-full max-w-sm mx-auto overflow-hidden bg-white rounded-md shadow-md">
                        <div class="relative">  
                            <img src="{{ url($product->urlImagen) }}" alt="" class="w-full h-60 object-cover">
                            <div class="absolute bottom-0 left-0 w-full bg-gray-900 bg-opacity-50 text-white p-2">
                                <span class="text-sm font-semibold">{{ $product->description }}</span>
                                <span class="block mt-1">{{ $product->priceKG }}€</span>
                            </div>
                        </div>
                        <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data" class="flex justify-end">
                            @csrf
                            <input type="hidden" value="{{ $product->id }}" name="id">
                            <input type="hidden" value="{{ $product->description }}" name="name">
                            <input type="hidden" value="{{ $product->priceKG }}" name="price">
                            <input type="hidden" value="{{ $product->urlImagen }}"  name="image">
                            <input type="hidden" value="1" name="quantity">
                            <button class="px-6 py-2 text-white text-lg bg-gray-900 rounded">Añadir al carro</button>
                        </form>
                        
                    </div>
                @endforeach
            </div>
        </div>
    </x-app-layout>
</body>
</html>

    
