<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">JahitlnAja</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                {{-- <li class="nav-item"><a href="/login" class="nav-link">Dashboard</a></li> --}}
                 <li class="nav-item"><form action="{{ route('logout') }}" method="POST">@csrf <button class="btn btn-link nav-link">Logout</button></form></li>
                  
            </ul>
        </div>
    </div>
</nav>
