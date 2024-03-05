<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carrito</title>
</head>
<body>
    <x-app-layout>
        <main class="my-8">
            <div class="container px-6 mx-auto">
                <div class="flex justify-center my-6">
                    <div class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg pin-r pin-y md:w-4/5 lg:w-4/5">
                        @if ($message = Session::get('success'))
                            <div class="p-4 mb-3 bg-blue-400 rounded">
                                <p class="text-white">{{ $message }}</p>
                            </div>
                        @endif
                        <h3 class="text-3xl font-bold">Carro</h3>
                        <div class="flex-1">
                            <table class="w-full text-sm lg:text-base" cellspacing="0">
                                <thead>
                                    <tr class="h-12 uppercase">
                                        <th class="hidden md:table-cell"></th>
                                        <th class="text-left">Nombre</th>
                                        <th class="pl-5 text-left lg:text-right lg:pl-0">
                                            <span class="lg:hidden" title="Quantity">Qtd</span>
                                            <span class="hidden lg:inline">Cantidad/KG</span>
                                        </th>
                                        <th class="hidden text-right md:table-cell"> Precio/KG</th>
                                        <th class="hidden text-right md:table-cell"> Eliminar </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td class="hidden pb-4 md:table-cell" style="width:230px;">
                                                <img src="{{ $item->attributes->image }}" class="w-[200px] rounded" alt="Thumbnail">
                                            </td>
                                            <td>
                                                <p class="mb-2 text-gray-900 font-bold">{{ $item->name }}</p>
                                            </td>
                                            <td class="justify-center mt-6 md:justify-end md:flex">
                                                <div class="h-10 w-28">
                                                    <div class="relative flex flex-row w-full h-8">
                                                        <form action="{{ route('cart.update') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $item->id}}" class="" >
                                                            <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                            class="w-full text-center h-10 text-gray-800 outline-none rounded border border-gray-600 py-3" />
                                                            <button class="w-full px-4 mt-1 py-1.5 text-sm rounded shadow text-violet-100 bg-gray-800">Actualizar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="hidden text-right md:table-cell">
                                                <span class="text-sm font-medium lg:text-base">
                                                    {{ $item->price }}€
                                                </span>
                                            </td>
                                            <td class="hidden text-right md:table-cell">
                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" value="{{ $item->id }}" name="id">
                                                    <button class="px-3 py-1 text-white bg-gray-800 shadow rounded-full">x</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="flex justify-between items-center my-5">
                                <div class="font-semibold text-2xl">Total: {{ Cart::getTotal() }}€</div>
                                <div>
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        <button class="px-6 py-2 text-sm rounded shadow text-red-100 bg-gray-800">Vaciar Carro</button>
                                    </form>
                                </div>
                            </div>
                            <div class="flex justify-start items-center my-5">
                                <div>
                                    <form action="{{ route('invoice.generateInvoices') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-6 py-2 text-sm rounded shadow text-red-100 bg-gray-800">Generar Factura</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </x-app-layout>
</body>
</html>
