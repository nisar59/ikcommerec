<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

<div data-simplebar class="h-100">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title">Main</li>

            <li>
                <a href="{{url('/admin/dashboard')}}" class="waves-effect">
                    <i class="ti-home"></i>{{--<span class="badge badge-pill badge-primary float-right">2</span>--}}
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="mdi mdi-account-multiple-outline"></i>
                    <span>Product </span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{url('admin/categories')}}">Categories</a></li>
                    <li><a href="{{url('admin/products')}}">Products</a></li>
                    <li><a href="{{url('admin/variations')}}">Product variations</a></li>
                    <li><a href="{{url('admin/importexport')}}">Imports Products</a></li>
                    {{--<li><a href="{{url('/courses')}}">Course</a></li>--}}
                    {{-- <li><a href="{{url('/curriculums')}}">Curriculum</a></li>
                    <li><a href="email-compose">Email Compose</a></li>--}}
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="mdi mdi-account-multiple-outline"></i>
                    <span>Sales</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{url('admin/users/customers')}}">Customers</a></li>
                    <li><a href="{{url('admin/order/list')}}">Sales</a></li>
                    <li><a href="{{url('admin/invoices/list')}}">Invoices</a></li>
                    <li><a href="{{url('admin/coupon')}}">Coupon</a></li>

                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="mdi mdi-account-multiple-outline"></i>
                    <span>Financial</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{url('admin/transactional-accounts')}}">Transactional Accounts</a></li>
                    <li><a href="{{url('admin/transactions')}}">Daily Cash Voucher</a></li>
                    {{--<li><a href="{{url('admin/order/list')}}">Sales</a></li>--}}
                    {{--<li><a href="{{url('admin/coupon')}}">Coupon</a></li>--}}

                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="ti-view-grid"></i>
                    <span>CMS</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{url('admin/cms/page')}}">Pages</a></li>
                    {{--<li><a href="{{url('admin/cms/section')}}">Sections</a></li>--}}
                    <li><a href="{{url('admin/slides')}}">Slider Banners</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="mdi mdi-account-multiple-outline"></i>
                    <span>Reports</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{url('admin/purchases')}}">Purchase Report</a></li>
                      <li><a href="{{url('admin/financereport')}}">Finance Report</a></li>
                    <li><a href="{{url('admin/order/product-sales-report')}}">Sales Products</a></li>
                    <li><a href="{{url('admin/order/stock-report')}}">Stock Reprots</a></li>
<!--                     <li><a href="{{url('admin/order/dead-stock-report')}}">Dead Level Stock Reprot</a></li>
 -->                     <li><a href="{{url('admin/transactions/report')}}">Daily Cash Voucher Reprot</a></li>
                      <li><a href="{{url('admin/transactions/accountsreport')}}">Accounts Report</a></li>
                       <li><a href="{{url('admin/transactions/individualaccountreport')}}">Individual Accounts Report</a></li>
                    {{--<li><a href="{{url('admin/suppliers')}}">Supplier Managment</a></li>--}}
                    {{--<li><a href="{{url('admin/brands')}}">Brands Managment</a></li>--}}
                    {{--<li><a href="{{url('admin/paymentsmethods')}}">Payment Methods</a></li>--}}
                    {{--<li><a href="{{url('admin/transactions')}}">Daily Cash Voucher</a></li>--}}
                    {{--<li><a href="{{url('admin/order/list')}}">Sales</a></li>--}}
                    <li><a href="{{url('admin/newsletter')}}">Newsletter Subscriptions</a></li>

                </ul>
            </li>

       



            {{--<li>--}}
                {{--<a href="javascript: void(0);" class="has-arrow waves-effect">--}}
                    {{--<i class="mdi mdi-account-multiple-outline"></i>--}}
                    {{--<span>Purcahse Reports</span>--}}
                {{--</a>--}}
                {{--<ul class="sub-menu" aria-expanded="false">--}}
                    {{--<li><a href="{{url('admin/purchases')}}">All Purchases</a></li>--}}
                    {{--<li><a href="{{url('admin/transactions')}}">Daily Cash Voucher</a></li>--}}
                    {{--<li><a href="{{url('admin/order/list')}}">Sales</a></li>--}}
                    {{--<li><a href="{{url('admin/coupon')}}">Coupon</a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}




            {{--<li>--}}
                {{--<a href="{{url('admin/users/instructors')}}" class="waves-effect">--}}
                    {{--<i class="ti-home"></i>--}}{{--<span class="badge badge-pill badge-primary float-right">2</span>--}}
                    {{--<span>Instructors</span>--}}
                {{--</a>--}}
            {{--</li>--}}




            {{--<li>--}}
                {{--<a href="{{url('admin/medialibrary/media-library')}}" class="waves-effect">--}}
                    {{--<i class="ti-home"></i>--}}{{--<span class="badge badge-pill badge-primary float-right">2</span>--}}
                    {{--<span>Media Library</span>--}}
                {{--</a>--}}
            {{--</li>--}}


            {{--<li>--}}
                {{--<a href="{{url('admin/warehouses')}}" class="waves-effect">--}}
                    {{--<i class="ti-home"></i>--}}{{--<span class="badge badge-pill badge-primary float-right">2</span>--}}
                    {{--<span>Ware Houses</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="{{url('admin/stores')}}" class="waves-effect">--}}
                    {{--<i class="ti-home"></i>--}}{{--<span class="badge badge-pill badge-primary float-right">2</span>--}}
                    {{--<span></span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="{{url('admin/suppliers')}}" class="waves-effect">--}}
                    {{--<i class="ti-home"></i>--}}{{--<span class="badge badge-pill badge-primary float-right">2</span>--}}
                    {{--<span>Supplier Managment</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="{{url('admin/brands')}}" class="waves-effect">--}}
                    {{--<i class="ti-home"></i>--}}{{--<span class="badge badge-pill badge-primary float-right">2</span>--}}
                    {{--<span>Brands Managment</span>--}}
                {{--</a>--}}
            {{--</li>--}}

            {{--<li>--}}
                {{--<a href="{{url('admin/paymentsmethods')}}" class="waves-effect">--}}
                    {{--<i class="ti-home"></i>--}}{{--<span class="badge badge-pill badge-primary float-right">2</span>--}}
                    {{--<span>Payment Methods</span>--}}
                {{--</a>--}}
            {{--</li>--}}

           
            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="mdi mdi-settings"></i>
                    <span>Settings</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                     <li><a href="{{url('admin/users')}}">Users</a></li>
                    <li><a href="{{url('admin/users/roles')}}">Roles </a></li>
                    <li><a href="{{url('admin/warehouses')}}">Ware Houses</a></li>
                    <li><a href="{{url('admin/stores')}}">Stores Managment</a></li>
                    <li><a href="{{url('admin/suppliers')}}">Supplier Managment</a></li>
                    <li><a href="{{url('admin/brands')}}">Brands Managment</a></li>
                    <li><a href="{{url('admin/paymentsmethods')}}">Payment Methods</a></li>
                    <li><a href="{{url('admin/settings')}}" class=" waves-effect">Settings</a></li>



                    {{--<li><a href="{{url('admin/transactions')}}">Daily Cash Voucher</a></li>--}}
                    {{--<li><a href="{{url('admin/order/list')}}">Sales</a></li>--}}
                    {{--<li><a href="{{url('admin/coupon')}}">Coupon</a></li>--}}

                </ul>
            </li>
            {{--<li>--}}
                {{--<a href="{{url('admin/menu')}}" class=" waves-effect">--}}
                    {{--<i class="ti-calendar"></i>--}}
                    {{--<span>Menu</span>--}}
                {{--</a>--}}
            {{--</li>--}}





        </ul>
    </div>
    <!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->