<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

{{--    <ul class="navbar-nav ml-auto">--}}
{{--        <li class="nav-item mt-2">Customer:<b id="customer-name">--}}
{{--                @if(Session::has('CustomerName'))--}}
{{--                        {{ Session::get('CustomerName')}}--}}
{{--                @endif--}}
{{--            </b>  |  % Retail:<b id="retail">--}}
{{--                @if(Session::has('PercentOfRetail'))--}}
{{--                    {{ Session::get('PercentOfRetail')}}--}}
{{--                @endif--}}
{{--            </b></li>--}}
{{--        <li class="nav-item dropdown">--}}
{{--            <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                <i class="fas fa-user-tag"></i>--}}
{{--                <span class="badge badge-danger navbar-badge">3</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
{{--                <form name="customerForm" id="customerForm" class="mx-3 my-3">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="exampleInputEmail1">Customer Name</label>--}}
{{--                        <input type="text"--}}
{{--                               class="form-control"--}}
{{--                               name="CustomerName"--}}
{{--                               id="CustomerName"--}}
{{--                               placeholder="CustomerName"--}}
{{--                               value="{{Session::get('CustomerName')}}">--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="PercentOfRetail">Percent Of Retail</label>--}}
{{--                        <input type="number"--}}
{{--                               class="form-control"--}}
{{--                               name="PercentOfRetail"--}}
{{--                               id="PercentOfRetail"--}}
{{--                               placeholder="PercentOfRetail"--}}
{{--                               value={{ Session::get('PercentOfRetail')}}>--}}
{{--                    </div>--}}
{{--                    @if( Session::has('CustomerName'))--}}
{{--                        <button type="submit" class="btn btn-success btn-sm btn-block disabled">Create Customer</button>--}}
{{--                    @else--}}
{{--                    <button type="submit" class="btn btn-success btn-sm btn-block ">Create Customer</button>--}}
{{--                    @endif--}}
{{--                </form>--}}

{{--                <form name="closeCustomerForm" id="closeCustomerForm" class="mx-3 my-3">--}}
{{--                    <button type="submit" class="btn btn-warning btn-sm btn-block">Close Quotation</button>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </li>--}}
{{--        <!-- Notifications Dropdown Menu -->--}}
{{--        <li class="nav-item dropdown">--}}
{{--            <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                <i class="fas fa-cart-plus"></i>--}}
{{--                <span class="badge badge-warning navbar-badge">15</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
{{--                <span class="dropdown-item dropdown-header">15 Notifications</span>--}}
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a href="#" class="dropdown-item">--}}
{{--                    <i class="fas fa-envelope mr-2"></i> 4 new messages--}}
{{--                    <span class="float-right text-muted text-sm">3 mins</span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a href="#" class="dropdown-item">--}}
{{--                    <i class="fas fa-users mr-2"></i> 8 friend requests--}}
{{--                    <span class="float-right text-muted text-sm">12 hours</span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a href="#" class="dropdown-item">--}}
{{--                    <i class="fas fa-file mr-2"></i> 3 new reports--}}
{{--                    <span class="float-right text-muted text-sm">2 days</span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
{{--            </div>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">--}}
{{--                <i class="fas fa-th-large"></i>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
</nav>
<!-- /.navbar -->

{{--@push('scripts')--}}
{{--    <script>--}}

{{--    $("#customerForm").on('submit',function(e){--}}
{{--        e.preventDefault();--}}
{{--        $(this).attr("action","/customers/saveMemory").attr('method','POST');--}}

{{--        let url = $(this).attr('action');--}}
{{--        let method = $(this).attr('method');--}}
{{--        let result = myAjax(url,method,$(this).serialize());--}}

{{--        $("#customer-name").text(result.CustomerName);--}}
{{--        $("#retail").text(result.PercentOfRetail);--}}
{{--        location.reload();--}}
{{--    });--}}
{{--    $("#closeCustomerForm").on('submit',function(e){--}}
{{--        e.preventDefault();--}}
{{--        $(this).attr("action","/customers/removeMemory").attr('method','POST');--}}
{{--        let url = $(this).attr('action');--}}
{{--        let method = $(this).attr('method');--}}
{{--        myAjax(url,method);--}}
{{--        location.reload();--}}
{{--    });--}}

{{--    </script>--}}
{{--@endpush--}}
