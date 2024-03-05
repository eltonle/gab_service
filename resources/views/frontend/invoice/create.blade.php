@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Facturation</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Facture</a></li>
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
                    Creer une Facture
                    <a href="{{route('invoice.index')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-list"></i> Listes des Factures</a>
                </h3>
            </div>


            <div class="card-body">

                <div class="row">
                    <div class="row mb-2">
                        <div class="form-group col-md-1">
                            <label for="invoice_no">Fact_No</label>
                            <input type="text" name="invoice_no" value="{{$invoice_no}}" id="invoice_no" class="form-control " readonly style="background-color: #D8FDBA;">

                        </div>

                        <div class="form-group col-md-2">
                            <label for="date" style="font-weight: bold; color: black;">Date </label>
                            <input type="date" name="date" value="{{$date}}" id="date" class="form-control">

                        </div>

                        <div class="form-group col-md-3">
                            <label for="category_id">Categorie</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Select categorie</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="product_id">Nom du Produit</label>
                            <select name="product_id" id="product_id" class="form-control">
                                <option value="">Select product</option>

                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="date" style="font-weight: bold; color: black;">Stocks </label>
                            <input type="text" name="current_stock_qty" id="current_stock_qty" class="form-control" readonly style="background-color: #D8FDBA;">

                        </div>
                        <div class="form-group  col-md-2" style="padding-top: 30px;">
                            <a href="#" class="btn float-right btn-success addeventmore"><i class="fa fa-plus-circle"></i> Ajouter</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- form start -->
            <div class="card-body">
                <form action="{{route('invoice.store')}}" method="post" id="myForm">
                    @csrf
                    <table class="table-sm table-bordered border-dark" width="100%">
                        <thead>
                            <tr>
                                <th>Catégorie</th>
                                <th>Nom du Produit</th>
                                <th width="7%">Quantité</th>
                                <th width="10%">Prix U.</th>
                                <th width="17%">Prix Total</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="addRow" class="addRow" width="100%">

                        </tbody>
                        <tbody>
                            <tr>
                                <td class="text-right" colspan="4">Remise</td>
                                <td>
                                    <input type="text" name="discount_amount" id="discount_amount" class="form-control discount_amount text-right" placeholder="Une remise">
                                </td>
                            </tr>
                            <tr>

                                <td class="text-right" colspan="4">Grand total</td>
                                <td>
                                    <input type="text" name="estimated_amount" value="0" id="estimated_amount" class="form-control form-control-sm text-right estimated_amount" readonly style="background-color: #D8FDBA;">
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <textarea name="description" id="description" class="w-100" placeholder="Write description here..."></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Status de Payement</label>
                            <select name="paid_status" id="paid_status" class="form-control">
                                <option value="">selectionner un status</option>
                                <option value="full_paid">Payé</option>
                                <option value="full_due">En Attente</option>
                                <option value="partial_paid">Partiellement Payé</option>
                            </select>

                            <input type="text" name="paid_amount" class="form-control mt-2 paid_amount" placeholder="entrer une somme" style="display: none;">
                        </div>
                        <div class="form-group col-md-9">
                            <label for="">Nom du Client</label>
                            <select name="customer_id" id="customer_id" class="form-control">
                                <option value="">selectionner un client</option>
                                <option value="0">Nouveau Client</option>
                                @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}} ( {{$customer->address}} - {{$customer->phone}}) </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row new_customer" style="display: none;">
                        <div class="form-group col-md-4">
                            <input type="text" name="name" id="name" class="form-control" placeholder="nom">
                        </div>
                        <div class="form-group col-md-4">
                            <input type="email" name="email" id="email" class="form-control" placeholder="email">
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" name="addresse" id="addresse" class="form-control" placeholder="addresse">
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="phone">
                        </div>
                    </div>
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
                <input type="hidden" name="date" value="@{{date}}">
                <input type="hidden" name="invoice_no" value="@{{invoice_no}}">
                <td>
                    <input type="hidden" name="category_id[]" value="@{{category_id}}" id="">
                    @{{category_name}}
                </td>
                <td>
                    <input type="hidden" name="product_id[]" value="@{{product_id}}" id="">
                    @{{product_name}}
                </td>
                <td>
                    <input type="number" min="1" class="form-control form-control-sm text-right selling_qty" name="selling_qty[]" value="1" id="">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm text-right unit_price" name="unit_price[]" value="" >
                </td>

                <td>
                    <input type="text" class="form-control form-control-sm text-right selling_price" name="selling_price[]" value="0"  readonly>
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
                    var invoice_no = $('#invoice_no').val();
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
                        invoice_no: invoice_no,
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

                $(document).on('keyup click', '.unit_price,.selling_qty', function() {
                    var unit_price = $(this).closest('tr').find("input.unit_price").val();
                    var qty = $(this).closest('tr').find("input.selling_qty").val();
                    var total = unit_price * qty;
                    $(this).closest('tr').find("input.selling_price").val(total);

                    $('#discount_amount').trigger('keyup');
                });

                $(document).on('keyup', '#discount_amount', function() {
                    totalAmountPrice();
                })

                function totalAmountPrice() {
                    var sum = 0;
                    $('.selling_price').each(function() {
                        var value = $(this).val();
                        if (!isNaN(value) && value.length != 0) {
                            sum += parseFloat(value);
                        }
                    });

                    var discount_amount = parseFloat($('#discount_amount').val());
                    if (!isNaN(discount_amount) && discount_amount.length != 0) {
                        sum -= parseFloat(discount_amount);
                    }

                    $('#estimated_amount').val(sum);
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

        <script>
            $(function() {
                $(document).on('change', '#product_id', function() {
                    var product_id = $(this).val();
                    $.ajax({
                        url: "{{route('check-product-stock')}}",
                        type: "GET",
                        data: {
                            product_id: product_id
                        },
                        success: function(data) {
                            $('#current_stock_qty').val(data);
                        }
                    })
                })
            })
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


        <script>
            $(document).on('change', '#paid_status', function() {

                var paid_status = $(this).val();
                if (paid_status == 'partial_paid') {
                    $('.paid_amount').show();
                } else {
                    $('.paid_amount').hide();
                }
            })

            $(document).on('change', '#customer_id', function() {

                var customert_id = $(this).val();
                if (customert_id == '0') {
                    $('.new_customer').show();
                } else {
                    $('.new_customer').hide();
                }
            })
        </script>
        @endsection
