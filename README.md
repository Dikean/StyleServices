<div align="center">
  <h1>StyleService</h1>
</div>


<table align="center">
  <tr>
    <td>
      <a href="https://github.com/laravel/framework/actions">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/YouTube_social_white_squircle.svg/2048px-YouTube_social_white_squircle.svg.png" alt="Build Status" style="width: 50px; vertical-align: middle;">
      </a>
    </td>
    <td>
      <a href="https://github.com/laravel/framework/actions">
      Ver video ejemplo
      </a>
    </td>
  </tr>
</table>




## # 1 Descargar Laragon

- Visita la página de Laragon: https://laragon.org/download/index.html y descargar la version: Download Laragon - Full (173 MB)

## # 2 despues de instalarlo hacer los siguentes pasos: 

- Descarga o clona el proyecto desde Github a la carpeta www de Laragon.
- Asegúrate de que el servidor Apache y MySQL estén activados en Laragon.
- Abre una terminal en la carpeta del proyecto dentro de la carpeta www de Laragon.
- Ejecuta el comando "composer install" para instalar las dependencias de Laravel

   <pre><code> composer install</code></pre>
   
- instalar las dependencias de front-end

   <pre><code> npm install </code></pre>
  
## # 3 Migraciones

- Ejecuta el comando para correr las migraciones de Laravel y crear las tablas necesarias en la base de datos

 <pre><code> php artisan migrate</code></pre>
 
- Te pedira crear la tabla dale yes

## # 4 crear seeders

- Ejecuta los siguentes comandos en la terminal para los seeders
<pre><code> php artisan db:seed Databaseseeder</code></pre>

**Usuarios creados por los seeders**
- admin@gmail.com - admin123
- estilista02@gmail.com - estilista123
- cliente01@gmail.com - cliente123

## # 5  Dirección IPv4
- ejecutamos el siguente comando para ver la dirrecion IPV4
<pre><code> ipconfig</code></pre>

## # 6  Host laragon
- Copiamos en nuestro archivo la dirrecion IPV4

## # 7 Ejecutar 
- Para ejecutar toda la aplicacion
<pre><code>  php artisan serve --host=192.168.1.8</code></pre>




