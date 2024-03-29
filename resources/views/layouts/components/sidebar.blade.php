<div class="vertical-menu">
    @php
    $id = Auth::user()->id;
    $adminData = App\Models\User::find($id);
    @endphp
    <div data-simplebar class="h-100">
        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="" style="display: flex;justify-content: space-around;align-items: center;">
                <div class="">
                    <img src="{{ (!empty($adminData->profile_image))? url('upload/admin_images/'.$adminData->profile_image):url('upload/no_image.jpg')}}" alt="" class="avatar-md rounded-circle border-3">
                </div>
                <div class="mt-3">
                    <h4 class="font-size-16 mb-1">{{Auth::user()->name}}</h4>
                    <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i> En Ligne</span>
                </div>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{route('home')}}" class="waves-effect">
                        <i class="ri-home-8-fill"></i>
                        <span>Accueil</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('dashboard')}}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Tableau de Bord</span>
                    </a>
                </li>

                @if (auth()->user()->isAdmin())
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="  fas fa-user-friends"></i>
                        <span>Utilisateurs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('users.index')}}">Listes Des Utilisateurs</a></li>
                        <li><a href="{{route('users.create')}}">Ajouter Un Utilisateur</a></li>
                    </ul>
                </li>
                @endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-ship-fill"></i>
                        <span>Fournisseurs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('suppliers.index')}}">Listes Des Fournisseurs</a></li>
                        <li><a href="{{route('suppliers.create')}}">Ajouter Un Fournisseur</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class=" ri-team-fill"></i>
                        <span>Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('customers.index')}}">Listes Des Clients</a></li>
                        <li><a href="{{route('customers.create')}}">Ajouter Un Client</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi-size-s"></i>
                        <span>Unités</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('units.index')}}">Listes Des Unités</a></li>
                        <li><a href="{{route('units.create')}}">Ajouter Une Unité</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class=" fas fa-coins"></i>
                        <span>Catégories</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('categories.index')}}">Listes Des Categories</a></li>
                        <li><a href="{{route('categories.create')}}">Ajouter Une Categorie</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-poop"></i>
                        <span>Produits</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('products.index')}}">Listes Des Produits</a></li>
                        <li><a href="{{route('products.create')}}">Ajouter Un Produit</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class=" fas fa-brush"></i>
                        <span>Les Entrées & Achats</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('purchase.index')}}">Listes Des Entreés</a></li>
                        <!-- <li><a href="{{route('purchase.pending')}}">Les Entreés en attentes</a></li> -->
                        <li><a href="{{route('purchase.create')}}">Ajouter Une Entreé</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        </i><i class="ri-coins-fill"></i>
                        <span>Facturation</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('invoice.index')}}">Liste Factures</a></li>
                        <li><a href="{{route('invoice.pending')}}"> Factures en Attentes</a></li>
                        <li><a href="{{route('invoice.create')}}">Ajouter Une Facture</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-chess-rook"></i>
                        <span>Techniciens</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('technical.index')}}">Liste Techniciens</a></li>
                        <li><a href="{{route('technical.create')}}">Creer Un Technicien</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-cloud-meatball"></i>
                        <span>Taches</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('task.index')}}">Liste des Taches</a></li>
                        <li><a href="{{route('task.create')}}">Ajouter Une Tache</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        </i><i class="ri-coins-fill"></i>
                        <span>Services</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('service.index')}}">Liste Services</a></li>
                        <li><a href="{{route('service.pending')}}"> Services en Attentes</a></li>
                        <li><a href="{{route('service.create')}}">Ajouter Un Service</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-cubes"></i>
                        <span>Gestion de Stock</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('stock.report')}}">Rapport de Stock</a></li>
                        <li><a href="{{route('stock.report.supplier_prod')}}">Fournisseur&Produict</a></li>

                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-clone"></i>
                        <span>Rapport</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('customers.credit')}}">Clients Credit</a></li>

                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('customers.paid')}}">Clients Paiement</a></li>

                    </ul>
                    @if (auth()->user()->isAdmin())
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('customers.wise.report')}}">Bilan Clients</a></li>

                    </ul>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('invoice.daily.report')}}">Rapport Quotidien</a></li>

                    </ul>

                    <ul class="sub-menu" aria-expanded="false">

                        <li><a href="{{route('purchase.report')}}">Rapport d'Achat Quotidien</a></li>
                    </ul>
                    @endif
                </li>





            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>