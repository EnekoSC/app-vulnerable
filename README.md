# Portal de distribuidores — Distribuciones Santa S.L.

> ⚠️ **APLICACIÓN DELIBERADAMENTE VULNERABLE — SOLO USO EN LABORATORIO AISLADO. NO EXPONER A REDES PÚBLICAS NI A PRODUCCIÓN.**

Aplicación web Laravel 11 construida como **banco de pruebas de seguridad**. Reproduce,
de forma realista, las vulnerabilidades más habituales del OWASP Top 10 sobre un portal
corporativo ficticio (catálogo, pedidos, facturas, perfil y zona de administración).

Los fallos son **intencionados**: su propósito es servir de entorno de práctica para
análisis de vulnerabilidades y pruebas de intrusión. No los "arregles": son el objeto del
ejercicio.

---

## Estructura del repositorio

La infraestructura está separada de la aplicación:

```
.
├── infra/                  # todo lo de Docker / red / servicios
│   ├── docker-compose.yml
│   ├── .env.example        # credenciales de la BD (copiar a .env)
│   ├── php/
│   │   ├── Dockerfile      # imagen php-fpm 8.2
│   │   └── entrypoint.sh   # install + migrate + seed al arrancar
│   └── nginx/
│       └── default.conf    # vhost (sirve public/ y ejecuta cualquier .php)
├── app/                    # aplicación Laravel 11
│   ├── app/                # modelos, controladores, middleware
│   ├── config/ routes/ resources/ database/
│   ├── composer.json
│   └── .env.example        # config de la app (APP_DEBUG=true, etc.)
└── README.md
```

---

## Requisitos

- Docker y Docker Compose.
- Acceso a Internet **solo durante el primer arranque** (para que `composer install`
  descargue dependencias). Después puedes aislar la red por completo.

---

## Despliegue

Todos los comandos se lanzan desde `infra/`.

```bash
cd infra
cp .env.example .env          # credenciales de la BD (débiles a propósito)
docker compose up -d --build
```

En el primer arranque el contenedor `app`:

1. copia `app/.env.example` a `app/.env` si no existe,
2. ejecuta `composer install`,
3. genera `APP_KEY`,
4. espera a MySQL y lanza `php artisan migrate:fresh --seed`.

Cuando termine, el portal está en:

```
http://127.0.0.1:8080
```

> El puerto se publica **solo en `127.0.0.1`**. Ver más abajo cómo exponerlo a la
> máquina atacante en un laboratorio host-only.

Para ver el progreso del arranque:

```bash
docker compose logs -f app
```

> Nota: `migrate:fresh --seed` se ejecuta en **cada** arranque del contenedor `app`,
> así que reiniciarlo **resetea la base de datos** (usuarios, comentarios, subidas).
> Es lo deseable para un laboratorio repetible.

---

## Credenciales de prueba (seeders)

| Rol     | Correo                | Contraseña |
|---------|-----------------------|------------|
| admin   | `admin@santasl.local` | `admin`    |
| cliente | `noel@santasl.local`  | `123456`   |
| cliente | `mari@santasl.local`  | `123456`   |
| cliente | `elf@santasl.local`   | `123456`   |

Las credenciales por defecto del admin son, en sí mismas, una vulnerabilidad.

---

## Laboratorio host-only con Kali

Para practicar desde una máquina atacante (Kali) en la misma red aislada:

1. Crea una red **host-only** (o interna, sin salida a Internet) en tu hipervisor
   y conecta la máquina objetivo (la que corre Docker) y la Kali a esa red.
2. Averigua la IP host-only de la máquina objetivo, por ejemplo `192.168.56.10`:
   ```bash
   ip a
   ```
3. En `infra/docker-compose.yml`, cambia el mapeo de puertos del servicio `nginx`
   para que escuche en esa IP (o en `0.0.0.0` si la red ya está aislada):
   ```yaml
   ports:
     - "192.168.56.10:8080:80"
   ```
4. Reinicia: `docker compose up -d`.
5. Desde Kali, el objetivo estará en `http://192.168.56.10:8080`.

Ejemplo de direccionamiento del laboratorio:

| Máquina   | Rol       | IP host-only    |
|-----------|-----------|-----------------|
| Objetivo  | servidor  | `192.168.56.10` |
| Kali      | atacante  | `192.168.56.20` |

> **No** conectes esta red a Internet ni publiques el puerto en una interfaz
> accesible desde fuera del laboratorio.

---

## Comprobar las dependencias vulnerables

```bash
docker compose exec app composer audit
```

Debe reportar `dompdf/dompdf` en la versión fijada (vulnerable).

---

## Parar y limpiar

```bash
docker compose down          # para los contenedores
docker compose down -v       # además borra el volumen de MySQL
```

---

## Aviso legal

Material con fines **exclusivamente educativos**, para uso en un entorno **controlado y
autorizado**. El autor no se responsabiliza de un uso distinto.
