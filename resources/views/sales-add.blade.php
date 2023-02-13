@extends('layout')

@section('content')
<section id="sales-add">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Sales</h4>
                </div>
                <div class="card-body ">
                    @include('messages')
                    <form class="w-100"  method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="" class="col-md-12">
                                        Product Name
                                    </label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="product" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="" class="col-md-12">
                                        User Name
                                    </label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="user" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="" class="col-md-12">
                                        Sale Price
                                    </label>
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" name="sale_price" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="" class="col-md-12">
                                        Cost
                                    </label>
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" name="cost" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-primary">Save</button>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection