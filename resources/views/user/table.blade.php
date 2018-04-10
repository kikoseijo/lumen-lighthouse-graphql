<table class="{{config('ksoft.style.table_style')}}">
    <caption class="text-right">@includeIf('klaravel::ui.tables.count')</caption>
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th class="btn-actions"></th>
            <th class="text-center">
                Name
                @include('klaravel::ui.tables.order', ['att' => 'active'])
            </th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($records as $item)
        <tr>
            <th scope="row">{{ $item->id }}</th>
            <td class="text-center">
                <a href="{{route($model_name.'.status_change',[$item->id,'active', $item->active ? '0' : '1'])}}">
                    <i class="{{ $item->active ? 'far fa-eye text-success' : 'far fa-eye-slash text-danger' }}"></i>
                </a>
            </td>
            <td><a href="{{route($model_name.'.edit', $item->id)}}">{{ $item->name }}</a></td>
            @include('klaravel::ui.tables.actions', ['size' => 'sm'])
        </tr>
    @endforeach
    </tbody>
</table>
