# 🛍️ Mystic Waves - Tienda Online

![Mystic Waves](public/assets/img/logo-tienda.png)

## 📋 Descripción

**Mystic Waves** es una tienda online de joyería desarrollada como proyecto educativo. La aplicación permite a los usuarios navegar por un catálogo de productos, registrarse, iniciar sesión y gestionar su perfil de usuario. Este proyecto ha sido desarrollado como parte del segundo año del ciclo formativo de **Desarrollo de Aplicaciones Web**.

## ✨ Características

- 🏠 **Página de inicio** con carrusel de imágenes destacadas
- 📦 **Catálogo de productos** organizado por categorías
- 🔐 **Sistema de autenticación** (registro, login, logout)
- 👤 **Panel de usuario** personalizado
- 🔍 **Búsqueda de productos** (interfaz preparada)
- 🛒 **Carrito de compras** (interfaz preparada)
- 📱 **Diseño responsive** compatible con dispositivos móviles
- 🔒 **Recuperación de contraseña**
- 🎨 **Interfaz moderna** y atractiva

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
- **Owl Carousel** - Carrusel de productos (preparado)
- **Easing.js** - Animaciones suaves

## 📁 Estructura del Proyecto

```
tienda_online/
│
├── actions/                      # Acciones del servidor
│   ├── login_action.php         # Procesa el inicio de sesión
│   ├── logout_action.php        # Cierra la sesión del usuario
│   ├── registro_action.php      # Procesa el registro de usuarios
│   └── recuperar_pass_action.php # Recuperación de contraseña
│
├── config/                       # Configuración
│   └── conexion.php             # Configuración de base de datos
│
├── helpers/                      # Funciones auxiliares
│   ├── auth.php                 # Funciones de autenticación
│   └── validaciones.php         # Validaciones de datos
│
├── public/                       # Recursos públicos
│   ├── assets/
│   │   ├── css/                 # Hojas de estilo
│   │   ├── img/                 # Imágenes del proyecto
│   │   └── lib/                 # Bibliotecas externas
│   └── partials/
│       └── footer.php           # Componente de footer
│
├── views/                        # Vistas de la aplicación
│   ├── auth/
│   │   ├── login.php            # Vista de inicio de sesión
│   │   ├── registro.php         # Vista de registro
│   │   └── recuperar_pass.php   # Vista de recuperación
│   ├── user/
│   │   └── panel.php            # Panel de usuario
│   └── error.php                # Página de error
│
└── index.php                     # Página principal
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
- **productos** - Catálogo de productos (en desarrollo)
- **categorias** - Categorías de productos (en desarrollo)
- **pedidos** - Órdenes de compra (en desarrollo)

### Script SQL de Ejemplo

```sql
CREATE DATABASE IF NOT EXISTS tienda_online CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE tienda_online;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('user', 'admin') DEFAULT 'user',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## 📖 Uso

### Navegación Básica

1. **Página de inicio**: Accede a `index.php` para ver el catálogo
2. **Registro**: Crea una cuenta nueva desde `views/auth/registro.php`
3. **Login**: Inicia sesión en `views/auth/login.php`
4. **Panel de usuario**: Una vez autenticado, accede a tu panel desde el menú de usuario

### Funcionalidades Disponibles

- ✅ Registro de nuevos usuarios
- ✅ Inicio y cierre de sesión
- ✅ Panel de usuario personalizado
- ✅ Recuperación de contraseña
- ✅ Navegación por categorías
- ⏳ Búsqueda de productos (en desarrollo)
- ⏳ Carrito de compras (en desarrollo)
- ⏳ Proceso de checkout (en desarrollo)

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

Este proyecto incluye medidas básicas de seguridad:

- Contraseñas hasheadas con algoritmos seguros
- Protección contra SQL Injection mediante PDO y consultas preparadas
- Validación de datos de entrada
- Gestión de sesiones segura
- Protección de rutas mediante autenticación

⚠️ **Nota**: Este es un proyecto educativo. Para uso en producción, se recomienda implementar medidas de seguridad adicionales.

## 🚧 Estado del Proyecto

El proyecto está actualmente en **desarrollo activo**. Algunas funcionalidades están en fase de implementación.

### Próximas Características

- [ ] Sistema completo de gestión de productos (CRUD)
- [ ] Carrito de compras funcional
- [ ] Proceso de pago
- [ ] Panel de administración
- [ ] Gestión de pedidos
- [ ] Sistema de búsqueda avanzada
- [ ] Wishlist / Lista de deseos
- [ ] Valoraciones y reseñas de productos

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
