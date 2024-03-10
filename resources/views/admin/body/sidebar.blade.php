<div class="vertical-menu">

    <div data-simplebar class="h-100">
        @php
        $id = Auth::user()->id;
        $adminData = App\Models\Admin::find($id);
        @endphp

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="">
                <img src="{{ (!empty($adminData->photo))?  url('upload/admin_images/'.$adminData->photo):
                url('upload/no_image.jpg') }}" alt="" class="avatar-md rounded-circle">
            </div>
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">{{ Auth::user()->name }}</h4>
                <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i> Online</span>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ url('/admin/dashboard')}}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title">Inventory System</li>
                <li>
                    <a href="{{ route('products.dashboard') }}" class=" waves-effect">
                        <i class="ri-dashboard-3-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-stock-line"></i>
                        <span>Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('products.index') }}"><i class="ri-arrow-right-double-line"></i> Product List</a></li>
                        <li><a href="{{ route('products.create') }}"><i class="ri-arrow-right-double-line"></i> New Product</a></li>
                    </ul>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-recycle-line"></i>
                        <span>Suppliers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('suppliers.index') }}"><i class="ri-arrow-right-double-line"></i> List</a></li>
                        <li><a href="{{ route('suppliers.create') }}"><i class="ri-arrow-right-double-line"></i> New Supplier</a></li>
                    </ul>
                </li>


                <li class="menu-title">Loans</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-team-line"></i>
                        <span>Members</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('members.index') }}"><i class="ri-arrow-right-double-line"></i>Member List</a></li>
                        <li><a href="{{ route('members.create') }}"><i class="ri-arrow-right-double-line"></i> New Member</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-p2p-fill"></i>
                        <span>Groups</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('groups.index') }}"><i class="ri-arrow-right-double-line"></i> Group List</a></li>
                        <li><a href="{{ route('groups.create') }}"><i class="ri-arrow-right-double-line"></i> New Group</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-database-line"></i>
                        <span>Loans</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('loans.index') }}"><i class="ri-arrow-right-double-line"></i> Loan List</a></li>
                        <li><a href="{{ route('loans.create') }}"><i class="ri-arrow-right-double-line"></i> Request Loan</a></li>
                    </ul>
                </li>

                <li class="menu-title">System Settings</li>
                <li>
                    <a href="{{ route('admin.profile.view') }}" class="waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>User Profile</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('settings.index') }}" class="waves-effect">
                        <i class="ri-list-settings-fill"></i>
                        <span>Settings</span>
                    </a>
                </li>


                <li class="menu-title">Help and Support</li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="ri-chat-4-line"></i>
                        <span>Chat with Us</span>
                    </a>
                </li>
                <li>
                    <a href="http://kipstechnologies.co.ke/" target="blank" class="waves-effect">
                        <i class="ri-global-line"></i>
                        <span>Softwares' Website</span>
                    </a>
                </li>



            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
