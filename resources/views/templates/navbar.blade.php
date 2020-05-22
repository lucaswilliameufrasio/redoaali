
<nav class="navbar header-top fixed-top navbar-expand-lg  navbar-light bg-light navmod">
    <span class="leftmenutrigger"> <img src="{{ asset('img/logo.png') }}" width="60" height="40" alt="">  </span>
    <a class="navbar-brand" href="{{ url('/') }}">ReDoaAli</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-md-auto d-md-flex">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Início</a>
            </li>
            @if (Route::has('login'))
            @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('usuario.perfil') }}">Perfil</a>
            </li>
            @can('doador-only', auth()->user())
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/cadastrarprodutos') }}">Cadastrar Produto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/produtos') }}">Meus Produtos</a>
            </li>
            @endcan
            @can('beneficiario-only', auth()->user())
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/produtosdisponiveis')}}">Produtos Disponíveis</a>        
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/carrinho')}}">
                    <i class="fas fa-shopping-cart"></i> 
                    Carrinho 
                    @if (Cart::instance('default')->count() > 0)
                    <span>( {{ Cart::instance('default')->count() }} )</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('reserva.lista') }}">Minhas Reservas</a>        
            </li>
            @endcan
            <li class="nav-item">
                @can('admin-only', Auth::user())
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/private') }}">Privado</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.listausuarios') }}">Usuários</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.listaprodutos') }}">Produtos</a>
            </li>
            @endcan
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('/cadastrar-opcao'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('/cadastrar-opcao') }}">{{ __('Cadastrar-se') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/sobre') }}">Sobre</a>
            </li>
            @endif
            @endauth
            @if (Route::has('login'))
            @auth
            <li class="nav-item"> <a class ="nav-link" href="{{ route('logout') }}"
                                     onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                    {{ __('Sair') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form></li>
            @endauth
            @endif
        </ul>
    </div>
</nav>
@endif