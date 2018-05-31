<table class="table table-hover table-condense datatable" id="rows">
    <thead>
        <th class="hide">ID</th>
        <th>
            <div class="checkbox check-success  ">
                <input id="checkboxParent" type="checkbox">
                <label for="checkboxParent"></label>
            </div>
        </th>
        <th>Nombre del prospecto</th>
        <th>¿Registrado?</th>
        <th>Email</th>
        <th>Teléfono</th>
        <th>Oficina interesada</th>
        <th>Acciones</th>
    </thead>
    <tbody>
        @foreach($prospects as $prospect)
            <tr>
                <td class="hide">{{$prospect->id}}</td>
                <td>
                    <div class="checkbox check-success">
                        <input id="checkbox{{$prospect->id}}" class="multiple-delete" type="checkbox" value="{{$prospect->id}}">
                        <label for="checkbox{{$prospect->id}}"></label>
                    </div>
                </td>
                @if ($prospect->customer){{-- Toma los datos directamente del usuario registrado --}}
                    <td>{{$prospect->customer->fullname}}</td>
                    <td>Registrado</td>
                    <td>{{$prospect->customer->email}}</td>
                    <td>{{$prospect->customer->phone}}</td>
                @else{{-- Toma los datos directamente de la aplicación --}}
                    <td>{{$prospect->fullname}}</td>
                    <td>Sin registrar</td>
                    <td>{{$prospect->email}}</td>
                    <td>{{$prospect->phone}}</td>
                @endif
                
                <td>{{$prospect->office->name}}</td>
                <td>
                    <a href="javascript:;" class="btn btn-xs btn-mini btn view-details" data-toggle="tooltip" data-parent-id="{{$prospect->id}}" data-placement="top" title="Ver detalles"><i class="fa fa-info"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-mini btn-info view-comments" data-toggle="tooltip" data-parent-id="{{$prospect->id}}" data-placement="top" title="Ver comentarios"><i class="fa fa-eye"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
