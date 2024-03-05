<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\Models\Line;
use App\Models\Invoice; 
use App\Models\Product;
use PDF;

class InvoiceController extends Controller
{
    /* La función `generateInvoices` en `InvoiceController` es responsable de generar facturas basadas
    en los artículos del carrito de compras. A continuación se muestra un desglose de lo que hace la
    función: */
    public function generateInvoices(Request $request) {
        // Obtener los ítems del carrito
        $cartItems = \Cart::getContent();
        
        // Verificar si el carrito está vacío
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }
        
        // Crear una nueva factura en la tabla 'invoices'
        $invoice = new Invoice();
        $invoice->date_created = now();
        $invoice->total_invoice = 0; // Inicializar el total de la factura en 0
        $invoice->user_id = Auth::id(); // Ajustar según sea necesario
        $invoice->save();
        
        // Inicializar el total de la factura
        $totalInvoice = 0;
    
        // Inicializar array para almacenar datos de productos
        $productsData = [];
        
        // Calcular el total de la factura y crear las líneas de factura
        foreach ($cartItems as $item) {
            // Obtener el producto asociado al ítem del carrito
            $product = Product::find($item->id);    
    
            // Calcular el total de la línea
            $totalLine = $item->quantity * $item->price;
    
            // Crear una nueva línea de factura
            $line = new Line();
            $line->stock = $item->quantity; // Cantidad de productos
            $line->totalPriceProduct = $totalLine; // Precio total de la línea
            $line->product_id = $product->id; // ID del producto
            $line->invoice_id = $invoice->id; // Asociar la línea con la factura creada
            $line->save();
    
            // Agregar datos del producto al array
            $productsData[] = [
                'description' => $product->description,
                'stock' => $line->stock, // Agregar stock desde la tabla Line
                'priceKG' => $product->priceKG,   
                'totalPriceProduct' => $line->totalPriceProduct, // Agregar totalPriceProduct desde la tabla Line
            ];
    
            // Actualizar el total de la factura
            $totalInvoice += $totalLine;
        }
    
        // Asignar el total de la factura
        $invoice->total_invoice = $totalInvoice;
        $invoice->save();
    
        // Vaciar el carrito
        \Cart::clear();

        // Renderizar la vista Blade para generar el PDF
        $pdf = \PDF::loadView('profile.pdf', ['invoice' => $invoice, 'productsData' => $productsData]);
        
        // Descargar el PDF y redirigir a la misma página
        return $pdf->download('factura.pdf');
    }

    /**
     * La función `myInvoices` recupera las facturas que pertenecen al usuario autenticado y las pasa a
     * la vista 'profile.invoices'.
     * 
     * @return La función `myInvoices` devuelve una vista llamada 'profile.invoices' con los datos de
     * las facturas pasados como una variable usando la función `compact`.
     */
    public function myInvoices()
    {
        $user = auth()->user();
        $invoices = Invoice::where('user_id', $user->id)->get();
        return view('profile.invoices', compact('invoices')); 
    }

    /**
     * La función "mostrar" recupera y muestra una factura específica utilizando su ID.
     * 
     * @param id El parámetro "id" en la función "mostrar" representa el identificador único de la
     * factura que desea mostrar. Este parámetro se utiliza para recuperar la factura específica de la
     * base de datos utilizando el método `findOrFail` de Eloquent.
     * 
     * @return La función `show` devuelve una vista llamada 'profile.showinvoice' con los datos de
     * `invoice` pasados utilizando el método `compact`.
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('profile.showinvoice', compact('invoice'));
    }
}
