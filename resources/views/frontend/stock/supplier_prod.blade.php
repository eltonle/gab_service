@extends('layouts.app')
@section('content')


<!-- start page title -->
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Fournisseurs/Produits</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Listes </a></li>
                    <li class="breadcrumb-item active">Produit</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row ">
    <div class="col-12">
        <div class="card">

            <div class="card-header ">

                <h3 class="card-title">Selectionner critere
                    <!-- <a href="{{route('stock.report.pdf')}}" target="_blank" class="float-right btn btn-success btn-sm"><i class="fa fa-download"></i> Telecharger fichier</a> -->
                </h3>

            </div>

            <div class="card-body">
                <div class="row mb-10">
                    <div class="col-md-12 text-center">
                        <strong>Rapport Fournisseur</strong>
                        <input type="radio" name="supplier_product_wise" value="supplier_wise" class="search_value"> &nbsp;&nbsp;
                        <strong>Rapport Product</strong>
                        <input type="radio" name="supplier_product_wise" value="product_wise" class="search_value">
                    </div>
                </div>

                <div class="show_supplier" style="display: none;">
                    <form method="GET" action="{{route('stock.report.supplier.pdf')}}" target="_blank">
                        <div class="form-row">
                            <div class="col-sm-8">
                                <label for="">Nom du fournisseur</label>
                                <select name="supplier_id" class="form-control ">
                                    <option value="">nom du client</option>
                                    @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}({{ $supplier->supplier_address }}-{{ $supplier->supplier_phone }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4" style="padding-top: 30px;">
                                <button class="btn btn-primary btn-sm">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="show_product" style="display: none;">
                    <form method="GET" action="{{route('stock.report.product.pdf')}}" target="_blank">
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label for="category_id">Categorie</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Select categorie</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="product_id">Nom du Produit</label>
                                <select name="product_id" id="product_id" class="form-control">
                                    <option value="">Select product</option>

                                </select>
                            </div>
                            <div class="col-sm-2" style="padding-top: 30px;">
                                <button class="btn btn-primary ">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection

@section('js')
<script>
    $(document).on('change', '.search_value', function() {
        var search_value = $(this).val();
        if (search_value == 'supplier_wise') {
            $('.show_supplier').show();
        } else {
            $('.show_supplier').hide();
        }
        if (search_value == 'product_wise') {
            $('.show_product').show();
        } else {
            $('.show_product').hide();
        }
    })
</script>

<script>
    $(function() {

        $(document).on("change", '#category_id', function() {
            var category_id = $(this).val();
            $.ajax({
                url: "{{route('get-product')}}",
                type: "GET",
                data: {
                    category_id: category_id
                },
                success: function(data) {
                    var html = '<option value="">Select Product</option>'
                    $.each(data, function(key, v) {
                        html += '<option value="' + v.id + '">' + v.name + '</option>';
                    });
                    $('#product_id').html(html);
                }
            })
        })
    });
</script>
@endsection