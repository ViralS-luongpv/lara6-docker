@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Table
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($table, ['route' => ['tables.update',app()->getLocale(), $table->id], 'method' => 'patch']) !!}

                        @include('tables.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection