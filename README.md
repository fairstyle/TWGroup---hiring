##TWGroup - hiring

###Desafio 1
Visualiza las siguientes estructuras de tablas.

Invoice (id, date, user_id, seller_id, type)
Product (id, invoice_id, name, quantity, price)
En base a esas estructuras, genera utilizando Eloquent, las consultas para obtener la siguiente información:

#### 1.1  Obtener precio total de la factura.
```php
//En caso de que un invoice contenta muchos productos se realizaria una relación de uno a muchos
//Invoice.php
public function productsTotalPrice(){
    return $this->hasMany(Product::class, 'invoice_id', 'id')->select(DB::raw('sum(price*quantity) as totalPrice'));
}

//Para obtener el precio total de todos los productos que esten vinculados al invoice, en este caso utilizo el primer invoice
Invoice::first()->productsTotalPrice->first()->totalPrice;
```

```php
//En caso de que un invoice solo tenga 1 producto se realiza una relación de uno a uno
//Invoice.php
public function product(){
    return $this->hasOne(Product::class, 'invoice_id', 'id');
}

//Models/Invoice.php
public function totalPrice(){
    return $this->price*$this->quantity;
}

//Para obtener el precio total del producto vinculado al invoice, en este caso utilizo el primer invoice
Invoice::first()->product->totalPrice();
```
#### 1.2 Obtener todos id de las facturas que tengan productos con cantidad mayor a 100.
```php
//Para obtener todas las facturas que contengan al menos 1 producto que cuenten con una cantidad mayor a 100
DB::table('invoices') // obtenemos todos los invoices
    ->join('products', 'invoices.id', '=', 'products.invoice_id') // agremos todos los productos que tengan una id igual
    ->where('quantity', '>', 100) // filtramos solo los que tengan una cantidad mayor a 100
    ->selectRaw('invoices.*')  // en caso de que solo se requiera el id 'invoices.id'
    // esta linea que sigue no es requerida en caso de que 1 invoice solo tenga 1 producto
    ->groupBy('invoices.id') // agrupamos los resultados en caso de que se duplique algun invoice
    ->get(); // obtenemos el resultado
```
#### 1.3 Obtener todos los nombres de los productos cuyo valor final sea superior a $1.000.000 CLP.
```php
Product::all()->map(function ($prod) {
    // Si el valor final del producto es mayor a $1.000.000 devuelve el nombre del producto, en caso contrario devuelve un null
    return ($prod->price * $prod->quantity) > 1000000 ? $prod->name: null;
})->filter(); // Filter permite eliminar todos los nulls de la colección
```

###Desafio 2
Indica paso a paso los comandos para una instalación básica de Laravel que me permita ver la página principal (recuerda describir qué hace cada comando).
Existen diferentes formas de generar un proyecto nuevo ya sea con
```shell
    # Desde laravel
    laravel new NombreDelProyecto
    # Laravel = Laravel un paquete que se instala mediante composer
    # new = comando que refiere a que se creara un nuevo proyecto
    
    o
    
    # Desde composer
    composer create-project laravel/laravel NombreDelProyecto
    # composer = Gestión de paquetes en php
    # create-project = Un comando de composer que permite 
    # laravel/laravel = Significa que utilizará ese paquete como base
    
    
    # Después de utilizar cualquiera de estos comandos se creara una versión limpia del proyecto.
    #
    # El siguiente paso es iniciar apache y ingresar a la url, en mi caso utilizo laragon que me
    # provee de un dns local permitiéndome entrar solo con el NombreDelProyecto.test en el navegador
    # en caso de que solo tengan apache y tengan que entrar por ruta seria ip:puerto/public, esto se
    # podría editar en el .htaccess, tengo entendido que en la versión de Laravel superior a 8 este viene
    # con un archivo server.php que ya te redirige hacia public. 
```

###Desafio 3
Respecto a la estructura de datos del desafío 1, agrega a "Invoice" un campo "total" y escribe un Observador (Observer) en el que cada vez que se inserter un registro en la tabla "Product", aumente el valor de "total" de la tabla "Invoice".
```shell
  # Generamos el observer enlazado al modelo Product
  php artisan make:observer ProductObserver --model=Product
```
```php
    //ProductObserver.php
    use App\Models\Invoice; // importamos el modelo
    
    // en created(Product $product)
    $invoice = Invoice::find($product->invoice_id); // Obtenemos el invoice
    $invoice->total += $product->price*$product->quantity; //sumamos el valor actual + el valor total del producto
    $invoice->save(); // guardamos los cambios del invoice

    //EventServiceProvider.php
    use App\Models\Product; // importamos el modelo
    use App\Observers\ProductObserver; // importamos el observer
    
    // en boot()
    Product::observe(ProductObserver::class);
```

###Desafio 4
Explícanos ¿qué es "Laravel Jetstream"? y ¿qué permite "Livewire" a los programadores?
```shell
    # Jetstream es un kit de inicio lanzado para Laravel desde la versión 8 que no viene instalado por defecto
    # pero se puede instalar mediante un comando, se recomienda con desde un proyecto limpio ya que puede causar
    # problemas en un proyecto ya iniciado.
    php artisan jetstream:install livewire
    npm install # Instala las dependencias
    npm run dev # Es un script que permite automatizar la compilación de archivos por ejemplo mix o tailwindcss
    php artisan migrate # Permite ejecutar las migraciones que estan dentro de la carpeta database/migrations, esto crea las tablas en la base de datos
    
    
    # Livewire permite al desarrollador crear componentes dinamicos sin tener que escribir en codigo js, esto
    # permite actualizar las variables sin recargar la pagina completa, ya que solo actualiza el componente
```

###Desafio 5 
Manos al código! basado en las siguientes tablas, construye un pequeño software:


Tablas de la Base de Datos:

- users
- tasks
- logs


Los requerimientos para el software son:

Construir un CRUD, utilizar Bootstrap para el front y en las vistas el uso de Layouts en Blade.

Las funciones a desarrollar son las siguientes:

- ✅ El sistema debe permitir que los usuarios se registren y puedan iniciar sesión, el software no debe permitir que el correo email@hack.net se pueda registrar.
    ```php
        # En app/Http/Controllers/Auth/RegisterController.php
        # Se agregó una condición al validador del correo 'not_in:email@hack.net'
    ```
- ✅ Sólo los usuarios con sesión iniciada deberían poder ver el listado de tareas (tasks)  de la plataforma en la primera pantalla luego de iniciar sesión.
- ✅ El sistema debería permitir que cualquier usuario cree una nueva tarea (tasks), esta debe contener como mínimo la descripción de la tarea, el usuario asignado, la fecha máxima de ejecución.
  ```php
        # En caso de que puedan crear tareas los usuarios sin acceder a su cuenta, seria necesario deshabilitar
        # el middleware y la validación de usuario en el controlador de task.
  ```
- ✅ Cuando un usuario logueado entre a una tarea asignada a él, el sistema debe permitir que este agregue registros (logs) asociados a la tarea, los registros contienen como mínimo el comentario y la fecha de este. Los usuarios no asignados a la tarea, no pueden acceder a ella, solo verla en el listado.
- ✅ Al momento de que se genere un nuevo registro (logs), es necesario que se envíe un correo electrónico al autor de la tarea (Puedes utilizar Mailtrap para Testing, aunque lo importante no es la evidencia del envío, sino el código).
- ✅ En el listado de tareas, el sistema debería mostrar en rojo las tareas cuya "fecha máxima de ejecución" haya expirado respecto a hoy.

Recuerda usar bootstrap en el diseño, y que puedes ingresar todas las tareas que quieras, insertando campos en la tabla tasks.

#### Inicialización del proyecto.
```shell
    # Se creo un proyecto limpio
      laravel new twg-hiring
    
    # Se instala el paquete de inicio laravel/ui
      composer require laravel/ui
    
    # Se instala bootstrap con el parametro --auth que nos provee del Auth, asi no creamos la rueda nuevamente.
      php artisan ui bootstrap --auth
    
    # Instalamos dependencias y ejecutamos scrips
      npm install && npm run dev
      
    # En este caso me salio un error y me pidió instalar
      npm install resolve-url-loader@^4.0.0 --save-dev --legacy-peer-deps
    
    # Volví a ejecutar
      npm install && npm run dev
```

#### Deploy de la APP
```shell
  # 1.- Crear base de datos twg_hiring
  
  # 2.- Ejecutar migraciones 
      php artisan migrate:refresh --seed
    
  # 3.- Levantamos el servidor, aclarar que la base de datos tiene que estar corriendo
      php artisan serve
  
  # 4.- Abrir navegador en http://127.0.0.1:8000/
```

#### Comandos utiles App
```shell
  # 1.- Ejecutar prueba de mail
  php artisan test tests/Unit/MailTest.php
```
