@foreach($items as $item)
    <p class="item-p">
        <a class="list-group-item" href="{{ route('adminzone.admin.categories.edit', $item->id) }}">
            {{ $item->title }}
        </a>
        <span>
            @if(!$item->hasChildren())
                <a class="delete" href="{{ url("/admin/categories/mydel?id=$item->id") }}">
                  <i class="fa fa-fw fa-close text-danger"></i>
                </a>
            @else
                <i class="fa fa-fw fa-close"></i>
            @endif
        </span>
    </p>

    @if($item->hasChildren())
        <div class="list-group">
            @include('admin-panel.admin.category.menu.customMenuItems', ['items' => $item->children()])
        </div>
    @endif
@endforeach