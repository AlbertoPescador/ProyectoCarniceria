<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * La función productList recupera todos los productos de la base de datos y los pasa a la vista
     * 'productos'.
     * 
     * @return La función `productList()` devuelve una vista llamada 'productos' con los datos de los
     * productos pasados como una variable usando la función `compact()`.
     */
    public function productList()
    {
        $products = Product::all();
        return view('products', compact('products'));
    }

    /**
     * Esta función PHP recupera una lista de productos basada en una categoría específica y los pasa a
     * una vista para su visualización.
     * 
     * @param Request request El parámetro `` en la función `productListByCategory` es una
     * instancia de la clase `Illuminate\Http\Request`. Representa la solicitud HTTP que se realiza al
     * servidor. Este parámetro le permite acceder a los datos de la solicitud, como la entrada del
     * formulario, los parámetros de consulta, los encabezados,
     * @param category El parámetro `categoría` en la función `productListByCategory` representa el ID
     * de categoría de los productos que desea recuperar. Esta función recupera todos los productos que
     * pertenecen al ID de categoría especificado y luego los pasa a la vista "productos" para su
     * visualización.
     * 
     * @return La función `productListByCategory` devuelve una vista llamada 'productos' con los
     * productos que pertenecen a la categoría especificada. Los productos se recuperan de la base de
     * datos según el ID de categoría proporcionado.
     */
    public function productListByCategory(Request $request, $category)
    {
        $products = Product::where('category_id', $category)->get();
        return view('products', compact('products'));
    }

    /**
     * La función busca productos basándose en la entrada de una palabra clave y muestra los resultados
     * paginados con hasta 10.000 elementos por página.
     * 
     * @param Request request El parámetro `Request ` en la función `search` es una instancia
     * de la clase `Illuminate\Http\Request` en Laravel. Representa una solicitud HTTP y le permite
     * acceder a datos de entrada, archivos, cookies y más desde la solicitud.
     * 
     * @return La función `search` devuelve una vista llamada 'products' con las variables ``
     * y `` pasadas usando la función `compact`. La variable `` contiene los
     * resultados de la búsqueda basados en la consulta de búsqueda proporcionada en la entrada de
     * solicitud 'busqueda'. La búsqueda se realiza en las columnas 'id' y 'descripción' del modelo de
     * Producto mediante el comando 'ME GUSTA'
     */
    public function search(Request $request)
    {
        $busqueda = $request->input('busqueda');
        $products = Product::where('id', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('description', 'LIKE', '%' . $busqueda . '%')
            ->latest('id')
            ->paginate(10000); // Obtener hasta 10,000 resultados por página
        
        return view('products', compact('products', 'busqueda'));
    }

    /**
     * La función "ventas" recupera los productos que están en oferta y los pasa a la vista
     * "productos".
     * 
     * @param Request request El parámetro `` en la función `sales` es una instancia de la
     * clase `Illuminate\Http\Request` en Laravel. Representa la solicitud HTTP que se realiza a la
     * aplicación y contiene todos los datos e información relacionados con la solicitud, como datos de
     * entrada, encabezados, cookies, etc.
     * 
     * @return La función "ventas" devuelve una vista denominada "productos" con los productos que
     * tienen el atributo "venta" establecido en verdadero. Los productos se obtienen de la base de
     * datos utilizando el modelo Producto y luego se pasan a la vista utilizando el método "compacto".
     */
    public function sales(Request $request)
    {
        $products = Product::where('sale', true)->get();
        return view('products', compact('products'));
    }

}
