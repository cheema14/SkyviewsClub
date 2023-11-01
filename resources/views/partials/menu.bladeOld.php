<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.userManagement.title') }}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('permission_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.permission.title') }}
                    </a>
                </li>
                @endcan
                @can('role_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.role.title') }}
                    </a>
                </li>
                @endcan
                @can('user_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.user.title') }}
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('master_data_managment_access')
        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/designations*") ? "c-show" : "" }} {{ request()->is("admin/departments*") ? "c-show" : "" }} {{ request()->is("admin/membership-categories*") ? "c-show" : "" }} {{ request()->is("admin/membership-types*") ? "c-show" : "" }}">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.masterDataManagment.title') }}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('designation_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.designations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/designations") || request()->is("admin/designations/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-list-alt c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.designation.title') }}
                    </a>
                </li>
                @endcan
                @can('department_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.departments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/departments") || request()->is("admin/departments/*") ? "c-active" : "" }}">
                        <i class="fa-fw far fa-list-alt c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.department.title') }}
                    </a>
                </li>
                @endcan
                @can('membership_category_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.membership-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/membership-categories") || request()->is("admin/membership-categories/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-list c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.membershipCategory.title') }}
                    </a>
                </li>
                @endcan
                @can('membership_type_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.membership-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/membership-types") || request()->is("admin/membership-types/*") ? "c-active" : "" }}">
                        <i class="fa-fw fab fa-typo3 c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.membershipType.title') }}
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('inventory_data_managment_access')
        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/stores*") ? "c-show" : "" }} {{ request()->is("admin/vendors*") ? "c-show" : "" }} {{ request()->is("admin/units*") ? "c-show" : "" }} {{ request()->is("admin/item-types*") ? "c-show" : "" }} {{ request()->is("admin/store-items*") ? "c-show" : "" }}">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.inventoryDataManagment.title') }}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('store_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.stores.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/stores") || request()->is("admin/stores/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-store-alt c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.store.title') }}
                    </a>
                </li>
                @endcan
                @can('vendor_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.vendors.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/vendors") || request()->is("admin/vendors/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-bullhorn c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.vendor.title') }}
                    </a>
                </li>
                @endcan
                @can('unit_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.units.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/units") || request()->is("admin/units/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-balance-scale c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.unit.title') }}
                    </a>
                </li>
                @endcan
                @can('item_type_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.item-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/item-types") || request()->is("admin/item-types/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-list c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.itemType.title') }}
                    </a>
                </li>
                @endcan
                @can('store_item_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.store-items.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/store-items") || request()->is("admin/store-items/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-list c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.storeItem.title') }}
                    </a>
                </li>
                @endcan
                @can('section_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.sections.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sections") || request()->is("admin/sections/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-puzzle-piece c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.section.title') }}
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('hr_management_access')
        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/employees*") ? "c-show" : "" }}">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.hrManagement.title') }}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('employee_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.employees.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employees") || request()->is("admin/employees/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-users-cog c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.employee.title') }}
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('member_access')
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.members.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/members") || request()->is("admin/members/*") ? "c-active" : "" }}">
                <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.member.title') }}
            </a>
        </li>
        @endcan
        @can('good_receipt_access')
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.good-receipts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/good-receipts") || request()->is("admin/good-receipts/*") ? "c-active" : "" }}">
                <i class="fa-fw fas fa-receipt c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.goodReceipt.title') }}
            </a>
        </li>
        @endcan

        @can('gr_item_detail_access' || false)
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.gr-item-details.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/gr-item-details") || request()->is("admin/gr-item-details/*") ? "c-active" : "" }}">
                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.grItemDetail.title') }}
            </a>
        </li>
        @endcan

        @can('stock_issue_access')
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.stock-issues.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/stock-issues") || request()->is("admin/stock-issues/*") ? "c-active" : "" }}">
                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.stockIssue.title') }}
            </a>
        </li>
        @endcan
        @can('stock_issue_item_access' || false)
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.stock-issue-items.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/stock-issue-items") || request()->is("admin/stock-issue-items/*") ? "c-active" : "" }}">
                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.stockIssueItem.title') }}
            </a>
        </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
        @can('profile_password_edit')
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                </i>
                {{ trans('global.change_password') }}
            </a>
        </li>
        @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
