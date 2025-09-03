
<nav id="menu">
    <h2>Menu</h2>
    <ul>
        <li>
        @if (Auth::check()) 
            <form method="POST" action="{{route('logout')}}">
            @csrf
            <button type="submit" class="logout">se déconnecter</button>
            <h1 class="welcome">Bonjour, {{ auth()->user()->firstname }} ! Tu es connecté.</h1>
            </form>
            <li><a href="{{ route('tickets.index') }}">Mes tickets</a></li>
        </li>
        @else
        <li><a href="/register">s'inscrire</a></li>
        <li><a href="/login">Login</a></li>
        @endif
        <li><a href="/shows">Nos spectacles</a></li>
        <li><a href="/artists">Nos talents</a></li>
        <li><a href="/types">Nos métiers</a></li>
        <li><a href="/locations">Nos salles</a></li>

    </ul>
</nav>