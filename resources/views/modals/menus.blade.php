@push('estilo-de-menus')
    <link rel="stylesheet" href="{{asset('css/menus.css')}}">
@endpush

@section('nav-lateral')
    <!-- Sidebar/menu (lateral) -->
    <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
    
        <div class="w3-container">
            <a href="#" onclick="w3_close()" class="w3-hide-large w3-right w3-jumbo w3-padding w3-hover-grey" title="close menu">
            <i class="fa fa-remove"></i>
            </a>
            {{-- <img src="/w3images/avatar_g2.jpg" style="width:45%;" class="w3-round"><br><br> --}}
            <h4><b>NFGUARDIAN</b></h4>
            <p class="w3-text-grey">Template by <a href="https://www.w3schools.com/">W3.CSS</a></p>
        </div>

        <div class="w3-bar-block">
            {{-- <a href="{{ route('dashboard') }}" onclick="w3_close()" class="w3-bar-item w3-button w3-padding w3-text-teal"><i class="fa fa-th-large fa-fw w3-margin-right"></i>Dashboard</a> --}}
            <a href="{{route('nota-fiscal.index')}}" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-address-card-o w3-margin-right"></i>Nota Fiscal</a>
            <a href="{{ route('configuracoes.index') }}" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog w3-margin-right"></i>Configurações</a>
            <a href="{{ route('logout') }}" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-power-off w3-margin-right"></i>Sair</a>
        </div>

        {{-- <div class="w3-panel w3-large">
            <i class="fa fa-facebook-official w3-hover-opacity"></i>
            <i class="fa fa-instagram w3-hover-opacity"></i>
            <i class="fa fa-snapchat w3-hover-opacity"></i>
            <i class="fa fa-pinterest-p w3-hover-opacity"></i>
            <i class="fa fa-twitter w3-hover-opacity"></i>
            <i class="fa fa-linkedin w3-hover-opacity"></i>
        </div> --}}

    </nav>
@endsection

@section("menu-topo")
<?php $request_uri  = $_SERVER["REQUEST_URI"]; ?>

    <!-- Header -->
    <header id="portfolio">
        {{-- <a href="#"><img src="/w3images/avatar_g2.jpg" style="width:65px;" class="w3-circle w3-right w3-margin w3-hide-large w3-hover-opacity"></a> --}}
        <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
        <div class="w3-container">
            <h1><b></b></h1>
            
            <div class="w3-section w3-bottombar w3-padding-16">
            
            <span class="w3-margin-right">Gerenciamento de:</span>
<?php
            if ($request_uri == "/estoque" || $request_uri == "/estoque/produto") {
?>
            <button onclick="window.location.href = '{{route('estoque')}}'" class="w3-button w3-black">Estoque</button>

            <button onclick="window.location.href = '{{route('estoque.produto')}}'" class="w3-button w3-white"><i class="fa fa-diamond w3-margin-right"></i>Produto</button>

            <button class="w3-button w3-white w3-hide-small"><i class="fa fa-photo w3-margin-right"></i>Photos</button>

            <button class="w3-button w3-white w3-hide-small"><i class="fa fa-map-pin w3-margin-right"></i>Art</button>
<?php
            }
?>
<?php
            if ($request_uri == "/nota-fiscal" || $request_uri == "/nota-fiscal/controle-de-nfs" || $request_uri == "/nota-fiscal/controle-de-imposto") {
?>
            <button onclick="window.location.href = '{{route('nota-fiscal.index')}}'" class="w3-button <?php if ($request_uri == "/nota-fiscal") { echo 'w3-black'; }else { echo 'w3-white'; } ?>">Notas Fiscais</button>

            <button onclick="window.location.href = '{{route('controle-de-nfs.index')}}'" class="w3-button <?php if ($request_uri == "/nota-fiscal/controle-de-nfs") { echo 'w3-black'; }else { echo 'w3-white'; } ?>"><i class="fa fa-diamond w3-margin-right"></i>Controle de NF</button>

            <button onclick="window.location.href = '{{route('controle-de-imposto.index')}}'" class="w3-button <?php if ($request_uri == "/nota-fiscal/controle-de-imposto") { echo 'w3-black'; }else { echo 'w3-white'; } ?>"><i class="fa fa-diamond w3-margin-right"></i>Controle de Imposto</button>

<?php
            }

            if ($request_uri == "/nota-fiscal/controle-de-nfs") {
?>            
            {{-- ícones dos CRUD aqui somente mexe nele de acordo com cada página ou seja, com a troca, oculta uns, não mostra nenhum e etc...  --}}
            <div class="icones-do-crud">
                
                <span class="material-symbols-outlined btn-top-add" title="Adicionar">
                    <button type="button" id="botao-menu-adicionar"> {{-- OS ATRIBUTOS data-toggle="modal" data-target="#exampleModal"  FORAM TIRADOS DESTE BOTÃO E SUAS FUNÇÕES ESTÃO NO JS --}}
                    add_circle
                    </button>
                </span>
                <span class="material-symbols-outlined" title="Atualizar">
                    refresh
                </span>
            </div>
<?php
            }
?>
            </div>
        </div>
    </header>
@endsection

@section('rodape')
    <!-- Footer -->
    <footer class="w3-container w3-padding-32 w3-dark-grey">
        <div class="w3-row-padding">
        <div class="w3-third">
            <h3>FOOTER</h3>
            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
            <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
        </div>

        <div class="w3-third">
            <h3>BLOG POSTS</h3>
            <ul class="w3-ul w3-hoverable">
            <li class="w3-padding-16">
                <img src="/w3images/workshop.jpg" class="w3-left w3-margin-right" style="width:50px">
                <span class="w3-large">Lorem</span><br>
                <span>Sed mattis nunc</span>
            </li>
            <li class="w3-padding-16">
                <img src="/w3images/gondol.jpg" class="w3-left w3-margin-right" style="width:50px">
                <span class="w3-large">Ipsum</span><br>
                <span>Praes tinci sed</span>
            </li> 
            </ul>
        </div>

        <div class="w3-third">
            <h3>POPULAR TAGS</h3>
            <p>
            <span class="w3-tag w3-black w3-margin-bottom">Travel</span> <span class="w3-tag w3-grey w3-small w3-margin-bottom">New York</span> <span class="w3-tag w3-grey w3-small w3-margin-bottom">London</span>
            <span class="w3-tag w3-grey w3-small w3-margin-bottom">IKEA</span> <span class="w3-tag w3-grey w3-small w3-margin-bottom">NORWAY</span> <span class="w3-tag w3-grey w3-small w3-margin-bottom">DIY</span>
            <span class="w3-tag w3-grey w3-small w3-margin-bottom">Ideas</span> <span class="w3-tag w3-grey w3-small w3-margin-bottom">Baby</span> <span class="w3-tag w3-grey w3-small w3-margin-bottom">Family</span>
            <span class="w3-tag w3-grey w3-small w3-margin-bottom">News</span> <span class="w3-tag w3-grey w3-small w3-margin-bottom">Clothing</span> <span class="w3-tag w3-grey w3-small w3-margin-bottom">Shopping</span>
            <span class="w3-tag w3-grey w3-small w3-margin-bottom">Sports</span> <span class="w3-tag w3-grey w3-small w3-margin-bottom">Games</span>
            </p>
        </div>

        </div>
    </footer>

    <div class="w3-black w3-center w3-padding-24">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></div>
@endsection