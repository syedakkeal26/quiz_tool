<!DOCTYPE html>
<html>
@include('layouts.partitions.header')
<link rel="shortcut icon" href="https://mycipl.in//images/favicon.ico" type="image/x-icon"/>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    @if($page != 'download')
    @include('layouts.partitions.topnav')
	@include('layouts.partitions.sidenav')
    @endif

	<div class="content-wrapper" id="fullscreen"  oncontextmenu="return false";>
		@yield('content')

	</div>
    @if($page != 'download')
	@include('layouts.partitions.footer')
    @endif


</div>
</body>
</html>
