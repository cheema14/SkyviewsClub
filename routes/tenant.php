<?php
declare(strict_types=1);


use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\CancelOrderController;
// use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\CashReceiptController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DependentController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\EmployeeDependentsController;
use App\Http\Controllers\Admin\FloorOrderController;
use App\Http\Controllers\Admin\GenerateBillController;
use App\Http\Controllers\Admin\GoodReceiptController;
use App\Http\Controllers\Admin\GrItemDetailController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ItemClassController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ItemTypeController;
use App\Http\Controllers\Admin\KitchenReceiptController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MembershipCategoryController;
use App\Http\Controllers\Admin\MembershipTypeController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemCategoryController;
use App\Http\Controllers\Admin\MonthlyBillController;
use App\Http\Controllers\Admin\OldBillsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderItemController;
use App\Http\Controllers\Admin\PaymentHistoryController;
use App\Http\Controllers\Admin\PaymentReceiptController;
use App\Http\Controllers\Admin\PaymentSummaryController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\RoomBookingController;
use App\Http\Controllers\Admin\RoomStatusController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SportBillingItemController;
use App\Http\Controllers\Admin\SportItemClassController;
use App\Http\Controllers\Admin\SportItemNameController;
use App\Http\Controllers\Admin\SportItemTypeController;
use App\Http\Controllers\Admin\SportsBillingController;
use App\Http\Controllers\Admin\SportsDivisionController;
use App\Http\Controllers\Admin\StockIssueController;
use App\Http\Controllers\Admin\StockIssueItemController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\StoreItemController;
use App\Http\Controllers\Admin\TableTopController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\ViewBillController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;




/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/
Route::middleware([
    'web',
    'tenantSetup',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/tenantsLogin', function () {
        // dd(tenant());
        // return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
    Route::get('/tLogin', function () {
        return redirect()->route('loginScreen');
    });
    Route::get('/', [LoginController::class, 'loginScreen'])->name('loginScreen');
    // Route::get('/home', function(){
        
    // });
    
    Route::post('/sendLogin', [LoginController::class, 'login'])->name('login');
    
    
    Route::get('health', HealthCheckResultsController::class);
});



Route::group([
    'prefix' => 'admin', 'as' => 'admin.', 
    'middleware' => [
        'auth','web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class
    ]], function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('tenant.logout');

    Route::get('/', [HomeController::class,'index'])->name('tenant.home');
    
    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class,'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [RolesController::class,'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);

    // Users
    Route::delete('users/destroy', [UsersController::class,'massDestroy'])->name('users.massDestroy');
    Route::resource('users', UsersController::class);

    // Designation
    Route::delete('designations/destroy', [DesignationController::class,'massDestroy'])->name('designations.massDestroy');
    Route::post('designations/parse-csv-import', [DesignationController::class,'parseCsvImport'])->name('designations.parseCsvImport');
    Route::post('designations/process-csv-import', [DesignationController::class,'processCsvImport'])->name('designations.processCsvImport');
    Route::resource('designations', DesignationController::class, ['except' => ['show']]);

    // Member
    Route::delete('members/destroy', [MemberController::class,'massDestroy'])->name('members.massDestroy');
    Route::post('members/media', [MemberController::class,'storeMedia'])->name('members.storeMedia');
    Route::post('members/ckmedia', [MemberController::class,'storeCKEditorImages'])->name('members.storeCKEditorImages');
    Route::post('members/parse-csv-import', [MemberController::class,'parseCsvImport'])->name('members.parseCsvImport');
    Route::post('members/process-csv-import', [MemberController::class,'processCsvImport'])->name('members.processCsvImport');
    Route::get('memberServing/load-serving-members', [MemberController::class,'loadServingMembers'])->name('members.loadServingMembers');
    Route::get('memberAbsentees/load-absentees-members', [MemberController::class,'load_absentees_members'])->name('members.loadAbsenteesMembers');
    Route::get('members/get_member_name', [MemberController::class,'get_member_name'])->name('membersInfo.get_member_name');
    Route::resource('members', MemberController::class);

    // Dependent
    Route::delete('dependents/destroy', [DependentController::class,'massdestroy'])->name('dependents.massDestroy');
    Route::post('dependents/media', [DependentController::class,'storemedia'])->name('dependents.storeMedia');
    Route::post('dependents/ckmedia', [DependentController::class,'storeCKEditorImages'])->name('dependents.storeCKEditorImages');
    Route::post('dependents/parse-csv-import', [DependentController::class,'parsecsvimport'])->name('dependents.parseCsvImport');
    Route::post('dependents/process-csv-import', [DependentController::class,'processcsvimport'])->name('dependents.processCsvImport');
    //  Route::resource('dependents', 'DependentController');
    Route::get('dependents/create-dependent/{member}', [DependentController::class,'create'])->name('dependents.create');
    Route::get('dependents/list-dependents/{member}', [DependentController::class,'index'])->name('dependents.index');
    Route::post('dependents/store-dependents/{member}', [DependentController::class,'store'])->name('dependents.store');
    Route::get('dependents/show-dependents/{member}', [DependentController::class,'show'])->name('dependents.show');
    Route::delete('dependents/destroy-dependent/{dependent}', [DependentController::class,'destroy'])->name('dependents.destroy');
    Route::get('dependents/edit-dependents/{dependent}', [DependentController::class,'edit'])->name('dependents.edit');
    Route::put('dependents/update-dependent/{dependent}', [DependentController::class,'update'])->name('dependents.update');
    //  Route::get('dependents/dependents/{}', 'DependentController@index')->name('dependents.index');

    // Store
    Route::delete('stores/destroy', [StoreController::class,'massDestroy'])->name('stores.massDestroy');
    Route::post('stores/parse-csv-import', [StoreController::class,'parseCsvImport'])->name('stores.parseCsvImport');
    Route::post('stores/process-csv-import', [StoreController::class,'processCsvImport'])->name('stores.processCsvImport');
    Route::resource('stores', StoreController::class, ['except' => ['show']]);

    // Vendor
    Route::delete('vendors/destroy', [VendorController::class, 'massDestroy'])->name('vendors.massDestroy');
    Route::post('vendors/parse-csv-import', [VendorController::class, 'parseCsvImport'])->name('vendors.parseCsvImport');
    Route::post('vendors/process-csv-import', [VendorController::class, 'processCsvImport'])->name('vendors.processCsvImport');
    Route::resource('vendors', VendorController::class, ['except' => ['show']]);

    // Unit
    Route::delete('units/destroy', [UnitController::class, 'massDestroy'])->name('units.massDestroy');
    Route::post('units/parse-csv-import', [UnitController::class, 'parseCsvImport'])->name('units.parseCsvImport');
    Route::post('units/process-csv-import', [UnitController::class, 'processCsvImport'])->name('units.processCsvImport');
    Route::resource('units', UnitController::class, ['except' => ['show']]);

    // Item Type
    Route::delete('item-types/destroy', [ItemTypeController::class, 'massDestroy'])->name('item-types.massDestroy');
    Route::post('item-types/parse-csv-import', [ItemTypeController::class, 'parseCsvImport'])->name('item-types.parseCsvImport');
    Route::post('item-types/process-csv-import', [ItemTypeController::class, 'processCsvImport'])->name('item-types.processCsvImport');
    Route::resource('item-types', ItemTypeController::class, ['except' => ['show']]);

    // Good Receipt
    Route::delete('good-receipts/destroy', [GoodReceiptController::class, 'massDestroy'])->name('good-receipts.massDestroy');
    Route::resource('good-receipts', GoodReceiptController::class);

    // Store Item
    Route::delete('store-items/destroy', [StoreItemController::class, 'massDestroy'])->name('store-items.massDestroy');
    Route::resource('store-items', StoreItemController::class, ['except' => ['show']]);
    Route::get('store-items/get_item_by_id', [StoreItemController::class, 'get_by_id'])->name('store-items.get_by_id');

    // Stock Issue Item - When issuing items to employees, fetch the lot no
    Route::get('store-items/get-lot-no-by-items', [StockIssueController::class, 'get_lot_no_by_items'])->name('store-items.get_lot_by_item');

    // Gr Item Detail
    Route::delete('gr-item-details/destroy', [GrItemDetailController::class, 'massDestroy'])->name('gr-item-details.massDestroy');
    Route::resource('gr-item-details', GrItemDetailController::class);

    // Department
    Route::delete('departments/destroy', [DepartmentController::class, 'massDestroy'])->name('departments.massDestroy');
    Route::post('departments/parse-csv-import', [DepartmentController::class, 'parseCsvImport'])->name('departments.parseCsvImport');
    Route::post('departments/process-csv-import', [DepartmentController::class, 'processCsvImport'])->name('departments.processCsvImport');
    Route::resource('departments', DepartmentController::class, ['except' => ['show']]);

    // Membership Category
    Route::delete('membership-categories/destroy', [MembershipCategoryController::class, 'massDestroy'])->name('membership-categories.massDestroy');
    Route::post('membership-categories/parse-csv-import', [MembershipCategoryController::class, 'parseCsvImport'])->name('membership-categories.parseCsvImport');
    Route::post('membership-categories/process-csv-import', [MembershipCategoryController::class, 'processCsvImport'])->name('membership-categories.processCsvImport');
    Route::resource('membership-categories', MembershipCategoryController::class, ['except' => ['show']]);

    // Membership Type
    Route::delete('membership-types/destroy', [MembershipTypeController::class, 'massDestroy'])->name('membership-types.massDestroy');
    Route::post('membership-types/parse-csv-import', [MembershipTypeController::class, 'parseCsvImport'])->name('membership-types.parseCsvImport');
    Route::post('membership-types/process-csv-import', [MembershipTypeController::class, 'processCsvImport'])->name('membership-types.processCsvImport');
    Route::resource('membership-types', MembershipTypeController::class, ['except' => ['show']]);
    Route::post('get-membership-fees', [MembershipTypeController::class, 'get_membership_fees'])->name('membership-types.get-membership-fees');


    Route::delete('gr-item-details/destroy', [GrItemDetailController::class, 'massDestroy'])->name('gr-item-details.massDestroy');
    Route::resource('gr-item-details', GrItemDetailController::class);

    Route::delete('sections/destroy', [SectionController::class, 'massDestroy'])->name('sections.massDestroy');
    Route::post('sections/parse-csv-import', [SectionController::class, 'parseCsvImport'])->name('sections.parseCsvImport');
    Route::post('sections/process-csv-import', [SectionController::class, 'processCsvImport'])->name('sections.processCsvImport');
    Route::resource('sections', SectionController::class);

    Route::delete('employees/destroy', [EmployeeController::class, 'massDestroy'])->name('employees.massDestroy');
    Route::resource('employees', EmployeeController::class);
    Route::post('employees/parse-csv-import', [EmployeeController::class, 'parseCsvImport'])->name('employees.parseCsvImport');
    Route::post('employees/process-csv-import', [EmployeeController::class, 'processCsvImport'])->name('employees.processCsvImport');
    Route::post('employees/media', [EmployeeController::class, 'storeMedia'])->name('employees.storeMedia');

    Route::get('employee-dependents/create-employee-dependent/{id}', [EmployeeDependentsController::class, 'create'])->name('employee.dependents.create');
    Route::post('employee-dependents/store-employee-dependent/{id}', [EmployeeDependentsController::class, 'store'])->name('employee.dependents.store');
    Route::put('employee-dependents/update-employee-dependent/{employeedependent}', [EmployeeDependentsController::class, 'update'])->name('employee.dependents.update');
    Route::get('employee-dependents/edit-employee-dependent/{employeedependent}', [EmployeeDependentsController::class, 'edit'])->name('employee.dependents.edit');
    Route::get('employee-dependents/load-all-dependents/{employee}', [EmployeeDependentsController::class, 'index'])->name('employee.dependents.list');
    Route::delete('employee-dependents/delete-employee-dependent/{employeedependent}', [EmployeeDependentsController::class, 'delete'])->name('employee.dependents.delete');

    Route::delete('stock-issues/destroy', [StockIssueController::class, 'massDestroy'])->name('stock-issues.massDestroy');
    Route::resource('stock-issues', StockIssueController::class);

    Route::delete('stock-issue-items/destroy', [StockIssueItemController::class, 'massDestroy'])->name('stock-issue-items.massDestroy');
    Route::resource('stock-issue-items', StockIssueItemController::class);

    Route::get('store-items/get-store-items', [StockIssueController::class, 'get_store_items'])->name('store-items.get-store-items');

    Route::delete('menus/destroy', [MenuController::class, 'massDestroy'])->name('menus.massDestroy');
    Route::resource('menus', MenuController::class);

    Route::delete('menu-item-categories/destroy', [MenuItemCategoryController::class, 'massDestroy'])->name('menu-item-categories.massDestroy');
    Route::resource('menu-item-categories', MenuItemCategoryController::class);

    Route::get('items/item', [ItemController::class, 'getItemById'])->name('items.getById');
    Route::get('items/itemByMenu', [ItemController::class, 'getItemByMenu'])->name('items.getItemByMenu');
    Route::delete('items/destroy', [ItemController::class, 'massDestroy'])->name('items.massDestroy');
    Route::post('items/parse-csv-import', [ItemController::class, 'parseCsvImport'])->name('items.parseCsvImport');
    Route::post('items/process-csv-import', [ItemController::class, 'processCsvImport'])->name('items.processCsvImport');
    Route::resource('items', ItemController::class);

    Route::delete('table-tops/destroy', [TableTopController::class, 'massDestroy'])->name('table-tops.massDestroy');
    Route::resource('table-tops', TableTopController::class);

    Route::delete('orders/destroy', [OrderController::class, 'massDestroy'])->name('orders.massDestroy');
    Route::resource('orders', OrderController::class);

    Route::delete('order-items/destroy', [OrderItemController::class, 'massDestroy'])->name('order-items.massDestroy');
    Route::resource('order-items', OrderItemController::class);

    Route::get('list-floor-orders', [FloorOrderController::class, 'list_floor_orders'])->name('list-floor-orders');
    Route::get('export-all-pdf', [OrderController::class, 'export_pdf'])->name('exportAllPdf');
    Route::get('export-all-active-pdf', [OrderController::class, 'export_pdf_active'])->name('exportActiveAllPdf');
    Route::get('export-all-excel', [OrderController::class, 'export_excel'])->name('exportAllExcel');

    Route::delete('transactions/destroy', [TransactionController::class, 'massDestroy'])->name('transactions.massDestroy');
    Route::resource('transactions', TransactionController::class);

    Route::get('monthly-bill', [BillController::class, 'index'])->name('monthly-bill');
    Route::get('view-monthly-bill/{member}', [ViewBillController::class, 'index'])->name('view-monthly-bill');
    Route::get('print-kitchen-receipt/{order}', [KitchenReceiptController::class, 'index'])->name('print-kitchen-receipt');
    Route::get('print-order-receipt/{order}', [GenerateBillController::class, 'index'])->name('print-order-receipt');
    Route::get('print-kitchen-order-history/{order}', [KitchenReceiptController::class, 'kitchen_order_history'])->name('print-kitchen-order-history');

    Route::delete('monthly-bills/destroy', [MonthlyBillController::class, 'massDestroy'])->name('monthly-bills.massDestroy');
    Route::resource('monthly-bills', MonthlyBillController::class);

    Route::get('print-customer-bill/{order}', [GenerateBillController::class, 'generate_customer_bill'])->name('print-customer-bill');
    Route::get('cash-receipt/{order}', [CashReceiptController::class, 'create_cash_receipt'])->name('cash-receipt');
    Route::post('store-cash-receipt/{order}', [CashReceiptController::class, 'store_receipt'])->name('store-receipt');

    // Cancel Order
    Route::post('cancel-order/{order}', CancelOrderController::class)->name('cancel-order');

    Route::delete('item-classes/destroy', [ItemClassController::class, 'massDestroy'])->name('item-classes.massDestroy');
    Route::post('item-classes/parse-csv-import', [ItemClassController::class, 'parseCsvImport'])->name('item-classes.parseCsvImport');
    Route::post('item-classes/process-csv-import', [ItemClassController::class, 'processCsvImport'])->name('item-classes.processCsvImport');
    Route::resource('item-classes', ItemClassController::class, ['except' => ['show']]);
    Route::get('item-classes/get_by_item_class_id', [ItemClassController::class, 'get_by_item_type'])->name('item-classes.get_by_item_type');

    Route::delete('sports-divisions/destroy', [SportsDivisionController::class, 'massDestroy'])->name('sports-divisions.massDestroy');
    Route::resource('sports-divisions', SportsDivisionController::class);

    Route::delete('sport-item-types/destroy', [SportItemTypeController::class, 'massDestroy'])->name('sport-item-types.massDestroy');
    Route::resource('sport-item-types', SportItemTypeController::class);

    Route::delete('sport-item-classes/destroy', [SportItemClassController::class, 'massDestroy'])->name('sport-item-classes.massDestroy');
    Route::resource('sport-item-classes', SportItemClassController::class);

    Route::delete('sport-item-names/destroy', [SportItemNameController::class, 'massDestroy'])->name('sport-item-names.massDestroy');
    Route::resource('sport-item-names', SportItemNameController::class);

    Route::delete('sports-billings/destroy', [SportsBillingController::class, 'massDestroy'])->name('sports-billings.massDestroy');
    Route::resource('sports-billings', SportsBillingController::class);
    Route::get('print-sports-bill/{sportsBilling}', [SportsBillingController::class, 'printSportsBill'])->name('print-sports-bill');
    
    // Sports Add - Fetch relevant items (division,item type, item class and item names)

    Route::get('sports-items/get_sports_item_type', [SportsBillingController::class,'get_sports_item_type'])->name('sports-items.get_sports_item_type');
    Route::get('sports-items/get_sports_classes', [SportsBillingController::class,'get_sports_classes'])->name('sports-items.get_sports_classes');
    Route::get('sports-items/get_sports_items', [SportsBillingController::class,'get_sports_items'])->name('sports-items.get_sports_items');
    Route::get('sports-items/get_item_details', [SportsBillingController::class,'get_item_details'])->name('sports-items.get_item_details');
    Route::get('print-sports-bill/{sportsBilling}', [SportsBillingController::class,'print_sports_bill'])->name('sports-billings.printBill');

    Route::delete('sports-billing-items/destroy', [SportBillingItemController::class, 'massDestroy'])->name('sports-billing-items.massDestroy');
    Route::resource('sports-billing-items', SportBillingItemController::class);

    Route::get('show-old-bills', [OldBillsController::class, 'showOldBills'])->name('show-old-bills');
    Route::get('print-old-bills', [OldBillsController::class, 'printOldBills'])->name('print-old-bills');
    
    // All routes for 
    /* 
        1- Paid Bills
        2- Due Bills
        3- Generate Monthly bills
        4- Member reports (Billing history)
    */

    Route::get('billing/get-due-bills',[BillController::class,'get_due_bills'])->name('monthlyBilling.get-due-bills');
    Route::get('billing/get-old-bills',[OldBillsController::class,'load_old_bills'])->name('monthlyBilling.get-old-bills');

    // Create and store Payment Receipts
    Route::get('billing/create-bill-receipt/{id}',[PaymentReceiptController::class,'create_bill_receipt'])->name('monthlyBilling.create-bill-receipt');
    Route::post('billing/store-bill-receipt',[PaymentReceiptController::class,'store_bill_receipt'])->name('monthlyBilling.store-bill-receipt');
    Route::get('billing/get-all-receipts',[PaymentReceiptController::class,'get_all_receipts'])->name('monthlyBilling.get-all-receipts');
    Route::get('billing/view-payment-receipt',[PaymentReceiptController::class,'view_payment_receipt'])->name('monthlyBilling.view-payment-receipt');
    Route::get('billing/download-payment-receipt',[PaymentReceiptController::class,'download_payment_receipt'])->name('monthlyBilling.download-payment-receipt');
    Route::post('paymentReceipts/media', [PaymentReceiptController::class,'storeMedia'])->name('paymentReceipts.storeMedia');
    
    Route::get('billing/create-advance-payment-receipt/',[PaymentReceiptController::class,'create_advance_payment_receipt'])->name('monthlyBilling.create-advance-payment-receipt');
    Route::post('billing/store-advance-payment-receipt',[PaymentReceiptController::class,'store_advance_payment'])->name('monthlyBilling.store-advance-payment-receipt');
    
    Route::get('billing/create-billing-section-payment-receipt/',[PaymentReceiptController::class,'create_billing_section_payment_receipt'])->name('monthlyBilling.create-billing-section-payment-receipt');
    Route::post('billing/store-billing-section-payment-receipt',[PaymentReceiptController::class,'store_billing_section_payment'])->name('monthlyBilling.store-billing-section-payment-receipt');

    
    Route::get('paymentHistory/view-payment-history-list',[PaymentHistoryController::class,'index'])->name('paymentHistory.view-payment-history-list');
    Route::get('paymentHistory/view-member-payment-history/{billing_month}/{member_id}',[PaymentHistoryController::class,'view_member_payment_history'])->name('paymentHistory.view-member-payment-history');
    
    
    Route::get('paymentSummary/view-payment-summary/', [PaymentSummaryController::class, 'view_payment_summary_list'])->name('paymentSummary.view-payment-summary');
    Route::get('billing/download-all-bills/',[BillController::class,'print_all_bills_and_download'])->name('monthlyBilling.download-all-bills');
    Route::get('billing/view-due-bill/{id}',[BillController::class,'view_due_bill'])->name('monthlyBilling.view-due-bill');
    // Room Booking Controller

    Route::get('/free-all-rooms', [RoomBookingController::class,'free_all_rooms'])->name('freeAllRooms');
    Route::get('/list-all-bookings', [RoomBookingController::class,'list_all_bookings'])->name('roomBooking.listAllBookings');
    Route::get('/book-room-by-admin',[RoomBookingController::class,'book_room_through_web'])->name('roomBooking.bookRoomManually');
    Route::post('/store-manual-room-booking',[RoomBookingController::class,'store_manual_room_booking'])->name('roomBooking.storeManualRoomBooking');
    Route::get('/search-rooms-manually',[RoomBookingController::class,'search_rooms_manually'])->name('roomBooking.searchRoomManually');
    Route::delete('room-booking/destroy/{roomBooking}', [RoomBookingController::class,'destroy'])->name('room-booking.destroy');
    Route::get('/show-booking-details/{roomBooking}', [RoomBookingController::class,'show_booking_details'])->name('roomBooking.showBooking');
    Route::get('/print-booking-details/{roomBooking}', [RoomBookingController::class,'print_booking_details'])->name('roomBooking.printBookingReceipt');
    Route::get('/print-booking-confirmation/{roomBooking}', [RoomBookingController::class,'print_booking_confirmation'])->name('roomBooking.printBookingConfirmation');
    
    // check room statuses over the dates - for admin user
    Route::get('/list-room-availability', [RoomStatusController::class,'index'])->name('roomAvailability.listRoomAvailability');
    
    // Approve booking - Step 1 - this method will open a view
    // that will show the list of rooms available for the admin to choose from
    Route::post('/approve-booking/{roomBooking}', [RoomBookingController::class,'approve_booking'])->name('roomBooking.approveBooking');
    
    // Save Room booking will save the selected room
    // against the member request
    Route::post('/save-booking/{roomBooking}', [RoomBookingController::class,'save_room_booking'])->name('roomBooking.saveBooking');
    
    Route::post('/reject-booking/{roomBooking}', [RoomBookingController::class,'reject_booking'])->name('roomBooking.rejectBooking');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 
'middleware' => ['auth','web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class]], function () {
        // Change password
        if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
            Route::get('password', [ChangePasswordController::class,'edit'])->name('password.edit');
            Route::post('password', [ChangePasswordController::class,'update'])->name('password.update');
            Route::post('profile', [ChangePasswordController::class,'updateProfile'])->name('password.updateProfile');
            Route::post('profile/destroy', [ChangePasswordController::class,'destroy'])->name('password.destroyProfile');
        }
    });