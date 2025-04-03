<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet Réservations :: @yield('title')</title>
</head>
<body>
    <aside>
    @section('sidebar')
        This is the master sidebar.
    @show
    </aside>
    <main>
        @yield('content')
    </main>
</body>
</html>
