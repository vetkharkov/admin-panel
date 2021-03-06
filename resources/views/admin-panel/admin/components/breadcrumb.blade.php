<h1>
    @if(isset($title))
        {{ $title }}
    @endif
</h1>

<ol class="breadcrumb">
    <li>
        <a href="{{route('adminzone.admin.index.index')}}">
            <i class="fa fa-dashboard"></i>
            {{$parent}}
        </a>
    </li>

    @if(isset($order))
        <li>
            <a href="{{route('adminzone.admin.orders.index')}}">{{ $order }}</a>
        </li>
    @endif

    @if(isset($category))
        <li>
            <a href="{{route('adminzone.admin.categories.index')}}">{{ $category }}</a>
        </li>
    @endif

    @if(isset($user))
        <li>
            <a href="{{route('adminzone.admin.users.index')}}">{{ $user }}</a>
        </li>
    @endif

    @if(isset($product))
        <li>
            <a href="{{route('adminzone.admin.products.index')}}">{{ $product }}</a>
        </li>
    @endif

    @if(isset($group_filter))
        <li>
            <a href="{{route('adminzone.admin.filters.group-filter')}}">{{ $group_filter }}</a>
        </li>
    @endif

    @if(isset($attrs_filter))
        <li>
            <a href="{{route('adminzone.admin.filters.attributes-filter')}}">{{ $attrs_filter }}</a>
        </li>
    @endif

    @if(isset($currency))
        <li>
            <a href="{{route('adminzone.admin.currency.index')}}">{{ $currency }}</a>
        </li>
    @endif

    <li><i class="active">{{ $active }}</i></li>

</ol>

