@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Produits</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Produit</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header ">

                <h3 class="card-title">
                    <a href="{{route('products.index')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-list"></i> Listes des Produits</a>
                </h3>
            </div>


            <div class="card-body">

                <div class="row">
                    <div class="row mb-2">


                        <div class="form-group col-md-2">
                            <label for="date" style="font-weight: bold; color: black;">Date </label>
                            <input type="date" name="data" id="date" class="form-control">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="supplier_id"> Reférence</label>
                            <input type="text" name="purchase_no" id="purchase_no" class="form-control ">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="supplier_name">Fournisseur</label>
                            <select name="supplier_name" id="supplier_id" class="form-control">
                                <option value="">Select fournisseur</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="category_id">Catégorie </label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select catégorie</option>

                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="product_id">Nom du Produit</label>
                        <select name="product_id" id="product_id" class="form-control">
                            <option value="">Select produit</option>

                        </select>
                    </div>

                    <div class="form-group col-md-2" style="padding-top: 30px;">
                        <a href="#" class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i> Ajouter</a>
                    </div>

                </div>
            </div>

            <!-- form start -->
            <div class="card-body">
                <form action="{{route('purchase.store')}}" method="post" id="myForm">
                    @csrf
                    <table class="table-sm table-bordered border-dark" width="100%">
                        <thead>
                            <tr>
                                <th>Catégorie</th>
                                <th>Nom du Produit</th>
                                <th width="7%">Quantité</th>
                                <th width="10%">Prix U.</th>
                                <th>Description</th>
                                <th width="10%">Prix Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="addRow" class="addRow" width="100%">

                        </tbody>
                        <tbody>
                            <tr>
                                <td colspan="5"></td>
                                <td>
                                    <input type="text" name="estimated_amount" value="0" id="estimated_amount" class="form-control form-control-sm text-right estimated_amount" readonly style="background-color: #D8FDBA;">
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <div class="form-group">
                        <!-- <button type="submit" class="btn btn-primary" id="storeButton">Purchase</button> -->
                        <button type="submit" class="btn  btn-outline-primary waves-effect " id="storeButton">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>




        @endsection

        @section('js')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="{{asset('assets/ortherjs/handlebars.min.js')}}"></script>

        <script id="document-template" type="text/x-handlebars-template">
            <tr class="delete_add_more_item" id="delete_add_more_item">
                <input type="hidden" name="date[]" value="@{{date}}">
                <input type="hidden" name="purchase_no[]" value="@{{purchase_no}}">
                <input type="hidden" name="supplier_id[]" value="@{{supplier_id}}">
                <td>
                    <input type="hidden" name="category_id[]" value="@{{category_id}}" id="">
                    @{{category_name}}
                </td>
                <td>
                    <input type="hidden" name="product_id[]" value="@{{product_id}}" id="">
                    @{{product_name}}
                </td>
                <td>
                    <input type="number" min="1" class="form-control form-control-sm text-right buying_qty" name="buying_qty[]" value="1" id="">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm text-right unit_price" name="unit_price[]" value="" >
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm " name="description[]"  >
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm text-right buying_price" name="buying_price[]" value="0"  readonly>
                </td>
                <td>
                    <i class="btn btn-danger btn-sm fa fa-window-close removeeventmore"></i>
                </td>
            </tr>
    </script>

        <script>
            $(document).ready(function() {
                $(document).on("click", ".addeventmore", function() {
                    var date = $('#date').val();
                    var purchase_no = $('#purchase_no').val();
                    var supplier_id = $('#supplier_id').val();
                    var supplier_name = $('#supplier_id').find('option:selected').text();
                    var category_id = $('#category_id').val();
                    var category_name = $('#category_id').find('option:selected').text();
                    var product_id = $('#product_id').val();
                    var product_name = $('#product_id').find('option:selected').text();
                    if (date == '') {
                        $.notify("date is required", {
                            globalPosition: 'top right',
                            className: "error"
                        });
                        return false;
                    }
                    if (purchase_no == '') {
                        $.notify("Purchase is required", {
                            globalPosition: 'top right',
                            className: "error"
                        });
                        return false;
                    }
                    if (supplier_id == '') {
                        $.notify("supplier is required", {
                            globalPosition: 'top right',
                            className: "error"
                        });
                        return false;
                    }
                    if (category_id == '') {
                        $.notify("category is required", {
                            globalPosition: 'top right',
                            className: "error"
                        });
                        return false;
                    }
                    if (product_id == '') {
                        $.notify("product is required", {
                            globalPosition: 'top right',
                            className: "error"
                        });
                        return false;
                    }
                    var source = $("#document-template").html();
                    var template = Handlebars.compile(source);
                    var data = {
                        date: date,
                        purchase_no: purchase_no,
                        supplier_id: supplier_id,
                        supplier_name: supplier_name,
                        category_id: category_id,
                        category_name: category_name,
                        product_id: product_id,
                        product_name: product_name
                    };
                    var html = template(data);
                    $("#addRow").append(html);
                });
                $(document).on("click", ".removeeventmore", function(event) {
                    $(this).closest('.delete_add_more_item').remove();
                    totalAmountPrice();
                });

                $(document).on('keyup click', '.unit_price,.buying_qty', function() {
                    var unit_price = $(this).closest('tr').find("input.unit_price").val();
                    var qty = $(this).closest('tr').find("input.buying_qty").val();
                    var total = unit_price * qty;
                    $(this).closest('tr').find("input.buying_price").val(total);
                    totalAmountPrice();
                });

                function totalAmountPrice() {
                    var sum = 0;
                    $('.buying_price').each(function() {
                        var value = $(this).val();
                        if (!isNaN(value) && value.length != 0) {
                            sum += parseFloat(value);
                        }
                    });

                    $('#estimated_amount').val(sum);
                }
            })
        </script>

        <script>
            $(function() {

                $(document).on("change", '#supplier_id', function() {
                    var supplier_id = $(this).val();
                    $.ajax({
                        url: "{{route('get-category')}}",
                        type: "GET",
                        data: {
                            supplier_id: supplier_id
                        },
                        success: function(data) {
                            var html = '<option value="">Select category</option>'
                            $.each(data, function(key, v) {
                                html += '<option value="' + v.category_id + '">' + v.category.name + '</option>';
                            })
                            $('#category_id').html(html);
                        }
                    })
                })
            });
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
        <script>
            $(document).ready(function() {
                $('#myForm').validate({
                    rules: {
                        name: {
                            required: true,
                        }
                    },
                    messages: {

                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.clasest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                })
            })
        </script>
        @endsection
