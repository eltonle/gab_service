@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Services</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Service</a></li>
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
                    Creer Service
                    <a href="{{route('service.index')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-list"></i> Listes des Services</a>
                </h3>

            </div>
            <div class="card-body">
                <!--
                <h4 class="card-title ">Creer Service </h4><br> -->


                <form id="myForm" method="post" action="{{ route('service.store') }}">
                    @csrf
                    <div class="add_item">

                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                <label for=""> Technicien</label>
                                <select name="technical_id" class="form-control {{ $errors->has('technical_id') ? 'is-invalid' : '' }}" id="">
                                    <option value="">Selectionner un Technicien</option>
                                    @foreach ($technicals as $tech)
                                    <option value="{{$tech->id}}">{{$tech->name}} ({{$tech->address}}-{{$tech->phone}})</option>
                                    @endforeach
                                </select>
                                <!-- <input name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" id="name"> -->
                                @error('technical_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <div class="form-group col-md-5">
                                <label for=""> Tache</label>
                                <select name="task_id[]" class="form-control {{ $errors->has('task_id') ? 'is-invalid' : '' }}" id="" required>
                                    <option value="">Selectionner une Tache</option>
                                    @foreach ($tasks as $task)
                                    <option value="{{$task->id}}">{{$task->name}} </option>
                                    @endforeach
                                </select>
                                @error('task_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-5">
                                <label for="">Montant </label>
                                <input name="amount[]" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" id="amount" required>
                                @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-1" style="padding-top: 30px;">
                                <span class="btn btn-outline-success waves-effect waves-success addeventmore"><i class="fa fa-plus-circle"></i></span>
                            </div>
                        </div>
                        <!-- end row -->

                    </div>
                    <button type="submit" class="btn  btn-outline-primary waves-effect waves-light">Enregistrer</button>
                </form>



            </div>
        </div>

        <div style="visibility: hidden;">
            <div class="whole_extra_item_add" id="whole_extra_item_add">
                <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
                    <div class="row">

                        <div class="form-group col-md-5">
                            <label for=""> Tache</label>
                            <select name="task_id[]" class="form-control {{ $errors->has('task_id') ? 'is-invalid' : '' }}" id="">
                                <option value="">Selectionner une Tache</option>
                                @foreach ($tasks as $task)
                                <option value="{{$task->id}}">{{$task->name}} </option>
                                @endforeach
                            </select>
                            @error('task_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-5">
                            <label for="">Montant </label>
                            <input name="amount[]" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" id="amount">
                            @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-2" style="padding-top: 30px; display: flex;">

                            <div>
                                <span class="btn btn-outline-success waves-effect waves-success addeventmore "><i class="fa fa-plus-circle"></i></span>
                            </div>
                            <div>
                                <span class="btn btn-outline-danger waves-effect waves-danger ml-1 removeeventmore"><i class="fa fa-minus-circle"></i></span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endsection

        @section('js')
        <script>
            $(document).ready(function() {
                var counter = 0;
                $(document).on('click', '.addeventmore', function() {
                    var whole_extra_item_add = $('#whole_extra_item_add').html();
                    $(this).closest('.add_item').append(whole_extra_item_add);
                    counter++;
                });
                $(document).on('click', '.removeeventmore', function() {

                    $(this).closest('.delete_whole_extra_item_add').remove();
                    counter -= 1;
                })
            })
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#myForm').validate({
                    rules: {
                        "technical_id": {
                            required: true,
                        }
                    },
                    messages: {

                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
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
