# EquilibraAPP - Sistema de Gestión para Consultorio Psicológico

## 📋 Descripción del Proyecto

EquilibraAPP es un aplicativo web completo diseñado para la gestión integral de un consultorio psicológico. El sistema permite a las secretarias y psicólogos administrar eficientemente las operaciones diarias del consultorio.

### 🎯 Funcionalidades Principales

#### Para Secretarias:
- ✅ **Gestión de Citas**: Programar, modificar, reasignar, cancelar y confirmar citas
- 📅 **Calendario Interactivo**: Vista completa de las citas programadas
- 👥 **Gestión de Pacientes**: Registro y administración de información básica de pacientes
- 📊 **Dashboard**: Vista general del estado del consultorio

#### Para Psicólogos:
- 📋 **Historias Clínicas**: Creación y gestión completa de historias clínicas
- 📝 **Repositorio de Pruebas**: Acceso a pruebas psicológicas en formato PDF
- 👤 **Gestión de Pacientes**: Administración detallada de pacientes asignados
- 📈 **Seguimiento**: Control del progreso de los tratamientos

## 🛠️ Tecnologías Utilizadas

### Backend:
- **Laravel 12.31.1** - Framework PHP robusto y moderno
- **PHP 8.2+** - Lenguaje de programación
- **SQLite** - Base de datos (configurable para MySQL/PostgreSQL)

### Frontend:
- **Vue.js 3** - Framework JavaScript progresivo para SPA
- **Vue Router 4** - Enrutamiento del lado del cliente
- **Tailwind CSS** - Framework de utilidades CSS
- **Axios** - Cliente HTTP para las peticiones a la API

### Herramientas de Desarrollo:
- **Vite** - Herramienta de construcción rápida
- **Composer** - Gestor de dependencias PHP
- **NPM** - Gestor de paquetes JavaScript

## 🚀 Instalación y Configuración

### Prerrequisitos:
- PHP 8.2 o superior
- Composer
- Node.js y NPM
- Laragon (recomendado para Windows)

# EquilibraAPP

Sistema de Gestión Médica y Psicológica desarrollado con Laravel 11, Vue.js 3 y MySQL.

## 📋 Características

- ✅ **Sistema de Autenticación Completo**
  - Login con validación de credenciales
  - Interfaz moderna con logo personalizable
  - Manejo de sesiones con tokens
  - Validaciones de campo en tiempo real

- ✅ **Base de Datos Completa**
  - 20 tablas implementadas según el esquema médico
  - Gestión de usuarios, roles, pacientes, citas
  - Historias clínicas, tratamientos, medicamentos
  - Sistema de facturación integrado

- ✅ **Interfaz de Usuario Moderna**
  - Diseño responsivo con Tailwind CSS
  - Componentes Vue.js 3 reutilizables
  - Dashboard interactivo post-login
  - Animaciones y transiciones suaves

## 🚀 Instalación

### Requisitos previos
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL/MariaDB

### Pasos de instalación

1. **Clonar y configurar el proyecto**
```bash
git clone <repository-url>
cd equilibra-app
composer install
npm install
```

2. **Configurar el entorno**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Configurar la base de datos**
Edita el archivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=equilibra_app
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

4. **Ejecutar migraciones y seeds**
```bash
php artisan migrate
php artisan db:seed
```

5. **Compilar assets y ejecutar**
```bash
# En terminal 1:
npm run dev

# En terminal 2:
php artisan serve
```

## 🎯 Uso

### Acceder a la aplicación
- **URL Principal**: `http://localhost:8000`
- **Aplicación Vue**: `http://localhost:8000/app`

### Credenciales de prueba
- **Email**: admin@equilibra.com
- **Contraseña**: admin123

### API Endpoints
- `POST /api/auth/login` - Iniciar sesión
- `POST /api/auth/logout` - Cerrar sesión

## 🏗️ Arquitectura

### Backend (Laravel 11)
```
app/
├── Http/Controllers/
│   └── AuthController.php     # Autenticación
├── Models/
│   ├── Usuario.php           # Modelo de usuarios
│   ├── Rol.php              # Roles del sistema
│   ├── Paciente.php         # Gestión de pacientes
│   └── ...                  # Otros modelos
└── ...

database/
├── migrations/              # 20 migraciones implementadas
└── seeders/                # Datos de prueba
```

### Frontend (Vue.js 3)
```
resources/
├── js/
│   ├── app.js              # Aplicación principal Vue
│   └── components/
│       └── Login.vue       # Componente de login
├── views/
│   ├── app.blade.php       # Vista de la SPA
│   └── welcome.blade.php   # Página de inicio
└── css/
    └── app.css            # Estilos con Tailwind
```

### Base de Datos
20 tablas principales:
- **Usuarios y Roles**: `usuarios`, `roles`, `usuario_rol`
- **Pacientes**: `pacientes`, `contactos_emergencia`
- **Citas**: `citas`, `estados_cita`, `tipos_cita`
- **Médicos**: `especialidades`, `medicos`
- **Historias Clínicas**: `historias_clinicas`, `diagnosticos`
- **Tratamientos**: `tratamientos`, `medicamentos`, `recetas`
- **Facturación**: `facturas`, `pagos`, `metodos_pago`
- **Sistema**: `configuraciones`, `logs_sistema`

## 🛠️ Desarrollo

### Estructura de componentes Vue
```javascript
// app.js - Aplicación principal
{
  components: { Login },
  data: { isAuthenticated, currentUser },
  methods: { onLoginSuccess, logout }
}

// Login.vue - Componente de autenticación
{
  data: { form, errors, loading, message },
  methods: { handleLogin, showDefaultLogo }
}
```

### API de autenticación
```php
// AuthController.php
public function login(Request $request) {
    // Validación de credenciales con hash
    // Consulta con JOIN a tablas usuarios y roles
    // Retorna JSON con usuario y token
}
```

## 🎨 Personalización

### Logo de la aplicación
Coloca tu logo en `/public/logo.png` para reemplazar el ícono por defecto.

### Colores y estilos
Los colores principales se pueden cambiar en:
- Tailwind CSS: `tailwind.config.js`
- Componentes Vue: clases CSS en templates

### Rutas y navegación
- Rutas web: `routes/web.php`
- Rutas API: `routes/api.php` (prefijo `/api`)

## 📊 Estado del Proyecto

### ✅ Completado
- [x] Base de datos completa (20 tablas)
- [x] Sistema de autenticación funcional
- [x] Interfaz de login moderna
- [x] Dashboard básico post-login
- [x] API REST para autenticación
- [x] Manejo de sesiones y tokens

### 🔄 En desarrollo
- [ ] Gestión completa de pacientes
- [ ] Sistema de citas avanzado
- [ ] Historias clínicas digitales
- [ ] Módulo de facturación
- [ ] Reportes y estadísticas

### 🎯 Próximas funcionalidades
- [ ] Notificaciones en tiempo real
- [ ] Integración con calendarios
- [ ] Sistema de archivos adjuntos
- [ ] API REST completa
- [ ] Tests automatizados

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Añadir nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

## 📝 Tecnologías

- **Backend**: Laravel 11, PHP 8.2
- **Frontend**: Vue.js 3, Composition API
- **Estilos**: Tailwind CSS 3
- **Base de datos**: MySQL 8.0
- **Build**: Vite 5
- **Autenticación**: Laravel Sanctum (planeado)

## 📄 Licencia

Este proyecto está bajo la licencia MIT. Ver el archivo `LICENSE` para más detalles.

---

**EquilibraAPP** - Sistema de Gestión Médica © 2025

## 🌐 Acceso a la Aplicación

- **URL Principal**: http://127.0.0.1:8000
- **Assets de Desarrollo**: http://localhost:5174

### 👤 Usuarios de Prueba:

**Secretaria:**
- Email: `secretaria@equilibra.com`
- Contraseña: `password`

**Psicólogo:**
- Email: `psicologo@equilibra.com`
- Contraseña: `password`

## 📁 Estructura del Proyecto

```
EquilibraAPP/
├── app/                    # Lógica de la aplicación Laravel
├── resources/
│   ├── js/
│   │   ├── components/     # Componentes Vue.js
│   │   │   ├── App.vue     # Componente principal
│   │   │   ├── Login.vue   # Sistema de autenticación
│   │   │   ├── Dashboard.vue # Panel principal
│   │   │   ├── CitasManager.vue # Gestión de citas
│   │   │   ├── HistoriasClinicas.vue # Historias clínicas
│   │   │   └── PruebasPsicologicas.vue # Repositorio de pruebas
│   │   ├── app.js          # Configuración principal de Vue
│   │   └── bootstrap.js    # Configuración de Axios
│   ├── css/                # Estilos CSS
│   └── views/              # Vistas Blade
├── routes/
│   └── web.php             # Rutas de la aplicación
├── database/               # Migraciones y seeders
└── public/                 # Assets públicos
```

## 🔧 Características Técnicas

### Arquitectura:
- **SPA (Single Page Application)** con Vue.js
- **API REST** con Laravel
- **Autenticación basada en tokens**
- **Enrutamiento del lado del cliente**

### Seguridad:
- Protección CSRF
- Validación de formularios
- Control de acceso basado en roles
- Sanitización de datos

### Responsive Design:
- Diseño adaptable para dispositivos móviles
- Interfaz intuitiva y moderna
- Componentes reutilizables

## 📊 Funcionalidades Detalladas

### Sistema de Citas:
- Calendario visual interactivo
- Filtros por fecha, psicólogo y estado
- Estados: Pendiente, Confirmada, Cancelada, Completada
- Notificaciones y recordatorios

### Historias Clínicas:
- Registro completo de pacientes
- Seguimiento de sesiones
- Documentación de tratamientos
- Búsqueda avanzada

### Repositorio de Pruebas:
- Categorización por tipo de prueba
- Filtros por edad objetivo
- Visualización de PDFs
- Sistema de descarga

## 🚀 Próximas Características

- [ ] Sistema de notificaciones en tiempo real
- [ ] Reportes y estadísticas avanzadas
- [ ] Integración con calendarios externos
- [ ] API móvil
- [ ] Sistema de backup automático
- [ ] Integración con sistemas de pago

## 📞 Soporte y Contacto

Para soporte técnico o consultas sobre el proyecto, contacta al equipo de desarrollo.

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE.md](LICENSE.md) para más detalles.

---

**EquilibraAPP** - Equilibrando la tecnología con el cuidado de la salud mental 🧠💚

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
