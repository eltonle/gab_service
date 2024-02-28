<div class="vertical-menu">

    <div data-simplebar class="h-100">



        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="index.html" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                        <span>Dashboard</span>
                    </a>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Fournisseurs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('suppliers.index')}}">Listes Des Fournisseurs</a></li>
                        <li><a href="{{route('suppliers.create')}}">Ajouter Un Fournisseur</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('customers.index')}}">Listes Des Clients</a></li>
                        <li><a href="{{route('customers.create')}}">Ajouter Un Client</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Unités</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('units.index')}}">Listes Des Unités</a></li>
                        <li><a href="{{route('units.create')}}">Ajouter Une Unité</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Categories</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('categories.index')}}">Listes Des Categories</a></li>
                        <li><a href="{{route('categories.create')}}">Ajouter Une Categorie</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Produits</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('products.index')}}">Listes Des Produits</a></li>
                        <li><a href="{{route('products.create')}}">Ajouter Un Produit</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Les Entreés & Achats</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('purchase.index')}}">Listes Des Entreés</a></li>
                        <li><a href="{{route('purchase.pending')}}">Les Entreés en attentes</a></li>
                        <li><a href="{{route('purchase.create')}}">Ajouter Une Entreé</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
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
                        <i class="ri-mail-send-line"></i>
                        <span>Gestion de Stock</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('stock.report')}}">Rapport de Stock</a></li>
                        <li><a href="{{route('stock.report.supplier_prod')}}">Fournisseur&Produict</a></li>

                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Rapport</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('customers.credit')}}">Clients Credit</a></li>

                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('customers.paid')}}">Clients Paiement</a></li>

                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('customers.wise.report')}}">Bilan Clients</a></li>

                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('invoice.daily.report')}}">Rapport Quotidien</a></li>

                    </ul>

                    <ul class="sub-menu" aria-expanded="false">

                        <li><a href="{{route('purchase.report')}}">Rapport d'Achat Quotidien</a></li>
                    </ul>
                </li>





            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>