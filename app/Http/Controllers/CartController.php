<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * La función `cartList` recupera el contenido del carrito y lo pasa a la vista 'carrito'.
     * 
     * @return La función `cartList` devuelve una vista llamada 'cart' con los datos de la variable
     * `` que se le pasan usando la función `compact`.
     */
    public function cartList()
    {
        $cartItems = \Cart::getContent();
        return view('cart', compact('cartItems'));
    }

    /**
     * La función addToCart agrega un producto al carrito y muestra un mensaje de éxito.
     * 
     * @param Request request La función `addToCart` en el fragmento de código proporcionado es un
     * método que agrega un producto al carrito de compras. Primero valida los datos de la solicitud
     * entrante para garantizar que los campos requeridos (`id`, `nombre`, `precio`, `cantidad`,
     * `imagen`) estén presentes.
     * 
     * @return La función `addToCart` devuelve una respuesta de redireccionamiento a la ruta denominada
     * 'products.list'.
     */
    public function addToCart(Request $request)
    {
        // Validación
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'image' => 'required',
        ]);

        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => [
                'image' => $request->image,
            ]
        ]);

        // Añadimos un mensaje específico para indicar que se ha añadido un producto al carrito
        $productName = $request->name;
        session()->flash('success', "El producto '$productName' ha sido añadido al carrito correctamente!");

        return redirect()->route('products.list');
    }

    /**
     * La función `updateCart` actualiza la cantidad de un producto en el carrito y redirige a la
     * página de lista del carrito con un mensaje de éxito.
     * 
     * @param Request request La función `updateCart` se utiliza para actualizar la cantidad de un
     * producto en el carrito de compras. Toma un objeto `Solicitud` como parámetro, que contiene los
     * datos enviados por el cliente en la solicitud HTTP.
     * 
     * @return La función `updateCart` devuelve una respuesta de redireccionamiento a la ruta
     * denominada 'cart.list'.
     */
    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );
        session()->flash('success', 'Producto modificado correctamente !');
        return redirect()->route('cart.list');
    }

    /**
     * La función elimina un producto del carrito y lo redirige a la página de la lista del carrito
     * mientras muestra un mensaje de éxito.
     * 
     * @param Request request El parámetro `` en la función `removeCart` es una instancia de la
     * clase `Illuminate\Http\Request`. Representa la solicitud HTTP que se realiza al servidor. En
     * este contexto, se utiliza para recuperar el parámetro "id" de la solicitud para eliminar un
     * parámetro específico.
     * 
     * @return La función `removeCart` devuelve una respuesta de redireccionamiento a la ruta
     * denominada `cart.list`.
     */
    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Producto eliminado correctamente !');
        return redirect()->route('cart.list');
    }

    /**
     * La función borra todos los artículos del carrito de compras y muestra un mensaje de éxito antes
     * de redirigir a la página de lista del carrito.
     * 
     * @return La función `clearAllCart()` devuelve una respuesta de redireccionamiento a la ruta
     * denominada 'cart.list'.
     */
    public function clearAllCart()
    {
        \Cart::clear();
        session()->flash('success', 'Todos los productos fueron eliminados !');
        return redirect()->route('cart.list');
    }
}