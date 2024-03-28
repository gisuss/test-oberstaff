# Prueba Técnica para Oberstaff

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

![Logo](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Logo](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Logo](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Logo](https://img.shields.io/badge/GitHub-330F63?style=for-the-badge&logo=github&logoColor=white)

## Acerca de la prueba técnica

Esta prueba técnica para la empresa Oberstaff consiste en crear una serie de servicios los cuales se enumeran a continuación:

1. Registro de **Customers**.
2. Consulta de **Customers** por dni o email.
3. Eliminación lógica de **Customers** del sistema.

El presente proyecto esta construido en laravel version 10.10 y estoy usando los patrones de diseño **Responsable** y **Repository**.

## Instalación

1- Clonar este repositorio e ir a la carpeta raiz
```bash
    git clone https://github.com/gisuss/test-oberstaff.git
```

2- instalar/actualizar dependencias de composer
```bash
  composer install
  composer update
```

3- Generar archivo .env
```bash
  cp .env-example .env
```

4- Generar api key de laravel
```bash
  php artisan key:generate
```

5- Crear y configurar la DB en el .env
```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=test_oberstaff
    DB_USERNAME=root
    DB_PASSWORD=
```

6- Aplicar migraciones y seeders
```bash
  php artisan migrate --seed
```

7- Poner en marcha el servidor local

En caso de usar Valet:

```bash
  valet link
```

Caso contrario

```bash
  php artisan serve
```

## Variables de entorno

Para ejecutar correctamente este proyecto, debe validar que la variable de entorno **APP_ENV** esté inicialmente en **local** para que se generen todos los logs como se especifica en la prueba técnica y posteriormente setear a **production** para que no se almacenen los logs de salida.

`APP_ENV`=local

## Usuario de Prueba generado con el seeder

```bash
  'email': admin@example.com
  'password':  password
```

## [API - Auth] login

Servicio de inicio de sesión de usuarios. Mediante el middleware **loginVerify** se valida la presencia de **email** y **password** en la solicitud.

```http
  POST /api/auth/login
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `string` | **Required**. |
| `password` | `string` | **Required**. |

## [API - Auth] logout

Servicio para el cierre de sesión de usuarios.

```http
  POST /api/auth/logout
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `api_key`      | `string` | **Required**. Tu API token |

## [API - Auth] register

Servicio de registro de customers. Este endpoint es libre y no requiere autenticación para su uso. Mediante el middleware **registerVerify** se valida la presencia y consistencia de los campos mínimos requeridos para la ejecución exitosa de este servicio.

```http
  POST /api/auth/register
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | **Required**. |
| `last_name` | `string` | **Required**. |
| `dni` | `string` | **Required**. |
| `email` | `string` | **Required**. |
| `password` | `string` | **Required**. |
| `address` | `string` | **Optional**. |
| `id_com` | `integer` | **Required**. |
| `id_reg` | `integer` | **Required**. |

## [API - Customers] index

Servicio para el listado de customers activos. Este endpoint requiere autenticación para su uso. Mediante el middleware **sanctumAuth** se valida la presencia y vigencia del token de autenticación. Este servicio retorna una lista paginada con todos los customers.

```http
  GET /api/customers/index
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `api_key`      | `string` | **Required**. Tu API token |

## [API - Customers] show

Servicio de búsqueda de customers. Este endpoint requiere autenticación para su uso. Mediante el middleware **sanctumAuth** se valida la presencia y vigencia del token de autenticación. La variable **search** pasada por parámetro de la ruta representa un **dni** o un **email** de un customer.

```http
  GET /api/customers/show/{search}
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `api_key`      | `string` | **Required**. Tu API token |
| `search` | `string` | **Required**. |

## [API - Customers] delete

Servicio para la eliminación lógica de customers. Este endpoint requiere autenticación para su uso. Mediante el middleware **sanctumAuth** se valida la presencia y vigencia del token de autenticación. La variable **search** pasada por parámetro de la ruta representa un **dni** o un **email** de un customer.

```http
  DELETE /api/customers/delete/{search}
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `api_key`      | `string` | **Required**. Tu API token |
| `search` | `string` | **Required**. |

## [API - Logs] index

Servicio para la consulta de Logs. Este endpoint requiere autenticación para su uso. Mediante el middleware **sanctumAuth** se valida la presencia y vigencia del token de autenticación. El servicio retorna una lista de los logs que se han generado tras cada acción en la API.

```http
  GET /api/logs/index
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `api_key`      | `string` | **Required**. Tu API token |

## Autor

- [@gisuss](https://github.com/gisuss)