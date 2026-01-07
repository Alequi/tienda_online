# 🛍️ Mystic Waves - Tienda Online

![Mystic Waves](public/assets/img/logo-tienda.png)

## 📋 Descripción

**Mystic Waves** es una tienda online de joyería desarrollada como proyecto educativo. La aplicación permite a los usuarios navegar por un catálogo de productos, registrarse, iniciar sesión y gestionar su perfil de usuario. Este proyecto ha sido desarrollado como parte del segundo año del ciclo formativo de **Desarrollo de Aplicaciones Web**.

## ✨ Características

- 🏠 **Página de inicio** con carrusel de imágenes destacadas
- 📦 **Catálogo de productos** organizado por categorías
- 🔐 **Sistema de autenticación** (registro, login, logout)
- 👤 **Panel de usuario** personalizado con gestión de datos
- 👨‍💼 **Panel de administración** para gestión de productos
- 🔍 **Búsqueda de productos** por categorías
- 🛒 **Carrito de compras** funcional con gestión de cantidades
- 📱 **Diseño responsive** compatible con dispositivos móviles
- 🔒 **Recuperación de contraseña**
- 📧 **Página de contacto** con formulario
- 🎨 **Interfaz moderna** y atractiva
- 🔄 **Actualización dinámica** del carrito vía AJAX

## 🛠️ Tecnologías Utilizadas

### Backend
- **PHP 7.4+** - Lenguaje de programación del servidor
- **MySQL** - Sistema de gestión de base de datos
- **PDO** - Interfaz de acceso a base de datos

### Frontend
- **Bootstrap 5.3** - Framework CSS para diseño responsive
- **Vanilla JavaScript** - Funcionalidades del lado del cliente
- **Bootstrap Icons** - Iconografía
- **Google Fonts (Poppins)** - Tipografía personalizada

### Bibliotecas Adicionales
- **Owl Carousel** - Carrusel de productos
- **Easing.js** - Animaciones suaves
- **JavaScript AJAX** - Actualización dinámica del carrito

## 📁 Estructura del Proyecto

```
tienda_online/
│
├── actions/                      # Acciones del servidor
│   ├── login_action.php         # Procesa el inicio de sesión
│   ├── logout_action.php        # Cierra la sesión del usuario
│   ├── registro_action.php      # Procesa el registro de usuarios
│   ├── recuperar_pass_action.php # Recuperación de contraseña
│   ├── products_action.php      # Procesa la carga de productos
│   ├── product_detail_action.php # Detalle de productos
│   └── cart/                    # Gestión del carrito
│       ├── add.php              # Añadir al carrito
│       ├── update.php           # Actualizar cantidades
│       └── view.php             # Ver carrito
│
├── admin/                        # Panel de administración
│   └── adminPanel.php           # Panel de administrador
│
├── config/                       # Configuración
│   └── conexion.php             # Configuración de base de datos
│
├── helpers/                      # Funciones auxiliares
│   ├── auth.php                 # Funciones de autenticación
│   ├── cart_helper.php          # Funciones del carrito
│   └── validaciones.php         # Validaciones de datos
│
├── public/                       # Recursos públicos
│   ├── assets/
│   │   ├── css/                 # Hojas de estilo
│   │   ├── img/                 # Imágenes del proyecto
│   │   └── lib/
│   │       ├── scripts/         # JavaScript personalizado
│   │       │   ├── cart.js      # Gestión del carrito
│   │       │   ├── form.js      # Validación de formularios
│   │       │   ├── panel.js     # Panel de usuario
│   │       │   └── quantity_selector.js # Selector de cantidad
│   │       └── ...              # Bibliotecas externas
│   └── partials/
│       ├── footer.php           # Componente de footer
│       ├── topbar.php           # Barra superior
│       ├── searchbar.php        # Barra de búsqueda
│       ├── cartbar.php          # Icono del carrito
│       └── producto_detalle.php # Detalle de producto
│
├── views/                        # Vistas de la aplicación
│   ├── auth/
│   │   ├── login.php            # Vista de inicio de sesión
│   │   ├── registro.php         # Vista de registro
│   │   └── recuperar_pass.php   # Vista de recuperación
│   ├── tienda/
│   │   ├── cart.php             # Carrito de compras
│   │   ├── producto.php         # Detalle de producto
│   │   ├── contacto.php         # Página de contacto
│   │   └── categorias/
│   │       └── categoria.php    # Vista de categoría
│   ├── user/
│   │   └── panel.php            # Panel de usuario
│   └── error.php                # Página de error
│
├── index.php                     # Página principal
└── localhost_3308(1).sql        # Script de base de datos
```

## 🚀 Instalación

### Requisitos Previos

- **XAMPP**, **WAMP**, **MAMP** o servidor local con:
  - PHP 7.4 o superior
  - MySQL 5.7 o superior
  - Apache

### Pasos de Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/Alequi/tienda_online.git
   cd tienda_online
   ```

2. **Configurar el servidor web**
   - Coloca el proyecto en la carpeta `htdocs` (XAMPP) o `www` (WAMP)
   - O configura un virtual host apuntando a la raíz del proyecto

3. **Crear la base de datos**
   - Abre phpMyAdmin o tu gestor de MySQL preferido
   - Crea una base de datos llamada `tienda_online`
   - Ejecuta el script SQL para crear las tablas necesarias (ver sección siguiente)

4. **Configurar la conexión a la base de datos**
   - Abre el archivo `config/conexion.php`
   - Verifica/ajusta los siguientes parámetros según tu configuración:
   ```php
   define("HOSTNAME", "localhost");
   define("DATABASE", "tienda_online");
   define("USERNAME", "root");
   define("PASSWORD", "");
   ```
   - Ajusta el puerto si es necesario (por defecto: 3308)

5. **Iniciar el servidor**
   - Inicia Apache y MySQL desde el panel de control de XAMPP/WAMP
   - Accede a `http://localhost/tienda_online` en tu navegador

## 💾 Base de Datos

### Estructura de la Base de Datos

La base de datos incluye las siguientes tablas principales:

- **usuarios** - Información de los usuarios registrados
  - Campos: dni (PK), nombre, apellidos, email, telefono, direccion, localidad, provincia, password, rol
- **productos** - Catálogo de productos de joyería
  - Campos: codigo (PK), nombre, descripcion, precio, stock, imagen, categoria
- **categorias** - Categorías de productos
  - Campos: id, nombre, descripcion
- **carrito** - Items del carrito de compras (sesión)
- **pedidos** - Órdenes de compra (en desarrollo)

### Script SQL de Ejemplo

El proyecto incluye el archivo `localhost_3308(1).sql` con la estructura completa de la base de datos. Para importarlo:

1. Abre phpMyAdmin
2. Crea una nueva base de datos llamada `tienda_online`
3. Selecciona la base de datos
4. Ve a la pestaña "Importar"
5. Selecciona el archivo `localhost_3308(1).sql`
6. Haz clic en "Continuar"

La base de datos incluirá:
- Tabla de usuarios con roles (user/admin)
- Tabla de productos con stock y precios
- Datos de ejemplo para pruebas

## 📖 Uso

### Navegación Básica

1. **Página de inicio**: Accede a `index.php` para ver el catálogo
2. **Registro**: Crea una cuenta nueva desde `views/auth/registro.php`
3. **Login**: Inicia sesión en `views/auth/login.php`
4. **Panel de usuario**: Una vez autenticado, accede a tu panel desde el menú de usuario

### Funcionalidades Disponibles

- ✅ Registro de nuevos usuarios con validación completa
- ✅ Inicio y cierre de sesión seguro
- ✅ Panel de usuario personalizado con gestión de datos
- ✅ Panel de administración (solo para usuarios admin)
  - ⏳ Añadir/eliminar productos
  - ⏳ Añadir/eliminar categorias
  - ⏳ Añadir/eliminar usuarios
  - ⏳ Informes de venta basicos
- ✅ Recuperación de contraseña
- ✅ Navegación por categorías (anillos, colgantes, pulseras, pendientes)
- ✅ Visualización de productos con detalles
- ✅ Carrito de compras funcional con:
  - Añadir/eliminar productos
  - Actualizar cantidades
  - Cálculo automático de totales
  - Actualización AJAX sin recargar página
- ✅ Página de contacto con formulario
- ✅ Control de stock en productos
- ⏳ Proceso de checkout y pago (en desarrollo)
- ⏳ Gestión de pedidos (en desarrollo)

## 🎨 Capturas de Pantalla

*Las capturas de pantalla se agregarán próximamente*

## 👨‍💻 Autor

**Alejandro Quivera**
- Estudiante de 2º año - Desarrollo de Aplicaciones Web
- GitHub: [@Alequi](https://github.com/Alequi)

## 📚 Contexto Educativo

Este proyecto ha sido desarrollado como parte del programa de estudios del **Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web**. El objetivo principal es aplicar los conocimientos adquiridos en:

- Desarrollo web con PHP
- Diseño de bases de datos relacionales
- Frontend responsive con Bootstrap
- Programación con JavaScript vanilla
- Arquitectura MVC básica
- Seguridad web y autenticación
- Buenas prácticas de programación

## 🔒 Seguridad

Este proyecto incluye medidas de seguridad:

- ✅ Contraseñas hasheadas con `password_hash()` de PHP
- ✅ Protección contra SQL Injection mediante PDO y consultas preparadas
- ✅ Validación de datos de entrada en cliente y servidor
- ✅ Gestión segura de sesiones PHP
- ✅ Protección de rutas mediante autenticación (helpers/auth.php)
- ✅ Sanitización de salida con `htmlspecialchars()`
- ✅ Control de roles (usuario/administrador)
- ✅ Validación de stock antes de añadir al carrito

⚠️ **Nota**: Este es un proyecto educativo. Para uso en producción, se recomienda implementar medidas de seguridad adicionales como HTTPS, CSRF tokens, rate limiting, etc.

## 🚧 Estado del Proyecto

El proyecto está actualmente en **desarrollo activo**. La mayoría de las funcionalidades principales están implementadas y funcionando.

### ✅ Funcionalidades Completadas

- [x] Sistema de autenticación completo (registro, login, logout)
- [x] Panel de usuario con gestión de datos personales
- [x] Panel de administración básico
- [x] Catálogo de productos por categorías
- [x] Vista de detalle de productos
- [x] Carrito de compras funcional con AJAX
- [x] Gestión de stock y cantidades
- [x] Página de contacto
- [x] Sistema de roles (usuario/admin)
- [x] Diseño responsive completo

### 🔄 Próximas Características

- [ ] Proceso de checkout y pago
- [ ] Gestión completa de pedidos
- [ ] Panel de administración avanzado (CRUD completo de productos)
- [ ] Sistema de búsqueda 
- [ ] Wishlist / Lista de deseos
- [ ] Historial de pedidos en panel de usuario
- [ ] Notificaciones por email

## 📄 Licencia

Este proyecto es de código abierto y está disponible para fines educativos.

## 🤝 Contribuciones

Las contribuciones, sugerencias y feedback son bienvenidos. Este es un proyecto de aprendizaje y cualquier consejo es apreciado.

## 📞 Contacto

Para cualquier consulta o sugerencia sobre el proyecto, puedes contactarme a través de GitHub.

---

**⭐ Si este proyecto te ha sido útil para aprender, considera darle una estrella en GitHub ⭐**

---

*Desarrollado con 💙 como proyecto educativo de DAW 2º año*
