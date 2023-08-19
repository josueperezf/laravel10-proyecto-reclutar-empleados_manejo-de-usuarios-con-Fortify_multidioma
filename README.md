# Laravel empleos

para este ejemplo se asume que tenemos instalado en nuestra maquina docker, wsl, y alli un acceso directo a sail para no estar escribien vendor/sail, si no solo sail. en google drive tengo una guia de como hacerlo

despues de levantar el proyecto, podemos ver los email que envia el mismo en la ruta <http://127.0.0.1:8025/#>

para conectarnos a la base de datos
* puerto para el acceso a la base de datos desde laravel laravel ```3306```
* en el archivo .env debemos agregar lo siguiente ```FORWARD_DB_PORT=3307```, puerto para el acceso a la base de datos desde el editor externo, ejemplo dbVisualizer ```3307```
* nombre de la base de datos ```laravel_empleos```
* nombre de usuario ```sail```
* password ```password```

trate de colocar root como nombre de usuario y no se quiso conectar



## pasos para levantar el proyecto

1. tener el ambiente docker y demas, si no lo tenemos, aqui esta una [guia](#pasos-para-configurar-docker-para-proyecto-laravel-9)
2. despues de tener todo bien del paso 1, debemos loguearnos en una terminal ```wsl --distribution Ubuntu --user josue```
3. estando alli debemo lenvantar el contenedor, luego de hacer el paso 1, en esa terminal debemos movernos a la carpeta del proyecto, y ejecutar ```./vendor/bin/sail up```
4. debemos abrir otra terminal, ejecutar el paso 2, y alli correr el comando  ```./vendor/bin/sail npm run dev```, si tenemos el alias creado, podemos correr ```sail npm run dev``` que es una version mas corta del mismo comando
5. si hicimos algun cambio, ejemplo cambiamos una clase css y no vemos los cambios, podemos pararnos en la terminal donde tenemos corriendo el npm, y presionar la tecla ```r```, esto refresca
6. si queremo ejecutar otros comandos, ejemplo correr migraciones, crear controladores con artisan o lo que sea, tendriamos que abrir otra terminal, hacer el paso dos y alli si ejecutar el comando, claro despues de movernos hasta la carpeta del proyecto, si tenemos el alias colocamos sail, si no pues nos toca coloca ./vendor/bin/sail antes de cada comando que vayamos a ejecutar


## comandos basicos
para correr cualquiera de estos proyecto se debe tener docker corriendo, luego en estar logueados en una terminar con: ```wsl --distribution Ubuntu --user josue``` y alli podemos ejecutar lo que queramos, si no tenemos docker o wsl, entonces podemos instalarlo segun esta [guia](#pasos-para-configurar-docker-para-proyecto-laravel-9)

1. para crear un modelo, migracion y controlador al mismo tiempo: ```sail php artisan make:model --migration --controller Comentario``` crea comentarioController
2. crear una migracion para hacer alter table ```sail php artisan make:migration add_imagen_to_users_table```  debe finalizar en ```users_table``` para que laravel nos cargue automaticamente la referencia a la tabla, en este caso ```users```. IMPORTANTE, si en el metodo 'up' de ese archivo hacemos lo de crear la columna imangen, en el metodo 'down' de ese mismo archivo debemos hacer el de quitar esa misma columna imagen por si decidimos  hacer rollback de la migracion
3. para correr las migraciones o solo las que no hayamos corrido aún ```sail php artisan migrate```
4. para listar todos las rutas con los controladores encargados ```sail php artisan route:list ```
5. para deshacer la ultima migracion que se corrio ```sail php artisan migrate:rollback --step=1```
6. para deshacer las ultima 2 migraciones que se corrio ```sail php artisan migrate:rollback --step=2```
7. para deshacer todas las migraciones ```sail php artisan migrate:rollback```
8. policy: sirve para poder limitaciones de acceso, por ejemplo que un post o publicacion, solo pueda ser eliminado o modificado por el usuario que lo creo.
   * para crear un policy: ```sail php artisan make:policy PostPolicy --model=Post``` el model es para indicar a que modelo o tabla de base de datos estara relacionado. este comando genera un ejemplo de un poslicy, y lista algunos metodo que se podrian controlar, como create, update, etc, nosotros borramos los que no necesitamos y colocamos nuestro codigo en el metodo que necesitemos, para este ejemplo en el delete
9. para crear componentes blade reutiliza codigo html, muy util ```sail php artisan make:component ListarPost```,  [Para mas detalles de como crear un componente blade](#reutilizar-html-en-vistas-blade-con-paso-de-variables-mediante-components)


## ejemplo de validaciones en laravel
1. el username es requerido, debe ser unico, minimo 3 caracteres, maximo 30, y en su contenido no su valor no puede ser ejemplo: twitter,editar-perfil,xxx y muchos mas, solo no debe llevar espacios en blanco entre las coma y la palabra 'twitter, editar-perfil' LO ANTERIOR NO DEBE SER, DEBE SER PEGADO

```
$this->validate($request, [
    'username' => [
        'required',
        'unique:users',
        'min:3',
        'max:30',
        'not_in:twitter,editar-perfil,xxx',
    ]
]);
```
2.  ejemplo que el username sea unico pero al momento de editar un usuario

```
$this->validate($request, [
    'username' => [
        'unique:users,username,'.auth()->user()->id,  // campo unico es username, users hace referencia al nombre de la tabla
    ]
]);
```

3. validar ejemplo el genero de un usuario, aunque en este proyecto no se maneja, es solo un ejemplo, de que solo puede ser El strin MASCULINO O FEMENINO
```
$this->validate($request, [
    'username' => [
        'required',
        'unique:users',
        'min:3',
        'max:30',
        'in:MASCULINO,FEMENINO',
    ]
]);
```


## reutilizar html en vistas blade con paso de variables, mediante components

se notó que hay codigo que se repite en varios archivos blade,
para evitar ello se creo un componente mediante el comando: ```sail php artisan make:component ListarPost```
este comando crea dos archivo.
    1. uno en la carpeta view/ListarPost.php que es el archivo de recibir los parametros para que los pueda recibir la vista.
    2. el otro archivo que se crea la vista como tal, la crea en resources/view/listar-post.blade.php que es donde pegamos el html que vamos a reutilizar

para poder utilizarla debemos colocar una etiqueta html con ```<x-Nombre-de-la-vista />``` algo similar a react,
para que esta vista pueda recibir variables, se debe colocar dos puntos y el nombre de la variable que se envia ```:posts="$posts"```.
la variable que se envia llega primero al archivo php. para este ejemplo se llama 'ListarPost',
ese archivo debe recibir los parametros que le enviamos en el html ```$posts``` en el constructor y colocarlo en una variable interna de esa clase, algo como ```$this->posts = $posts;```
luego de hacer lo anterior diriamos que ya esta listo, pero no, se debe ejecutar un comando en la terminal para limpiar algo parecido a la cache para que tome los cambios,
esto se hace ejecutando en la terminal el comando: ```sail php artisan view:clear```

ya con esto seria suficiente para poder utilizar el componente en cuantos lugares queramos




## configuracion de docker si no la tenemos

sail: laravel utiliza docker en las versiones mas recientes. sail es una herramienta que trae laravel hace sencillo comunicarnos con docker.
sail es un cli para comunicarnos, interactuar con los archivos docker para arrancar tus servicios, llamar artisan, o instalar dependencias de NPM


### PASOS PARA CONFIGURAR DOCKER PARA PROYECTO LARAVEL 9

1. debemos tener Docker Desktop
2. debemos tener WSL2 instalado
3. debemos crear una distribucion, es decir un sistema operativo si no lo tenemos, para ello:
	a. levantar un power shell como administrador
	b. ejecutar el comando ```wsl.exe -l -v```
	c. ejecutamos ```wsl --list --online```
	d. ejecutamos ```wsl --install -d Ubuntu``` al terminar no mostrara una terminal y nos pedira un nombre de usuario para ubunto, para este ejemplo fue ``` user josue y password '2763867v```
	e. cerramos la terminal
4. abrimos un power shell con nuestro sistema operativo linux que creamos, para ello ejecutamos en el power shell el comando ```wsl --distribution Ubuntu --user josue``` recordemos que es dependiendo a nuestra distribucion y demas. el siguiente no lo ejecutes solo es ejemplo ```wsl --distribution <Distribution Name> --user <User Name>``` cambiar el ```<Distribution Name>``` por el nombre de nuestra distribucion de linux. se entiende
5. colocamos ```wsl --set-default Ubuntu 2```     => el dos es para indicarle qye trabaje con la version 2
6. ejecutamos ```wsl.exe --set-default-version 2```
7. debemos abrir docker desktop, ir a la tuerca 'configuracion', alli ir a 'resources', en ese lugar buscamos 'WSL integration', entonces veremos algo donde diga ubuntu, lo habilitamos, aplicamos y reiniciamos



### PASOS PARA CREAR ALIAS DE SAIL

para este proyecto se creo un alias para no tener que estar escribiendo ```./vendor/bin/sail up``` si no solo sail up, claro debemos estar en la carpeta del proyecto primero y estar en la power shell y loguearnos ```wsl --distribution Ubuntu --user josue```,
	luego de ello ya en vez de colocar php artisan migrate , colocamos ``` sail php artisan migrate ```
	o en vez de npm install se coloca ``` sail npm install ```
	si no tuvieramos el alias  ```./vendor/bin/sail npm install``` , ``` ./vendor/bin/sail php artisan migrate```



## plugins

para esta documentacion asumimos que tenemos sail, docker corriendo, y que estamos autenticados en la terminal swl. si no lo recordamos la clave, podemos ver la siguiente linea alli esta en que debe 
abrir power shell, loguearnos ```wsl --distribution Ubuntu --user josue```, estando alli colocamos el siguiente comando ```sudo nano ~/.bashrc``` alli nos pedira el password 2763867v


recordemos que si no tenemos sail y estamos utilizando xampp, entonces no colocamos sail, si no solo php artisan o lo que de componser

1. ```Laravel Breeze ```, documentacion oficial <https://laravel.com/docs/10.x/starter-kits>  se instala mediante el comando:  ```sail composer require laravel/breeze --dev```, este es un paquete de laravel para la autenticacion de nuestras aplicaciones, incluye funciones de crear cuenta de usuario, autenticar, resetear password, confirmar cuenta y verificar email. es ligero y minimalista. esta hecho con Blade y tailwind CSS. una vez ejecutado el comando anterior debemos ejecutar ```sail php artisan breeze:install```, alli nos hara unas preguntas, para este ejemplo para la primera pregunta, la respuesta seria ```blade```, para la segunda pregunta, que si queremos que soporte diseño claro u oscuro, escogemos lo que queramos, pero recomiendo claro para que el cliente despues no quiera todo el sistema asi. para la tercera pregunta es sobre las pruebas que se haran, para este ejemplo no se haran pruebas, pero como nos obliga a escoger una, seleccione ```PHPUnit```. ahora debemos instalar las dependencias ejecutamos ```sail npm install```, despues de eso debemos levantar el fontend con el comando ```sail npm run dev```, si no levanta o algo asi, bajamos el proyecto con ```control c```, luego hacemos ```sail down```, despues ```sail up```, despues ```sail npm install``` y luego ```sail npm run dev```. si no vemos bien el css, entonces abrimos una nueva terminal, nos movemos a la carpeta del proyecto, sin estar en ```wsl```, ejecutamos el ```npm install```, y luego ```npm run dev```, esto soluciona todo
   * Ahora debemos abrir el modelo de user y en el agregar la implentacion ```implements MustVerifyEmail``` para que el usuario deba validar el codigo que se le envio al correo
   * cuando se envia un correo, como estamos en modo local, laravel lo envia  mediante una forma local, y lo podemos ver en la ruta <http://127.0.0.1:8025/#> esto lo sabemos ya que el docker desktop vemos el listado de herramientas que se levantan con docker
   * si desea personalizar el mensaje que envia al correo tiene dos opciones
    1.  podemos decir a laravel que nos genere los html para editarlo, <font color='yellow' >esta es la mejor opcion</font>, ya que podemos agregar imagene y demas al correo que enviara. para ello en la terminal debemos ejecutar el comando ```php artisan vendor:publish --tag=laravel-notifications```. esto crea en la ruta ```resources/views/vendor/notifications``` el archivo ```email.blade.php``` para que editemos. fuente <https://laravel.com/docs/10.x/notifications>
    2. editar el archivo AuthServiceProvider.php y en el metodo ```boot``` agregar lo siguiente 
    ```
    VerifyEmail::toMailUsing(function($notifiable, $verificationUrl) {
            return (new MailMessage)
            ->subject(Lang::get('Verify Email Address'))
            ->greeting(Lang::get("Hello") .' '. $notifiable->name)
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->action('Confirmar Cuenta', $verificationUrl)
            ->line('Si no creaste esta cuenta, puedes ignorar este mensaje');
        });
    ```

```si queremos ver todos los endpoint que tiene nuestra app, podemos ejecutar en una terminal wsl, lo siguiente sail php artisan route:list, alli veremos las nuevas rutas que tenemos gracias al plugin que instalamos```
   
   ademas de Breeze existen otros paquetes para autenticar pero estan hechos para situaciones diferentes, por ejemplo SOLO PARA SABERLO DE CULTURA GENERAL, PARA ESTE EJEMPLO NO LO VAMOS A INSTALAR, EXISTE:
   * ```Fortify```: utiliza los endpoind de Breeze, pero sirve para ser utilizado en cualquier frontend, que utilice laravel de backend, por ejemplo flutter, angular, react etc
     1. Autenticacion de dos factores, inicia sesion con login y password y envia codigo via sms para que el usuario confirme. por ejemplo ```twilio``` permite enviar mensajes sms gratis cierta cantidad
     2. no incluye interfaz de usuario, uno la tiene que construir, Fortify crea la rutas y los metodos para que un frontend las consuma 
   * ```Sanctum:``` utiliza los endpoind de Breeze, pero añade nuevos endpoint para almacenar y generar token que permitan acceso al backend esta diseñado para ser utilizado como metodo de autenticacion para aplicaciones hechas con angular, vue, react entre otras. se recomienda para SPA
   * ```Jetstream:``` Es una interfaz completa ideal para ser utilizada como el inicio de una aplicacion de laravel.
     1. Diseñada con Tailwind CSS y puede ser utilizada junto a ```Inertia o Liverwire```
     2. utiliza Sanctum para autenticar usuarios e incluye las funciones de Registro, login 2FA, sesiones, tokens, verificacion de email, y password reset

1. traducir los erroes de validacion a español, para ello debemos visitar desde el navegador web la siguiente url <https://github.com/MarcoGomesr/laravel-validation-en-espanol>, alli debemos descargar como un ```.zip```, y pegar en la raiz de nuestro proyecto solamente la carpeta ```lang``` del archivo que descargamos, quedando algo como ```lang/es``` y en ella deberá estar los archivos .php que vienen en lo que descagamos. nota, si deseamos crear validaciones personalizadas a otros campos, entonces debemos en la carpeta ```lang```, no dentro de ```es```, agregar un json, llamado, ejemplo ```es.json``` para español, ```en.json```  para ingles.
   
   1. IMPORTANTE: para que tome el idioma seleccionado, debemos abrir el archivo ```config/app.php```  y alli buscamos donde diga locale y le cambiamos el valor de ```'locale' => 'en'``` a ```'locale' => 'es'```
