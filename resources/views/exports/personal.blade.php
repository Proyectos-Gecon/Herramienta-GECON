<table>
    <thead>
    <tr>
        <th>ID SAP</th>
        <th>Nombre</th>
        <th>IDENTIFICACIÓN</th>
        <th>Estado</th>
        <th>DIVISIÓN</th>
        <th>CARGO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($personal as $user)
        <tr>
            <td>{{ $user->user->NUM_SAP }}</td>
            <td>{{ $user->user->APELLIDOS_NOMBRES }}</td>
            <td>{{ $user->user->IDENTIFICACION }}</td>
            <td>{{ $user->parte->estado }}</td>
            <td>{{ $user->division->name }}</td>
            <td>{{ $user->user->CARGO }}</td>
        </tr>
    @endforeach
    </tbody>