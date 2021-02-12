<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::group(['prefix' => 'open'], function () {
    Route::get('/city', 'OpenController@city');

    Route::get('/forgot/pin/{id}', 'OpenController@forgotPin');
    Route::post('/forgot/pin/{id}', 'OpenController@forgotPin');
    Route::get('/confirm/mail/{user_uuid}', 'OpenController@getConfirmMail');
    Route::get('/cron', 'OpenController@cron');

});


Route::group(['middleware' => ['auth', 'ajax-session-expired']], function () {
    Route::get('/', function () {
        return redirect('/dashboard');
        return view('index');
    });
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/chat-room', 'ChatRoomController@index');

    Route::group(['prefix' => 'master', 'namespace' => 'Master'], function () {
        Route::group(['prefix' => 'loan-purpose'], function () {
            Route::get('/', 'LoanPurposeController@index');
            Route::get('/create', 'LoanPurposeController@create');
            Route::get('/edit/{uuid}', 'LoanPurposeController@edit');
            Route::post('/save', 'LoanPurposeController@save');
            Route::delete('/delete/{uuid}', 'LoanPurposeController@delete');
            Route::get('/data-table', 'LoanPurposeController@dataTable');
        });
        Route::group(['prefix' => 'partner'], function () {
            Route::get('/', 'KoperasiController@index');
            Route::get('/create', 'KoperasiController@create');
            Route::get('/edit/{uuid}', 'KoperasiController@edit');
            Route::post('/save', 'KoperasiController@save');
            Route::delete('/delete/{uuid}', 'KoperasiController@delete');
            Route::get('/data-table', 'KoperasiController@dataTable');

            Route::get('/cities', 'KoperasiController@getCities');
            Route::get('/subdistrict', 'KoperasiController@getSubdistrict');
        });

        Route::group(['prefix' => 'internal-variable'], function () {
            Route::get('/', 'InternalVariableController@index');

            Route::group(['prefix' => 'create'], function () {
                Route::get('/admin-fee', 'InternalVariableController@createAdminFee');
                Route::get('/age', 'InternalVariableController@createAge');
                Route::get('/cities', 'InternalVariableController@createCities');
                Route::get('/income', 'InternalVariableController@createIncome');
                Route::get('/suspends', 'InternalVariableController@createSuspends');
            });

            Route::group(['prefix' => 'edit'], function () {
                Route::get('/admin-fee/{uuid}', 'InternalVariableController@editAdminFee');
                Route::get('/age/{uuid}', 'InternalVariableController@editAge');
                Route::get('/cities/{uuid}', 'InternalVariableController@editCities');
                Route::get('/income/{uuid}', 'InternalVariableController@editIncome');
                Route::get('/suspends/{uuid}', 'InternalVariableController@editSuspends');
            });

            Route::group(['prefix' => 'save'], function () {
                Route::post('/admin-fee', 'InternalVariableController@saveAdminFee');
                Route::post('/age', 'InternalVariableController@saveAge');
                Route::post('/cities', 'InternalVariableController@saveCities');
                Route::post('/income', 'InternalVariableController@saveIncome');
                Route::post('/suspends', 'InternalVariableController@saveSuspends');
            });
            Route::group(['prefix' => 'data-table'], function () {
                Route::get('/admin-fee', 'InternalVariableController@datatableAdminFee');
                Route::get('/age', 'InternalVariableController@datatableAge');
                Route::get('/cities', 'InternalVariableController@datatableCities');
                Route::get('/income', 'InternalVariableController@datatableIncome');
                Route::get('/suspends', 'InternalVariableController@datatableSuspends');
            });
            Route::group(['prefix' => 'delete'], function () {
                Route::delete('/admin-fee/{uuid}', 'InternalVariableController@deleteAdminFee');
                Route::delete('/age/{uuid}', 'InternalVariableController@deleteAge');
                Route::delete('/cities/{uuid}', 'InternalVariableController@deleteCities');
                Route::delete('/income/{uuid}', 'InternalVariableController@deleteIncome');
                Route::delete('/suspends/{uuid}', 'InternalVariableController@deleteSuspends');
            });

        });
    });

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::group(['prefix' => 'role'], function () {
            Route::get('/', 'RoleController@index');
            Route::get('/create', 'RoleController@create');
            Route::get('/edit/{id}', 'RoleController@edit');
            Route::post('/save', 'RoleController@save');
            Route::get('/data-table', 'RoleController@dataTable');
            Route::delete('/delete/{id}', 'RoleController@delete');
        });
        Route::group(['prefix' => 'administrator'], function () {
            Route::get('/', 'AdministratorController@index');
            Route::get('/create', 'AdministratorController@create');
            Route::get('/edit/{id}', 'AdministratorController@edit');
            Route::post('/save', 'AdministratorController@save');
            Route::get('/data-table', 'AdministratorController@dataTable');
            Route::delete('/delete/{id}', 'AdministratorController@delete');
        });
    });

    Route::group(['prefix' => 'partner', 'namespace' => 'Koperasi'], function () {
        Route::group(['prefix' => 'admin'], function () {
            Route::get('/', 'AdminController@index');
            Route::get('/create', 'AdminController@create');
            Route::get('/edit/{id}', 'AdminController@edit');
            Route::post('/save', 'AdminController@save');
            Route::get('/data-table', 'AdminController@dataTable');
            Route::delete('/delete/{id}', 'AdminController@delete');
        });
        Route::group(['prefix' => 'member'], function () {
            Route::get('/', 'MemberController@index');
            Route::get('/create', 'MemberController@create');
            Route::get('/edit/{id}', 'MemberController@edit');
            Route::post('/save', 'MemberController@save');
            Route::get('/data-table', 'MemberController@dataTable');
            Route::delete('/delete/{id}', 'MemberController@delete');
        });
        Route::group(['prefix' => 'money-invest'], function () {
            Route::get('/', 'MoneyInvestController@index');
            Route::get('/create', 'MoneyInvestController@create');
            Route::get('/edit/{id}', 'MoneyInvestController@edit');
            Route::post('/save', 'MoneyInvestController@save');
            Route::get('/data-table', 'MoneyInvestController@dataTable');
            Route::delete('/delete/{id}', 'MoneyInvestController@delete');
        });
    });
    Route::group(['prefix' => 'customers', 'namespace' => 'Customers'], function () {
        Route::group(['prefix' => 'list'], function () {
            Route::get('/', 'ListController@index');
            Route::get('/detail/{uuid}', 'ListController@detail');
            Route::get('/data-table', 'ListController@dataTable');
            Route::post('/save', 'ListController@save');
        });
        Route::group(['prefix' => 'new'], function () {
            Route::get('/', 'NewController@index');
            Route::get('/data-table', 'NewController@dataTable');
            Route::get('/approval/{uuid}', 'NewController@approval');
            Route::post('/save', 'NewController@save');
        });
    });
    Route::group(['prefix' => 'loan-transaction', 'namespace' => 'LoanTransaction'], function () {
        Route::group(['prefix' => 'invoice-payment'], function () {
            Route::get('/', 'InvoicePaymentController@index');
            Route::get('/data-table', 'InvoicePaymentController@dataTable');
            Route::get('/detail/{uuid}', 'InvoicePaymentController@detail');
        });
        Route::group(['prefix' => 'transaction'], function () {
            Route::get('/', 'TransactionController@index');
            Route::get('/data-table', 'TransactionController@dataTable');
            Route::get('/detail/{uuid}', 'TransactionController@detail');
            Route::post('/save', 'TransactionController@save');
        });
        Route::group(['prefix' => 'complain'], function () {
            Route::get('/', 'ComplainController@index');
            Route::get('/data-table', 'ComplainController@dataTable');
        });
    });
    Route::group(['prefix' => 'product-loan', 'namespace' => 'ProductLoan'], function () {
        Route::group(['prefix' => 'interest'], function () {
            Route::get('/', 'InterestController@index');
            Route::get('/create', 'InterestController@create');
            Route::get('/edit/{uuid}', 'InterestController@edit');
            Route::post('/save', 'InterestController@save');
            Route::delete('/delete/{uuid}', 'InterestController@delete');
            Route::get('/data-table', 'InterestController@dataTable');
        });

        Route::group(['prefix' => 'fine'], function () {
            Route::get('/', 'FineController@index');
            Route::get('/create', 'FineController@create');
            Route::get('/edit/{uuid}', 'FineController@edit');
            Route::post('/save', 'FineController@save');
            Route::delete('/delete/{uuid}', 'FineController@delete');
            Route::get('/data-table', 'FineController@dataTable');
        });

        Route::group(['prefix' => 'coupon'], function () {
            Route::get('/', 'CouponController@index');
            Route::get('/create', 'CouponController@create');
            Route::get('/edit/{uuid}', 'CouponController@edit');
            Route::post('/save', 'CouponController@save');
            Route::delete('/delete/{uuid}', 'CouponController@delete');
            Route::get('/data-table', 'CouponController@dataTable');
        });

        Route::group(['prefix' => 'product-category'], function () {
            Route::get('/', 'ProductCategoryController@index');
            Route::get('/create', 'ProductCategoryController@create');
            Route::get('/edit/{uuid}', 'ProductCategoryController@edit');
            Route::post('/save', 'ProductCategoryController@save');
            Route::delete('/delete/{uuid}', 'ProductCategoryController@delete');
            Route::get('/data-table', 'ProductCategoryController@dataTable');
        });
        Route::group(['prefix' => 'product'], function () {
            Route::get('/', 'ProductController@index');
            Route::get('/create', 'ProductController@create');
            Route::get('/edit/{uuid}', 'ProductController@edit');
            Route::post('/save', 'ProductController@save');
            Route::delete('/delete/{uuid}', 'ProductController@delete');
            Route::get('/data-table', 'ProductController@dataTable');
        });
        Route::group(['prefix' => 'product-item'], function () {
            Route::get('/', 'ProductItemController@index');
            Route::get('/create', 'ProductItemController@create');
            Route::get('/edit/{uuid}', 'ProductItemController@edit');
            Route::post('/save', 'ProductItemController@save');
            Route::delete('/delete/{uuid}', 'ProductItemController@delete');
            Route::get('/card', 'ProductItemController@card');
            Route::get('/item', 'ProductItemController@item');
            Route::get('/detail/{uuid}', 'ProductItemController@detail');
            Route::get('/edit/{uuid}', 'ProductItemController@edit');
            Route::get('/product-item-image/{uuid}', 'ProductItemController@productItemImage');
            Route::delete('/product-item-image/{uuid}', 'ProductItemController@productItemImageDelete');
            Route::get('/data-table', 'ProductItemController@dataTable');
        });
    });

    Route::group(['prefix' => 'settings', 'namespace' => 'Settings'], function () {
        Route::group(['prefix' => 'history'], function () {
            Route::get('/', 'HistoryController@index');
            Route::get('/data-table', 'HistoryController@dataTable');
        });
        Route::group(['prefix' => 'banner'], function () {
            Route::get('/', 'BannerController@index');
            Route::get('/create', 'BannerController@create');
            Route::get('/edit/{uuid}', 'BannerController@edit');
            Route::post('/save', 'BannerController@save');
            Route::delete('/delete/{uuid}', 'BannerController@delete');
            Route::get('/data-table', 'BannerController@dataTable');
        });

        Route::group(['prefix' => 'app-version'], function () {
            Route::get('/', 'AppVersionController@index');
            Route::get('/create', 'AppVersionController@create');
            Route::get('/edit/{uuid}', 'AppVersionController@edit');
            Route::post('/save', 'AppVersionController@save');
            Route::delete('/delete/{uuid}', 'AppVersionController@delete');
            Route::get('/data-table', 'AppVersionController@dataTable');
        });

        Route::group(['prefix' => 'faq'], function () {
            Route::get('/', 'FaqController@index');
            Route::post('/save', 'FaqController@save');
        });
        Route::group(['prefix' => 'tnc'], function () {
            Route::get('/', 'TncController@index');
            Route::post('/save', 'TncController@save');
        });
        Route::group(['prefix' => 'privacy-policy'], function () {
            Route::get('/', 'PrivacyPolicyController@index');
            Route::post('/save', 'PrivacyPolicyController@save');
        });
        Route::group(['prefix' => 'about-us'], function () {
            Route::get('/', 'AboutUsController@index');
            Route::post('/save', 'AboutUsController@save');
        });
        Route::group(['prefix' => 'contact-info'], function () {
            Route::get('/', 'ContactInfoController@index');
            Route::post('/save', 'ContactInfoController@save');
        });
    });
});
