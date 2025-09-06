## 🚀 Guía de Instalación del Sistema de Gestión de Finanzas Personales

### 📋 Requisitos del Sistema
Antes de comenzar, asegúrate de que tu entorno de desarrollo cumpla con los siguientes requisitos:
* **Servidor Web Local:** Por ejemplo, XAMPP, WAMP o MAMP.
* **PHP:** Versión 8.2 o superior.
* **MySQL:** Versión 5.2.1 o superior.
* **Composer:** Un gestor de dependencias para PHP.
* **Navegador Web:** Una versión moderna de Chrome, Firefox, Safari o Edge.

---

### ⚙️ Pasos de Instalación
Sigue estos pasos para configurar el proyecto en tu servidor local.

1.  **Descargar y Mover Archivos:**
    * Descarga el archivo comprimido del proyecto.
    * Descomprímelo y copia la carpeta principal.
    * Si usas **XAMPP**, pega la carpeta dentro del directorio `htdocs`.

2.  **Instalar Dependencias de PHP:**
    * Abre tu **terminal** o **línea de comandos**.
    * Navega hasta la carpeta del proyecto que acabas de pegar en `htdocs`. Por ejemplo, `cd C:\xampp\htdocs\nombre-de-tu-proyecto`.
    * Ejecuta el siguiente comando para instalar todas las librerías necesarias:
        ```bash
        composer install
        ```
    * Este proceso descargará automáticamente las dependencias definidas en el archivo `composer.json`.

3.  **Configuración del Servidor Web (Importante para el patrón MVC):**
    * Debido a que el proyecto sigue el patrón de diseño **MVC (Modelo-Vista-Controlador)**, es crucial que la carpeta pública sea el punto de entrada a tu aplicación. Esto garantiza que las URLs sean seguras y que la lógica del sistema funcione correctamente.
    * Para acceder a la aplicación desde el navegador, la URL debe apuntar a la carpeta `public`.
    * **Ejemplo de URL:**
        ```url
        http://localhost/calidad-financiera/public/
        ```
    * Para ir directamente a la página de inicio de sesión, usa:
        ```url
        http://localhost/nombre-de-tu-proyecto/public/login
        ```