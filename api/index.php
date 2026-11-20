<?php
// Router único para Vercel (runtime vercel-php). vercel.json manda TODO acá.
//   /laravel/...   -> módulo Laravel (TP 10 Parte B)
//   /algo.php      -> el archivo PHP correspondiente del sitio
//   /              -> index.php
$raiz = dirname(__DIR__);

// Vercel inyecta las variables como entorno real; se copian a $_ENV/$_SERVER para que
// también las lean Laravel (Dotenv) y cualquier código que use $_ENV.
foreach (getenv() as $k => $v) {
    $_ENV[$k] = $_ENV[$k] ?? $v;
    $_SERVER[$k] = $_SERVER[$k] ?? $v;
}

$ruta = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');

function no_encontrado(): never
{
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    exit('404 · Página no encontrada.');
}

// ---------------------------------------------------------------- Laravel
if ($ruta === '/laravel' || str_starts_with($ruta, '/laravel/')) {
    $base = $raiz . '/laravel-medsalud';
    $sub  = substr($ruta, strlen('/laravel')) ?: '/';
    $qs   = $_SERVER['QUERY_STRING'] ?? '';

    // Variables que Laravel necesita en un entorno de solo lectura (excepto /tmp)
    $tmp = '/tmp/laravel';
    foreach (['storage/framework/cache', 'storage/framework/sessions', 'storage/framework/views', 'storage/logs', 'bootstrap/cache'] as $d) {
        @mkdir("$tmp/$d", 0775, true);
    }
    $defaults = [
        'APP_ENV'                => 'production',
        'APP_DEBUG'              => 'false',
        'DB_CONNECTION'          => 'pgsql',
        'DB_SSLMODE'             => 'require',
        'SESSION_DRIVER'         => 'cookie',
        'CACHE_STORE'            => 'array',
        'QUEUE_CONNECTION'       => 'sync',
        'LOG_CHANNEL'            => 'stderr',
        'VIEW_COMPILED_PATH'     => "$tmp/storage/framework/views",
        'APP_SERVICES_CACHE'     => "$tmp/bootstrap/cache/services.php",
        'APP_PACKAGES_CACHE'     => "$tmp/bootstrap/cache/packages.php",
        'COMPOSER_VENDOR_DIR'    => $raiz . '/vendor',
    ];
    $dburl = getenv('DATABASE_URL_UNPOOLED') ?: getenv('DATABASE_URL') ?: getenv('POSTGRES_URL') ?: '';
    if ($dburl !== '') {
        $defaults['DB_URL'] = preg_replace('/\?.*$/', '', $dburl); // sin parámetros extra (channel_binding, etc.)
    }
    foreach ($defaults as $k => $v) {
        if (getenv($k) === false) {
            putenv("$k=$v");
            $_ENV[$k] = $_SERVER[$k] = $v;
        }
    }

    // Laravel debe ver la URI sin el prefijo /laravel
    $_SERVER['REQUEST_URI']     = $sub . ($qs !== '' ? '?' . $qs : '');
    $_SERVER['SCRIPT_NAME']     = '/index.php';
    $_SERVER['PHP_SELF']        = '/index.php';
    $_SERVER['SCRIPT_FILENAME'] = $base . '/public/index.php';

    define('LARAVEL_START', microtime(true));
    require $raiz . '/vendor/autoload.php';
    $app = require_once $base . '/bootstrap/app.php';
    $app->useStoragePath("$tmp/storage");
    $app->handleRequest(Illuminate\Http\Request::capture());
    exit;
}

// ---------------------------------------------------------------- Sitio PHP nativo
if ($ruta === '/' || $ruta === '') {
    $ruta = '/index.php';
}
$ruta = '/' . ltrim($ruta, '/');

// Nunca se ejecutan ni se muestran carpetas internas ni archivos que empiezan con "_" o "."
$bloqueadas = ['config', 'includes', 'app', 'docker', 'vendor', 'laravel-medsalud', 'postgres',
               'tp6', 'tp7', 'tp8', 'tp9', 'tp10', 'node_modules'];
$partes = array_values(array_filter(explode('/', $ruta), 'strlen'));
foreach ($partes as $p) {
    if ($p === '..' || $p[0] === '.' || $p[0] === '_' || in_array($p, $bloqueadas, true)) {
        no_encontrado();
    }
}
if (!str_ends_with($ruta, '.php')) {
    no_encontrado();
}

$archivo = realpath($raiz . $ruta);
if ($archivo === false || !str_starts_with($archivo, $raiz . DIRECTORY_SEPARATOR) || !is_file($archivo)) {
    no_encontrado();
}

// Que el script se comporte como si lo hubieran pedido directamente
$_SERVER['SCRIPT_NAME']     = $ruta;
$_SERVER['PHP_SELF']        = $ruta;
$_SERVER['SCRIPT_FILENAME'] = $archivo;
chdir(dirname($archivo));
require $archivo;
