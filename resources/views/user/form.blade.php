<div class="row">
  <div class="col-sm-3">
    {!! Former::text('name')->required()->label('Name') !!}
  </div>
  <div class="col-sm-3">
    {!! Former::email('email')->required()->label('Email') !!}
  </div>
  <div class="col-sm-3">
    {!! Former::files('img')->accept('image/jpeg', 'image/png') !!}
  </div>
  <div class="col-sm-3">
      @include('klaravel::ui.forms.radios',[
          'items' => ['1' => 'Yes', '0' => 'No'],
          'label' => 'Online',
          'name' => 'online',
          'value' => isset($record) ? $record->online : '',
      ])
  </div>
</div>

@include('klaravel::ui.forms.textarea',[
    'name' => 'excerpt',
    'label' => 'Short description',
    'rows' => 2
])

@include('klaravel::ui.forms.textarea',[
    'name' => 'text',
    'label' => 'Description',
])


@include('klaravel::ui.forms.buttons')
