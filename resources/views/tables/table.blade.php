<div class="table-responsive">
    <table class="table" id="tables-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Age</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tables as $table)
            <tr>
                <td>{{ $table->name }}</td>
            <td>{{ $table->age }}</td>
                <td>
                    {!! Form::open(['route' => ['tables.destroy', app()->getLocale()  ,$table->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('tables.show' , [app()->getLocale(),$table->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
{{--                        <a href="{{ route('tables.edit', [app()->getLocale(),$table->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>--}}
                        <div style="float: left" class="dropdown">
                            <button class="btn btn-xs btn-default dropdown-toggle" type="button" data-toggle="dropdown"><i class="glyphicon glyphicon-edit"></i>
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('tables.edit', ['en',$table->id]) }}">English</a></li>
                                <li><a href="{{ route('tables.edit', ['vi',$table->id]) }}">Vietnam</a></li>
                            </ul>
                        </div>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
