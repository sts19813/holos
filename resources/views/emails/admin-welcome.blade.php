<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bienvenido a Holos</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">
    <div style="max-width:600px; margin:auto; background:#ffffff; padding:30px; border-radius:6px;">


        {{-- LOGO --}}
        <div style="text-align:center; margin-bottom:20px;">
            <img src="{{ asset('assets/img/holos-logo.png') }}" alt="Holos" style="max-width:180px;">
        </div>

        
        <h2 style="color:#1e1e2d;">Bienvenido a Holos</h2>

        <p>Hola <strong>{{ $user->name }}</strong>,</p>

        <p>
            Se ha creado una cuenta de administrador para ti en el sistema <b>Holos</b>.
        </p>

        <p><strong>Credenciales de acceso:</strong></p>

        <ul>
            <li><b>Correo:</b> {{ $user->email }}</li>
            <li><b>Contraseña:</b> {{ $password }}</li>
        </ul>

        <p>
            Puedes acceder desde el siguiente enlace:
        </p>

        <p>
            <a href="{{ url('/login') }}"
                style="display:inline-block;padding:10px 16px;background:#0d6efd;color:#ffffff;text-decoration:none;border-radius:4px;">
                Acceder al sistema
            </a>
        </p>

        <p style="margin-top:20px;">
            Por seguridad, te recomendamos cambiar tu contraseña después de iniciar sesión.
        </p>

        <hr>

        <p style="font-size:12px;color:#6c757d;">
            © {{ date('Y') }} Holos. Todos los derechos reservados.
        </p>
    </div>
</body>

</html>