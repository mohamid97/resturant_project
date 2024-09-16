@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('sidebar.edit_product')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('main.home')</a></li>
                        <li class="breadcrumb-item active">@lang('sidebar.edit_product')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">@lang('sidebar.products')</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.products.update' , ['id'=> $product->id]) }}"  enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">
                        <div class="border  p-3">

                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="name">@lang('main.name') ({{ $lang->name }}) </label>
                                <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="@lang('plachoder.enter_name')" value="{{ isset($product->translate($lang->code)->name) ? $product->translate($lang->code)->name :''}}">
                                @error('name.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach

                        </div>

                        <br>


                        <div class="border  p-3">

                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="slug">@lang('main.slug') ({{ $lang->name }}) </label>
                                    <input type="text" name="slug[{{$lang->code}}]" class="form-control" id="slug" placeholder="@lang('plachoder.enter_slug')" value="{{ isset($product->translate($lang->code)->slug) ? $product->translate($lang->code)->slug :'' }}">
                                    @error('slug.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('slug.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
    
                            </div>
                            <br>





                        <div class="form-group">
                            <label for="price"> @lang('main.price')  </label>
                            <input type="text" name="price" class="form-control" id="price" placeholder="@lang('plachoder.enter_price')" value="{{ $product->price }}">
                            @error('price')
                            <div class="text-danger">{{ $errors->first('price') }}</div>
                            @enderror
                        </div>

                        
                        <div class="form-group">
                            <label for="discount"> @lang('main.price')  </label>
                            <input type="text" name="discount" class="form-control" id="price" placeholder="@lang('plachoder.discount')" value="{{ $product->discount }}">
                            @error('discount')
                            <div class="text-danger">{{ $errors->first('discount') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="old_price"> @lang('main.price')  </label>
                            <input type="text" name="old_price" class="form-control" id="old_price" placeholder="@lang('plachoder.old_price')" value="{{ $product->old_price }}">
                            @error('old_price')
                            <div class="text-danger">{{ $errors->first('old_price') }}</div>
                            @enderror
                        </div>

                        

                        <div class="border  p-3">
                            @foreach($langs as $index => $lang)


                                <div class="form-group">
                                    <label for="image">@lang('main.des') ({{$lang->name}})</label>
                                    <textarea name="des[{{$lang->code}}]" class="ckeditor">

                                        @if (isset($product->translate($lang->code)->des))

                                          {!! $product->translate($lang->code)->des !!}
                                            
                                        @endif
                                    </textarea>

                                    @error('des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="border  p-3">

                            @foreach($langs as $index => $lang)

                                <div class="form-group">
                                    <label for="meta_title">@lang('main.meta_title') ({{$lang->name}})</label>
                                    <textarea name="meta_title[{{$lang->code}}]" class="ckeditor">
                                       @if (isset($product->translate($lang->code)->meta_title))
                                         
                                         {!! $product->translate($lang->code)->meta_title !!}
                                           
                                       @endif
                                    </textarea>

                                    @error('meta_title.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('meta_title.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach

                        </div>
                        <br>
                        <div class="border  p-3">

                        @foreach($langs as $index => $lang)
                            <div class="form-group">
                                <label for="meta_des">@lang('main.meta_des') ({{$lang->name}})</label>
                                <textarea name="meta_des[{{$lang->code}}]" class="ckeditor">
                                     @if (isset($product->translate($lang->code)->meta_des))

                                     {!! $product->translate($lang->code)->meta_des !!}
                                         
                                     @endif
                                </textarea>

                                @error('meta_des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('meta_des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach

                        </div>
                        <br>
                        
                        <div class="form-group">
                            <label>Category</label>
                            <select type="text" name="category" class="form-control">
                                <option value="0">@lang('main.select_category') </option>
                                @forelse($categories as $category)
                                    <option value="{{$category->id}}">{{$category->translate($langs[0]->code)->name}}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('category')
                            <div class="text-danger">{{ $errors->first('category') }}</div>
                            @enderror
                        </div>



                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-8">
                                    <lable>@lang('main.star') </lable>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input {{($category->star ?'checked':'')}} name="star" type="checkbox" class="custom-control-input" id="customCheck2">
                                        <label class="custom-control-label" for="customCheck2"></label>
                                    </div>
                                </div>
                            </div>
                            @error('star')
                            <div class="text-danger">{{ $errors->first('star') }}</div>
                            @enderror
                        </div>


                        


                    </div>



                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> @lang('main.update') </button>
                    </div>


                </form>
            </div>

        </div>
    </section>
@endsection

