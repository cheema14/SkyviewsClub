<?php

use Spatie\Health\Http\Controllers\HealthCheckResultsController;

// use Spatie\Health\Http\Controllers\HealthCheckResultsController;
// Route::get('health', HealthCheckResultsController::class);

Route::group(['namespace' => '\Spatie\Health\Http\Controllers'],
    function () {
        Route::get('health', HealthCheckResultsController::class);
    }
);

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Designation
    Route::delete('designations/destroy', 'DesignationController@massDestroy')->name('designations.massDestroy');
    Route::post('designations/parse-csv-import', 'DesignationController@parseCsvImport')->name('designations.parseCsvImport');
    Route::post('designations/process-csv-import', 'DesignationController@processCsvImport')->name('designations.processCsvImport');
    Route::resource('designations', 'DesignationController', ['except' => ['show']]);

    // Member
    Route::delete('members/destroy', 'MemberController@massDestroy')->name('members.massDestroy');
    Route::post('members/media', 'MemberController@storeMedia')->name('members.storeMedia');
    Route::post('members/ckmedia', 'MemberController@storeCKEditorImages')->name('members.storeCKEditorImages');
    Route::post('members/parse-csv-import', 'MemberController@parseCsvImport')->name('members.parseCsvImport');
    Route::post('members/process-csv-import', 'MemberController@processCsvImport')->name('members.processCsvImport');
    Route::get('memberServing/load-serving-members', 'MemberController@loadServingMembers')->name('members.loadServingMembers');
    Route::get('members/get_member_name', 'MemberController@get_member_name')->name('membersInfo.get_member_name');
    Route::resource('members', 'MemberController');

    // Dependent
    Route::delete('dependents/destroy', 'DependentController@massdestroy')->name('dependents.massDestroy');
    Route::post('dependents/media', 'DependentController@storemedia')->name('dependents.storeMedia');
    Route::post('dependents/ckmedia', 'DependentController@storeCKEditorImages')->name('dependents.storeCKEditorImages');
    Route::post('dependents/parse-csv-import', 'DependentController@parsecsvimport')->name('dependents.parseCsvImport');
    Route::post('dependents/process-csv-import', 'DependentController@processcsvimport')->name('dependents.processCsvImport');
    //  Route::resource('dependents', 'DependentController');
    Route::get('dependents/create-dependent/{member}', 'DependentController@create')->name('dependents.create');
    Route::get('dependents/list-dependents/{member}', 'DependentController@index')->name('dependents.index');
    Route::post('dependents/store-dependents/{member}', 'DependentController@store')->name('dependents.store');
    Route::get('dependents/show-dependents/{member}', 'DependentController@show')->name('dependents.show');
    Route::delete('dependents/destroy-dependent/{dependent}', 'DependentController@destroy')->name('dependents.destroy');
    Route::get('dependents/edit-dependents/{dependent}', 'DependentController@edit')->name('dependents.edit');
    Route::put('dependents/update-dependent/{dependent}', 'DependentController@update')->name('dependents.update');
    //  Route::get('dependents/dependents/{}', 'DependentController@index')->name('dependents.index');

    // Store
    Route::delete('stores/destroy', 'StoreController@massDestroy')->name('stores.massDestroy');
    Route::post('stores/parse-csv-import', 'StoreController@parseCsvImport')->name('stores.parseCsvImport');
    Route::post('stores/process-csv-import', 'StoreController@processCsvImport')->name('stores.processCsvImport');
    Route::resource('stores', 'StoreController', ['except' => ['show']]);

    // Vendor
    Route::delete('vendors/destroy', 'VendorController@massDestroy')->name('vendors.massDestroy');
    Route::post('vendors/parse-csv-import', 'VendorController@parseCsvImport')->name('vendors.parseCsvImport');
    Route::post('vendors/process-csv-import', 'VendorController@processCsvImport')->name('vendors.processCsvImport');
    Route::resource('vendors', 'VendorController', ['except' => ['show']]);

    // Unit
    Route::delete('units/destroy', 'UnitController@massDestroy')->name('units.massDestroy');
    Route::post('units/parse-csv-import', 'UnitController@parseCsvImport')->name('units.parseCsvImport');
    Route::post('units/process-csv-import', 'UnitController@processCsvImport')->name('units.processCsvImport');
    Route::resource('units', 'UnitController', ['except' => ['show']]);

    // Item Type
    Route::delete('item-types/destroy', 'ItemTypeController@massDestroy')->name('item-types.massDestroy');
    Route::post('item-types/parse-csv-import', 'ItemTypeController@parseCsvImport')->name('item-types.parseCsvImport');
    Route::post('item-types/process-csv-import', 'ItemTypeController@processCsvImport')->name('item-types.processCsvImport');
    Route::resource('item-types', 'ItemTypeController', ['except' => ['show']]);

    // Good Receipt
    Route::delete('good-receipts/destroy', 'GoodReceiptController@massDestroy')->name('good-receipts.massDestroy');
    Route::resource('good-receipts', 'GoodReceiptController');

    // Store Item
    Route::delete('store-items/destroy', 'StoreItemController@massDestroy')->name('store-items.massDestroy');
    Route::resource('store-items', 'StoreItemController', ['except' => ['show']]);
    Route::get('store-items/get_item_by_id', 'StoreItemController@get_by_id')->name('store-items.get_by_id');

    // Stock Issue Item - When issuing items to employees, fetch the lot no
    Route::get('store-items/get-lot-no-by-items', 'StockIssueController@get_lot_no_by_items')->name('store-items.get_lot_by_item');

    // Gr Item Detail
    Route::delete('gr-item-details/destroy', 'GrItemDetailController@massDestroy')->name('gr-item-details.massDestroy');
    Route::resource('gr-item-details', 'GrItemDetailController');

    // Department
    Route::delete('departments/destroy', 'DepartmentController@massDestroy')->name('departments.massDestroy');
    Route::post('departments/parse-csv-import', 'DepartmentController@parseCsvImport')->name('departments.parseCsvImport');
    Route::post('departments/process-csv-import', 'DepartmentController@processCsvImport')->name('departments.processCsvImport');
    Route::resource('departments', 'DepartmentController', ['except' => ['show']]);

    // Membership Category
    Route::delete('membership-categories/destroy', 'MembershipCategoryController@massDestroy')->name('membership-categories.massDestroy');
    Route::post('membership-categories/parse-csv-import', 'MembershipCategoryController@parseCsvImport')->name('membership-categories.parseCsvImport');
    Route::post('membership-categories/process-csv-import', 'MembershipCategoryController@processCsvImport')->name('membership-categories.processCsvImport');
    Route::resource('membership-categories', 'MembershipCategoryController', ['except' => ['show']]);

    // Membership Type
    Route::delete('membership-types/destroy', 'MembershipTypeController@massDestroy')->name('membership-types.massDestroy');
    Route::post('membership-types/parse-csv-import', 'MembershipTypeController@parseCsvImport')->name('membership-types.parseCsvImport');
    Route::post('membership-types/process-csv-import', 'MembershipTypeController@processCsvImport')->name('membership-types.processCsvImport');
    Route::resource('membership-types', 'MembershipTypeController', ['except' => ['show']]);
    Route::post('get-membership-fees', 'MembershipTypeController@get_membership_fees')->name('membership-types.get-membership-fees');

    // Gr Item Detail
    Route::delete('gr-item-details/destroy', 'GrItemDetailController@massDestroy')->name('gr-item-details.massDestroy');
    Route::resource('gr-item-details', 'GrItemDetailController');

    // Section
    Route::delete('sections/destroy', 'SectionController@massDestroy')->name('sections.massDestroy');
    Route::post('sections/parse-csv-import', 'SectionController@parseCsvImport')->name('sections.parseCsvImport');
    Route::post('sections/process-csv-import', 'SectionController@processCsvImport')->name('sections.processCsvImport');
    Route::resource('sections', 'SectionController');

    // Employee
    Route::delete('employees/destroy', 'EmployeeController@massDestroy')->name('employees.massDestroy');
    Route::resource('employees', 'EmployeeController');
    Route::post('employees/parse-csv-import', 'EmployeeController@parseCsvImport')->name('employees.parseCsvImport');
    Route::post('employees/process-csv-import', 'EmployeeController@processCsvImport')->name('employees.processCsvImport');

    // Stock Issue
    Route::delete('stock-issues/destroy', 'StockIssueController@massDestroy')->name('stock-issues.massDestroy');
    Route::resource('stock-issues', 'StockIssueController');

    // Stock Issue Item
    Route::delete('stock-issue-items/destroy', 'StockIssueItemController@massDestroy')->name('stock-issue-items.massDestroy');
    Route::resource('stock-issue-items', 'StockIssueItemController');

    // Menu
    Route::delete('menus/destroy', 'MenuController@massDestroy')->name('menus.massDestroy');
    Route::resource('menus', 'MenuController');

    // Menu Item Category
    Route::delete('menu-item-categories/destroy', 'MenuItemCategoryController@massDestroy')->name('menu-item-categories.massDestroy');
    Route::resource('menu-item-categories', 'MenuItemCategoryController');

    // Item

    Route::get('items/item', 'ItemController@getItemById')->name('items.getById');
    Route::get('items/itemByMenu', 'ItemController@getItemByMenu')->name('items.getItemByMenu');
    Route::delete('items/destroy', 'ItemController@massDestroy')->name('items.massDestroy');
    Route::post('items/parse-csv-import', 'ItemController@parseCsvImport')->name('items.parseCsvImport');
    Route::post('items/process-csv-import', 'ItemController@processCsvImport')->name('items.processCsvImport');
    Route::resource('items', 'ItemController');

    // Table Top
    Route::delete('table-tops/destroy', 'TableTopController@massDestroy')->name('table-tops.massDestroy');
    Route::resource('table-tops', 'TableTopController');

    // Order
    Route::delete('orders/destroy', 'OrderController@massDestroy')->name('orders.massDestroy');
    Route::resource('orders', 'OrderController');

    // Order Item
    Route::delete('order-items/destroy', 'OrderItemController@massDestroy')->name('order-items.massDestroy');
    Route::resource('order-items', 'OrderItemController');

    // Transaction
    Route::delete('transactions/destroy', 'TransactionController@massDestroy')->name('transactions.massDestroy');
    Route::resource('transactions', 'TransactionController');

    // Bills
    Route::get('monthly-bill', 'BillController@index')->name('monthly-bill');
    Route::get('view-monthly-bill/{member}', 'ViewBillController@index')->name('view-monthly-bill');
    Route::get('print-kitchen-receipt/{order}', 'KitchenReceiptController@index')->name('print-kitchen-receipt');
    Route::get('print-order-receipt/{order}', 'GenerateBillController@index')->name('print-order-receipt');

    // Print Customer Bill
    Route::get('print-customer-bill/{order}', 'GenerateBillController@generate_customer_bill')->name('print-customer-bill');

    // Cash Receipt route
    Route::get('cash-receipt/{order}', 'CashReceiptController@create_cash_receipt')->name('cash-receipt');
    Route::post('store-cash-receipt/{order}', 'CashReceiptController@store_receipt')->name('store-receipt');

    // Test escpos printer
    Route::get('test-printer', 'ViewBillController@print_receipt')->name('test-printer');

    Route::get('assign-memberships', 'AssignMembership')->name('assign-membership');

    // Item Class
    Route::delete('item-classes/destroy', 'ItemClassController@massDestroy')->name('item-classes.massDestroy');
    Route::post('item-classes/parse-csv-import', 'ItemClassController@parseCsvImport')->name('item-classes.parseCsvImport');
    Route::post('item-classes/process-csv-import', 'ItemClassController@processCsvImport')->name('item-classes.processCsvImport');
    Route::resource('item-classes', 'ItemClassController', ['except' => ['show']]);
    Route::get('item-classes/get_by_item_class_id', 'ItemClassController@get_by_item_type')->name('item-classes.get_by_item_type');

    // Sports Division
    Route::delete('sports-divisions/destroy', 'SportsDivisionController@massDestroy')->name('sports-divisions.massDestroy');
    Route::resource('sports-divisions', 'SportsDivisionController');

    // Sport Item Type
    Route::delete('sport-item-types/destroy', 'SportItemTypeController@massDestroy')->name('sport-item-types.massDestroy');
    Route::resource('sport-item-types', 'SportItemTypeController');

    // Sport Item Class
    Route::delete('sport-item-classes/destroy', 'SportItemClassController@massDestroy')->name('sport-item-classes.massDestroy');
    Route::resource('sport-item-classes', 'SportItemClassController');

    // Sport Item Name
    Route::delete('sport-item-names/destroy', 'SportItemNameController@massDestroy')->name('sport-item-names.massDestroy');
    Route::resource('sport-item-names', 'SportItemNameController');

    // Sports Billing
    Route::delete('sports-billings/destroy', 'SportsBillingController@massDestroy')->name('sports-billings.massDestroy');
    Route::resource('sports-billings', 'SportsBillingController');

    Route::get('print-sports-bill/{sportsBilling}', 'SportsBillingController@print_sports_bill')->name('sports-billings.printBill');

    // Sport Billing Item
    Route::delete('sport-billing-items/destroy', 'SportBillingItemController@massDestroy')->name('sport-billing-items.massDestroy');
    Route::resource('sport-billing-items', 'SportBillingItemController');

    // Sports Add - Fetch relevant items (division,item type, item class and item names)

    Route::get('sports-items/get_sports_item_type', 'SportsBillingController@get_sports_item_type')->name('sports-items.get_sports_item_type');
    Route::get('sports-items/get_sports_classes', 'SportsBillingController@get_sports_classes')->name('sports-items.get_sports_classes');
    Route::get('sports-items/get_sports_items', 'SportsBillingController@get_sports_items')->name('sports-items.get_sports_items');
    Route::get('sports-items/get_item_details', 'SportsBillingController@get_item_details')->name('sports-items.get_item_details');


    // All routes for 
    /* 
        1- Paid Bills
        2- Due Bills
        3- Generate Monthly bills
        4- Member reports (Billing history)
    */
    Route::get('billing/get-due-bills','BillController@get_due_bills')->name('monthlyBilling.get-due-bills');
    
    // view due bill gets an id passed as query parameter - its the member ID
    // Same goes for the print due bill route as well
    
    Route::get('billing/view-due-bill/{id}','BillController@view_due_bill')->name('monthlyBilling.view-due-bill');
    
    // Create and Save bill receipt
    Route::get('billing/create-bill-receipt/{id}','PaymentReceiptController@create_bill_receipt')->name('monthlyBilling.create-bill-receipt');
    Route::post('billing/store-bill-receipt','PaymentReceiptController@store_bill_receipt')->name('monthlyBilling.store-bill-receipt');
    Route::get('billing/get-all-receipts','PaymentReceiptController@get_all_receipts')->name('monthlyBilling.get-all-receipts');
    Route::get('billing/view-payment-receipt','PaymentReceiptController@view_payment_receipt')->name('monthlyBilling.view-payment-receipt');
    Route::get('billing/download-payment-receipt','PaymentReceiptController@download_payment_receipt')->name('monthlyBilling.download-payment-receipt');
    Route::post('paymentReceipts/media', 'PaymentReceiptController@storeMedia')->name('paymentReceipts.storeMedia');
    
    // Payment History
    Route::get('paymentHistory/view-payment-history-list','PaymentHistoryController@index')->name('paymentHistory.view-payment-history-list');
    Route::get('paymentHistory/view-member-payment-history/{billing_month}/{member_id}','PaymentHistoryController@view_member_payment_history')->name('paymentHistory.view-member-payment-history');
    
    // Download all bills
    Route::get('billing/download-all-bills/','BillController@print_all_bills_and_download')->name('monthlyBilling.download-all-bills');


    // Employee summary
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
