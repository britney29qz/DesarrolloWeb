Descripción breve del sistema:

Mi página web está diseñada bajo el marco de una tienda online. Está basada en mi emprendimiento real de crochet. Y yo ya he venido pensando sobre crear mi propia
marca personal para mis tejidos; por lo que el logo, la gama de colores y el diseño inicial ha sido hecho pensando justamente en lo que quiero transmitir. 
Así que este proyecto no solo forma parte de una actividad, sino que también está enmarcado en una visión de sacarlo a producción algún día.

Ahora bien, el sistema, en sí, está desarrollado para mostrar una página inicial (index.php) donde se encuentra un vistazo general de lo que quiero dar a conocer de 
mi tienda. Y cumpliendo con la tarea, en un aside lateral se presenta el recuadro de inicio de sesión. Pero en el caso de que el usuario no tenga una cuenta 
todavía, debe registrarse primero en la opción que se le muestra debajo para acceder al formulario (registra_usuario.php). Esto para poder acceder a la zona privada 
de usuarios (perfil.php); por lo que si le da click al item de perfil en el header, sin haberse registrado previamente, le va a llevar al registro igualmente.

Al mostrarse el formulario de registro, el usuario nuevo deberá ingresar sus datos personales: nombres, apellidos, cédula, correo, contraseña y confirmar contraseña.
Y al darle al botón de registrar, lo regresará al inicio para que se logee. Una vez que ingrese su correo y contraseña, podrá acceder automáticamente a la zona de 
perfil. Aquí podrá editar sus datos personales: nombres, apellidos y correo. También podrá cambiar su contraseña (cambiar_password.php); y también podrá cerrar 
sesión (logout.php), lo que lo redireccionará al inicio.
De esta manera, se han implementado las funcionalidades que podrá realizar el usuario dentro del sistema.

Ahora, el sistema internamente realizará la conexión a la base de datos (conexion.php) para hacer la validación de datos al ingresar (guarda_usuario.php), y al 
actualizar (actualizar.php | actualiza_password.php). Y, desde luego, el sistema cuenta con las especificaciones dadas en la tarea para poder crear un sistema que 
sea seguro (uso de password_hash y password_verify), cuente con el manejo de sesiones ($_SESSION); y además, sea responsivo y accesible en diferentes navegadores.

Pero claro, seguramente haya mucho por mejorar, así que siempre estamos prestos para poder desarrollar sistemas seguros, escalables y eficientes.





Requisitos (PHP, MySQL, etc.):

Para poder realizar el sistema, se hizo uso de la herramienta XAMPP como servidor web local; junto a aquella viene la base de datos phpMyAdmin, que es con la que 
estamos trabajando en el presente proyecto. Asimismo, como lenguaje de programación se usó, principalmente, PHP; y un poquito de JavaScript para pequeñas 
configuraciones. De igual forma, la página está diseñada con HTML5 y el framework de Tailwind CSS.





Pasos para instalar y probar localmente:
Requisitos previos:
- Tener instalado XAMPP
- Tener acceso a un navegador web (Google Chrome, Firefox, Opera, etc)
Instalación y ejecución:
- Descargar o copiar el proyecto dentro del directorio "htdocs" de XAMPP
- Iniciar los servicios de Apache y MySQL
- Crear la base de datos en phpMyAdmin de nombre "filora_acdb1"
- Importar el archivo SQL en la pestaña de Importar; se selecciona el archivo .sql que se descargó al principio y se da a Continuar
- Ejecutar el proyecto en el navegador (http://localhost/DWpracticab1/index.php)
Pruebas:
Credenciales de prueba por si no desea registrarse directamente más de una vez
Correo: jeremyricardo@gmail.com
Contraseña: jeremy_123
Correo: norma1970brito@gmail.com
Contraseña: norma_1970
Funcionalidades:
- Registro de usuarios
- Inicio de sesión
- Cierre de sesión
- Edición de perfil
- Cambio de contraseña
- Validaciones de formularios
- Alertas para errores o éxitos
- Diseño responsive


Muchas gracias por el espacio :)




