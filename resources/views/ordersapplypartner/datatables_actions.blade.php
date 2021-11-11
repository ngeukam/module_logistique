<div class='btn-group btn-group-sm'>
  @can('orders-apply-partner.show')
  <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.view_details')}}" href="{{ route('orders-apply-partner.show', $id) }}" class='btn btn-link'>
    <i class="fa fa-eye"></i>
  </a>
  @endcan

  @can('orders-apply-partner.edit')
  <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.order_edit')}}" href="{{ route('orders-apply-partner.edit', $id) }}" class='btn btn-link'>
    <i class="fa fa-edit"></i>
  </a>
  @endcan

  @can('orders-apply-partner.destroy')
{!! Form::open(['route' => ['orders-apply-partner.destroy', $id], 'method' => 'delete']) !!}
  {!! Form::button('<i class="fa fa-trash"></i>', [
  'type' => 'submit',
  'class' => 'btn btn-link text-danger',
  'onclick' => "return confirm('Are you sure?')"
  ]) !!}
{!! Form::close() !!}
  @endcan
</div>
