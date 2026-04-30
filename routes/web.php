<?php
use App\Http\Controllers\apps\Chat;
use App\Http\Controllers\pages\Faq;
use App\Http\Controllers\apps\Email;
use App\Http\Controllers\apps\Kanban;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\maps\Leaflet;
use App\Http\Controllers\admin\Reports;
use App\Http\Controllers\apps\Calendar;
use App\Http\Controllers\apps\UserList;
use App\Http\Controllers\dashboard\Crm;
use App\Http\Controllers\icons\RiIcons;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\charts\ChartJs;
use App\Http\Controllers\apps\InvoiceAdd;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\UserTeams;
use App\Http\Controllers\apps\AccessRoles;
use App\Http\Controllers\apps\InvoiceEdit;
use App\Http\Controllers\apps\InvoiceList;
use App\Http\Controllers\extended_ui\Misc;
use App\Http\Controllers\extended_ui\Tour;
use App\Http\Controllers\layouts\Vertical;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\apps\InvoicePrint;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\cards\CardActions;
use App\Http\Controllers\cards\CardAdvance;
use App\Http\Controllers\charts\ApexCharts;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\pages\UserProfile;
use App\Http\Controllers\admin\OrderMonitor;
use App\Http\Controllers\apps\AcademyCourse;
use App\Http\Controllers\extended_ui\Avatar;
use App\Http\Controllers\layouts\Horizontal;
use App\Http\Controllers\modal\ModalExample;
use App\Http\Controllers\pages\UserProjects;
use App\Http\Controllers\apps\InvoicePreview;
use App\Http\Controllers\apps\LogisticsFleet;
use App\Http\Controllers\cards\CardAnalytics;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\extended_ui\BlockUI;
use App\Http\Controllers\front_pages\Landing;
use App\Http\Controllers\front_pages\Payment;
use App\Http\Controllers\front_pages\Pricing;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\admin\AdminDashboard;
use App\Http\Controllers\admin\ReviewsMonitor;
use App\Http\Controllers\apps\UserViewAccount;
use App\Http\Controllers\apps\UserViewBilling;
use App\Http\Controllers\cards\CardStatistics;
use App\Http\Controllers\extended_ui\Treeview;
use App\Http\Controllers\form_elements\Extras;
use App\Http\Controllers\form_elements\Picker;
use App\Http\Controllers\front_pages\Checkout;
use App\Http\Controllers\pages\MiscComingSoon;
use App\Http\Controllers\apps\AcademyDashboard;
use App\Http\Controllers\apps\AccessPermission;
use App\Http\Controllers\apps\UserViewSecurity;
use App\Http\Controllers\form_elements\Editors;
use App\Http\Controllers\form_elements\Selects;
use App\Http\Controllers\form_elements\Sliders;
use App\Http\Controllers\GeneralUSerController;
use App\Http\Controllers\layouts\CollapsedMenu;
use App\Http\Controllers\layouts\ContentNavbar;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\pages\MiscServerError;
use App\Http\Controllers\pages\UserConnections;
use App\Http\Controllers\tables\DatatableBasic;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\extended_ui\SweetAlert;
use App\Http\Controllers\form_elements\Switches;
use App\Http\Controllers\front_pages\HelpCenter;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\admin\ArtsnVerification;
use App\Http\Controllers\apps\EcommerceDashboard;
use App\Http\Controllers\apps\EcommerceOrderList;
use App\Http\Controllers\apps\EcommerceReferrals;
use App\Http\Controllers\apps\LogisticsDashboard;
use App\Http\Controllers\cards\CardGamifications;
use App\Http\Controllers\extended_ui\DragAndDrop;
use App\Http\Controllers\extended_ui\MediaPlayer;
use App\Http\Controllers\extended_ui\StarRatings;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\pages\MiscNotAuthorized;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\apps\EcommerceProductAdd;
use App\Http\Controllers\apps\UserViewConnections;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\FileUpload;
use App\Http\Controllers\tables\DatatableAdvanced;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\apps\AcademyCourseDetails;
use App\Http\Controllers\apps\EcommerceCustomerAll;
use App\Http\Controllers\apps\EcommerceProductList;
use App\Http\Controllers\extended_ui\TimelineBasic;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\layouts\ContentNavSidebar;
use App\Http\Controllers\pages\Pricing as PagesPricing;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\wizard_example\CreateDeal;
use App\Http\Controllers\apps\EcommerceOrderDetails;
use App\Http\Controllers\apps\UserViewNotifications;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\LoginCover;
use App\Http\Controllers\form_layouts\StickyActions;
use App\Http\Controllers\form_validation\Validation;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\tables\DatatableExtensions;
use App\Http\Controllers\apps\EcommerceManageReviews;
use App\Http\Controllers\form_elements\CustomOptions;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsBilling;
use App\Http\Controllers\apps\EcommerceProductCategory;
use App\Http\Controllers\apps\EcommerceSettingsDetails;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\RegisterCover;
use App\Http\Controllers\authentications\TwoStepsBasic;
use App\Http\Controllers\authentications\TwoStepsCover;
use App\Http\Controllers\front_pages\HelpCenterArticle;
use App\Http\Controllers\pages\AccountSettingsSecurity;
use App\Http\Controllers\apps\EcommerceSettingsCheckout;
use App\Http\Controllers\apps\EcommerceSettingsPayments;
use App\Http\Controllers\apps\EcommerceSettingsShipping;
use App\Http\Controllers\extended_ui\TimelineFullscreen;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\wizard_example\PropertyListing;
use App\Http\Controllers\apps\EcommerceSettingsLocations;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\authentications\VerifyEmailBasic;
use App\Http\Controllers\authentications\VerifyEmailCover;
use App\Http\Controllers\form_wizard\Icons as FormWizardIcons;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\authentications\RegisterMultiSteps;
use App\Http\Controllers\authentications\ResetPasswordBasic;
use App\Http\Controllers\authentications\ResetPasswordCover;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\apps\EcommerceSettingsNotifications;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\authentications\ForgotPasswordCover;
use App\Http\Controllers\apps\EcommerceCustomerDetailsBilling;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\apps\EcommerceCustomerDetailsOverview;
use App\Http\Controllers\apps\EcommerceCustomerDetailsSecurity;
use App\Http\Controllers\wizard_example\Checkout as WizardCheckout;
use App\Http\Controllers\form_wizard\Numbered as FormWizardNumbered;
use App\Http\Controllers\admin\UserManagement as AdminUserManagement;
use App\Http\Controllers\apps\EcommerceCustomerDetailsNotifications;

// Main Page Route - Redirect to login if not authenticated
Route::get('/', function () {
  if (auth()->check()) {
    return redirect()->route('dashboard-analytics');
  }
  return redirect()->route('auth-login-cover');
});

Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard-analytics');
  Route::get('/dashboard/crm', [Crm::class, 'index'])->name('dashboard-crm');
});
// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);

// layout
Route::get('/layouts/collapsed-menu', [CollapsedMenu::class, 'index'])->name('layouts-collapsed-menu');
Route::get('/layouts/content-navbar', [ContentNavbar::class, 'index'])->name('layouts-content-navbar');
Route::get('/layouts/content-nav-sidebar', [ContentNavSidebar::class, 'index'])->name('layouts-content-nav-sidebar');
Route::get('/layouts/horizontal', [Horizontal::class, 'index'])->name('dashboard-analytics');
Route::get('/layouts/vertical', [Vertical::class, 'index'])->name('dashboard-analytics');
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// Front Pages
Route::get('/front-pages/landing', [Landing::class, 'index'])->name('front-pages-landing');
Route::get('/front-pages/pricing', [Pricing::class, 'index'])->name('front-pages-pricing');
Route::get('/front-pages/payment', [Payment::class, 'index'])->name('front-pages-payment');
Route::get('/front-pages/checkout', [Checkout::class, 'index'])->name('front-pages-checkout');
Route::get('/front-pages/help-center', [HelpCenter::class, 'index'])->name('front-pages-help-center');
Route::get('/front-pages/help-center-article', [HelpCenterArticle::class, 'index'])->name('front-pages-help-center-article');

// apps
Route::get('/app/email', [Email::class, 'index'])->name('app-email');
Route::get('/app/chat', [Chat::class, 'index'])->name('app-chat');
Route::get('/app/calendar', [Calendar::class, 'index'])->name('app-calendar');
Route::get('/app/kanban', [Kanban::class, 'index'])->name('app-kanban');
Route::get('/app/ecommerce/dashboard', [EcommerceDashboard::class, 'index'])->name('app-ecommerce-dashboard');
Route::get('/app/ecommerce/product/list', [EcommerceProductList::class, 'index'])->name('app-ecommerce-product-list');
Route::get('/app/ecommerce/product/add', [EcommerceProductAdd::class, 'index'])->name('app-ecommerce-product-add');
Route::get('/app/ecommerce/product/category', [EcommerceProductCategory::class, 'index'])->name('app-ecommerce-product-category');
Route::get('/app/ecommerce/order/list', [EcommerceOrderList::class, 'index'])->name('app-ecommerce-order-list');
Route::get('/app/ecommerce/order/details', [EcommerceOrderDetails::class, 'index'])->name('app-ecommerce-order-details');
Route::get('/app/ecommerce/customer/all', [EcommerceCustomerAll::class, 'index'])->name('app-ecommerce-customer-all');
Route::get('/app/ecommerce/customer/details/overview', [EcommerceCustomerDetailsOverview::class, 'index'])->name('app-ecommerce-customer-details-overview');
Route::get('/app/ecommerce/customer/details/security', [EcommerceCustomerDetailsSecurity::class, 'index'])->name('app-ecommerce-customer-details-security');
Route::get('/app/ecommerce/customer/details/billing', [EcommerceCustomerDetailsBilling::class, 'index'])->name('app-ecommerce-customer-details-billing');
Route::get('/app/ecommerce/customer/details/notifications', [EcommerceCustomerDetailsNotifications::class, 'index'])->name('app-ecommerce-customer-details-notifications');
Route::get('/app/ecommerce/manage/reviews', [EcommerceManageReviews::class, 'index'])->name('app-ecommerce-manage-reviews');
Route::get('/app/ecommerce/referrals', [EcommerceReferrals::class, 'index'])->name('app-ecommerce-referrals');
Route::get('/app/ecommerce/settings/details', [EcommerceSettingsDetails::class, 'index'])->name('app-ecommerce-settings-details');
Route::get('/app/ecommerce/settings/payments', [EcommerceSettingsPayments::class, 'index'])->name('app-ecommerce-settings-payments');
Route::get('/app/ecommerce/settings/checkout', [EcommerceSettingsCheckout::class, 'index'])->name('app-ecommerce-settings-checkout');
Route::get('/app/ecommerce/settings/shipping', [EcommerceSettingsShipping::class, 'index'])->name('app-ecommerce-settings-shipping');
Route::get('/app/ecommerce/settings/locations', [EcommerceSettingsLocations::class, 'index'])->name('app-ecommerce-settings-locations');
Route::get('/app/ecommerce/settings/notifications', [EcommerceSettingsNotifications::class, 'index'])->name('app-ecommerce-settings-notifications');
Route::get('/app/academy/dashboard', [AcademyDashboard::class, 'index'])->name('app-academy-dashboard');
Route::get('/app/academy/course', [AcademyCourse::class, 'index'])->name('app-academy-course');
Route::get('/app/academy/course-details', [AcademyCourseDetails::class, 'index'])->name('app-academy-course-details');
Route::get('/app/logistics/dashboard', [LogisticsDashboard::class, 'index'])->name('app-logistics-dashboard');
Route::get('/app/logistics/fleet', [LogisticsFleet::class, 'index'])->name('app-logistics-fleet');
Route::get('/app/invoice/list', [InvoiceList::class, 'index'])->name('app-invoice-list');
Route::get('/app/invoice/preview', [InvoicePreview::class, 'index'])->name('app-invoice-preview');
Route::get('/app/invoice/print', [InvoicePrint::class, 'index'])->name('app-invoice-print');
Route::get('/app/invoice/edit', [InvoiceEdit::class, 'index'])->name('app-invoice-edit');
Route::get('/app/invoice/add', [InvoiceAdd::class, 'index'])->name('app-invoice-add');
Route::get('/app/user/list', [UserList::class, 'index'])->name('app-user-list');
Route::get('/app/user/view/account', [UserViewAccount::class, 'index'])->name('app-user-view-account');
Route::get('/app/user/view/security', [UserViewSecurity::class, 'index'])->name('app-user-view-security');
Route::get('/app/user/view/billing', [UserViewBilling::class, 'index'])->name('app-user-view-billing');
Route::get('/app/user/view/notifications', [UserViewNotifications::class, 'index'])->name('app-user-view-notifications');
Route::get('/app/user/view/connections', [UserViewConnections::class, 'index'])->name('app-user-view-connections');
Route::get('/app/access-roles', [AccessRoles::class, 'index'])->name('app-access-roles');
Route::get('/app/access-permission', [AccessPermission::class, 'index'])->name('app-access-permission');

// pages
Route::get('/pages/profile-user', [UserProfile::class, 'index'])->name('pages-profile-user');
Route::get('/pages/profile-teams', [UserTeams::class, 'index'])->name('pages-profile-teams');
Route::get('/pages/profile-projects', [UserProjects::class, 'index'])->name('pages-profile-projects');
Route::get('/pages/profile-connections', [UserConnections::class, 'index'])->name('pages-profile-connections');
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-security', [AccountSettingsSecurity::class, 'index'])->name('pages-account-settings-security');
Route::get('/pages/account-settings-billing', [AccountSettingsBilling::class, 'index'])->name('pages-account-settings-billing');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/faq', [Faq::class, 'index'])->name('pages-faq');
Route::get('/pages/pricing', [PagesPricing::class, 'index'])->name('pages-pricing');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
Route::get('/pages/misc-comingsoon', [MiscComingSoon::class, 'index'])->name('pages-misc-comingsoon');
Route::get('/pages/misc-not-authorized', [MiscNotAuthorized::class, 'index'])->name('pages-misc-not-authorized');
Route::get('/pages/misc-server-error', [MiscServerError::class, 'index'])->name('pages-misc-server-error');



// wizard example
Route::get('/wizard/ex-checkout', [WizardCheckout::class, 'index'])->name('wizard-ex-checkout');
Route::get('/wizard/ex-property-listing', [PropertyListing::class, 'index'])->name('wizard-ex-property-listing');
Route::get('/wizard/ex-create-deal', [CreateDeal::class, 'index'])->name('wizard-ex-create-deal');

// modal
Route::get('/modal-examples', [ModalExample::class, 'index'])->name('modal-examples');

// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');
Route::get('/cards/advance', [CardAdvance::class, 'index'])->name('cards-advance');
Route::get('/cards/statistics', [CardStatistics::class, 'index'])->name('cards-statistics');
Route::get('/cards/analytics', [CardAnalytics::class, 'index'])->name('cards-analytics');
Route::get('/cards/gamifications', [CardGamifications::class, 'index'])->name('cards-gamifications');
Route::get('/cards/actions', [CardActions::class, 'index'])->name('cards-actions');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-avatar', [Avatar::class, 'index'])->name('extended-ui-avatar');
Route::get('/extended/ui-blockui', [BlockUI::class, 'index'])->name('extended-ui-blockui');
Route::get('/extended/ui-drag-and-drop', [DragAndDrop::class, 'index'])->name('extended-ui-drag-and-drop');
Route::get('/extended/ui-media-player', [MediaPlayer::class, 'index'])->name('extended-ui-media-player');
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-star-ratings', [StarRatings::class, 'index'])->name('extended-ui-star-ratings');
Route::get('/extended/ui-sweetalert2', [SweetAlert::class, 'index'])->name('extended-ui-sweetalert2');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');
Route::get('/extended/ui-timeline-basic', [TimelineBasic::class, 'index'])->name('extended-ui-timeline-basic');
Route::get('/extended/ui-timeline-fullscreen', [TimelineFullscreen::class, 'index'])->name('extended-ui-timeline-fullscreen');
Route::get('/extended/ui-tour', [Tour::class, 'index'])->name('extended-ui-tour');
Route::get('/extended/ui-treeview', [Treeview::class, 'index'])->name('extended-ui-treeview');
Route::get('/extended/ui-misc', [Misc::class, 'index'])->name('extended-ui-misc');

// icons
Route::get('/icons/icons-ri', [RiIcons::class, 'index'])->name('icons-ri');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');
Route::get('/forms/custom-options', [CustomOptions::class, 'index'])->name('forms-custom-options');
Route::get('/forms/editors', [Editors::class, 'index'])->name('forms-editors');
Route::get('/forms/file-upload', [FileUpload::class, 'index'])->name('forms-file-upload');
Route::get('/forms/pickers', [Picker::class, 'index'])->name('forms-pickers');
Route::get('/forms/selects', [Selects::class, 'index'])->name('forms-selects');
Route::get('/forms/sliders', [Sliders::class, 'index'])->name('forms-sliders');
Route::get('/forms/switches', [Switches::class, 'index'])->name('forms-switches');
Route::get('/forms/extras', [Extras::class, 'index'])->name('forms-extras');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');
Route::get('/form/layouts-sticky', [StickyActions::class, 'index'])->name('form-layouts-sticky');

// form wizards
Route::get('/form/wizard-numbered', [FormWizardNumbered::class, 'index'])->name('form-wizard-numbered');
Route::get('/form/wizard-icons', [FormWizardIcons::class, 'index'])->name('form-wizard-icons');
Route::get('/form/validation', [Validation::class, 'index'])->name('form-validation');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
Route::get('/tables/datatables-basic', [DatatableBasic::class, 'index'])->name('tables-datatables-basic');
Route::get('/tables/datatables-advanced', [DatatableAdvanced::class, 'index'])->name('tables-datatables-advanced');
Route::get('/tables/datatables-extensions', [DatatableExtensions::class, 'index'])->name('tables-datatables-extensions');

// charts
Route::get('/charts/apex', [ApexCharts::class, 'index'])->name('charts-apex');
Route::get('/charts/chartjs', [ChartJs::class, 'index'])->name('charts-chartjs');

// maps
Route::get('/maps/leaflet', [Leaflet::class, 'index'])->name('maps-leaflet');

// laravel example
Route::get('/laravel/user-management', [UserManagement::class, 'UserManagement'])->name('laravel-example-user-management');
Route::resource('/user-list', UserManagement::class);

// authentication default
Route::get('/auth/login-cover', [LoginCover::class, 'index'])->name('auth-login-cover');
Route::post('/auth/login-cover', [LoginCover::class, 'store']);
Route::get('/auth/register-cover', [RegisterCover::class, 'index'])->name('auth-register-cover');
Route::post('/auth/register-cover', [RegisterCover::class, 'store']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/auth/verify-email-cover', [VerifyEmailCover::class, 'index'])->name('auth-verify-email-cover');
Route::get('/auth/reset-password-cover', [ResetPasswordCover::class, 'index'])->name('auth-reset-password-cover');
Route::get('/auth/forgot-password-cover', [ForgotPasswordCover::class, 'index'])->name('auth-forgot-password-cover');

// admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
  Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin-dashboard');
  Route::get('/admin/artisan-verification', [ArtsnVerification::class, 'index'])->name('admin-artisan-verification');
  Route::get('/admin/verification/{verification}', [ArtsnVerification::class, 'show'])->name('admin-verification-show');
  Route::post('/admin/verification/{verification}/approve', [ArtsnVerification::class, 'approve'])->name('admin-verification-approve');
  Route::post('/admin/verification/{verification}/reject', [ArtsnVerification::class, 'reject'])->name('admin-verification-reject');
  Route::post('/admin/verification/{verification}/request-changes', [ArtsnVerification::class, 'requestChanges'])->name('admin-verification-request-changes');
  Route::get('/admin/user-management', [AdminUserManagement::class, 'index'])->name('admin-user-management');
  Route::put('/admin/user-management/{user}', [AdminUserManagement::class, 'update'])->name('admin-user-update');
  Route::post('/admin/user-management/{user}/suspend', [AdminUserManagement::class, 'suspend'])->name('admin-user-suspend');
  Route::post('/admin/user-management/{user}/activate', [AdminUserManagement::class, 'activate'])->name('admin-user-activate');
  Route::get('/admin/orders', [OrderMonitor::class, 'index'])->name('admin-orders');
  Route::post('/admin/orders/{order}/hold', [OrderMonitor::class, 'hold'])->name('admin-order-hold');
  Route::post('/admin/orders/{order}/resume', [OrderMonitor::class, 'resume'])->name('admin-order-resume');
  Route::post('/admin/orders/{order}/cancel', [OrderMonitor::class, 'cancel'])->name('admin-order-cancel');
  Route::get('/admin/reviews', [ReviewsMonitor::class, 'index'])->name('admin-reviews');
  Route::post('/admin/reviews/{review}/feature', [ReviewsMonitor::class, 'feature'])->name('admin-review-feature');
  Route::put('/admin/reviews/{review}', [ReviewsMonitor::class, 'update'])->name('admin-review-update');
  Route::post('/admin/reviews/{review}/remove', [ReviewsMonitor::class, 'remove'])->name('admin-review-remove');
  Route::post('/admin/reviews/{review}/restore', [ReviewsMonitor::class, 'restore'])->name('admin-review-restore');
  Route::get('/admin/reports', [Reports::class, 'index'])->name('admin-reports');
  Route::post('/admin/reports/generate', [Reports::class, 'generateReport'])->name('reports.generate');
});

// client/general user routes
Route::middleware(['auth', 'role:client'])->group(function () {
  Route::get('/user/dashboard', [GeneralUSerController::class, 'index'])->name('user-dashboard');
  Route::get('/user/profile', [GeneralUSerController::class, 'userProfile'])->name('user-profile');
  Route::put('/user/profile/update', [GeneralUSerController::class, 'updateProfile'])->name('user-profile-update');
  Route::put('/user/password/change', [GeneralUSerController::class, 'changePassword'])->name('user-password-change');
  Route::get('/user/browse', [GeneralUSerController::class, 'browseArtisans'])->name('user-browse-artisans');
  Route::get('/artisan/{artisan}/profile', [GeneralUSerController::class, 'showArtisanProfile'])->name('artisan-public-profile');
  Route::get('/user/orders', [GeneralUSerController::class, 'myOrders'])->name('user-my-orders');
  Route::get('/user/order-details/{order}', [GeneralUSerController::class, 'orderDetails'])->name('user-order-details');
  Route::get('/user/order/{order}/track', [GeneralUSerController::class, 'trackOrder'])->name('user-track-order');
  Route::get('/user/order/{order}/invoice', [GeneralUSerController::class, 'downloadInvoice'])->name('user-download-invoice');
  Route::get('/user/order/{order}/review', [GeneralUSerController::class, 'createReviewForOrder'])->name('user-order-review');
  Route::post('/user/review/store', [GeneralUSerController::class, 'storeReview'])->name('user-store-review');
  Route::get('/user/review/{review}', [GeneralUSerController::class, 'viewReview'])->name('user-view-review');
  Route::get('/user/review/{review}/edit', [GeneralUSerController::class, 'editReview'])->name('user-edit-review');
  Route::put('/user/review/{review}', [GeneralUSerController::class, 'updateReview'])->name('user-update-review');
  Route::delete('/user/review/{review}', [GeneralUSerController::class, 'deleteReview'])->name('user-delete-review');
  Route::get('/user/order/{order}/contact', [GeneralUSerController::class, 'contactArtisan'])->name('user-contact-artisan');
  Route::get('/user/order/{order}/pay', [GeneralUSerController::class, 'payNow'])->name('user-pay-now');
  Route::get('/user/create/review', [GeneralUSerController::class, 'createReview'])->name('user-create-review');

  // Cart routes
  Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [App\Http\Controllers\CartController::class, 'index'])->name('index');
    Route::post('/add', [App\Http\Controllers\CartController::class, 'addItem'])->name('add');
    Route::put('/item/{cartItem}/update', [App\Http\Controllers\CartController::class, 'updateQuantity'])->name('update');
    Route::delete('/item/{cartItem}', [App\Http\Controllers\CartController::class, 'removeItem'])->name('remove');
    Route::delete('/clear', [App\Http\Controllers\CartController::class, 'clearCart'])->name('clear');
    Route::get('/count', [App\Http\Controllers\CartController::class, 'getCartCount'])->name('count');
  });

  // Checkout routes
  Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/{cart}', [App\Http\Controllers\CheckoutController::class, 'show'])->name('show');
    Route::post('/process/{cart}', [App\Http\Controllers\CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('success');
  });
});

// artisan routes
Route::middleware(['auth', 'role:artisan'])->group(function () {
  Route::get('/artisan/profile', [ArtisanController::class, 'artisanProfile'])->name('artisan-profile');
  Route::get('/artisan/dashboard', [ArtisanController::class, 'artisanDashboard'])->name('artisan-dashboard');
  Route::get('/artisan/my-orders', [ArtisanController::class, 'artisanOrders'])->name('artisan-my-orders');
  Route::get('/artisan/order-details', [ArtisanController::class, 'orderDetails'])->name('artisan-order-details');
  Route::get('/artisan/my-services', [ArtisanController::class, 'artisanServices'])->name('artisan-my-services');
  Route::get('/artisan/my-products', [ArtisanController::class, 'artisanProducts'])->name('artisan-my-products');
  Route::get('/artisan/order-products', [ArtisanController::class, 'orderDetails'])->name('artisan-order-products');
  Route::get('/artisan/reviews', [ArtisanController::class, 'myReviews'])->name('artisan-my-reviews');
  Route::post('/artisan/reviews/{review}/reply', [ArtisanController::class, 'submitReviewReply'])->name('artisan-review-reply');
  Route::get('/artisan/view/payments', [ArtisanController::class, 'viewPayments'])->name('artisan-view-payments');
  Route::post('/artisan/paynow/add', [ArtisanController::class, 'addPaynowAccount'])->name('artisan-paynow-add');
  Route::put('/artisan/paynow/{paynowAccount}/update', [ArtisanController::class, 'updatePaynowAccount'])->name('artisan-paynow-update');
  Route::delete('/artisan/paynow/{paynowAccount}', [ArtisanController::class, 'deletePaynowAccount'])->name('artisan-paynow-delete');
  Route::post('/artisan/payout/request', [ArtisanController::class, 'requestPayout'])->name('artisan-payout-request');
  Route::get('/artisan/verification', [ArtisanController::class, 'verification'])->name('artisan-verification');
  Route::post('/artisan/document/upload', [ArtisanController::class, 'uploadNationalDocument'])->name('artisan-document-upload');
  Route::put('/artisan/document/update', [ArtisanController::class, 'updateDocumentInfo'])->name('artisan-document-update');

  // Store routes for services and products
  Route::post('/artisan/services/store', [ArtisanController::class, 'storeService'])->name('artisan-service-store');
  Route::put('/artisan/services/{service}/update', [ArtisanController::class, 'updateService'])->name('artisan-service-update');
  Route::delete('/artisan/services/{service}', [ArtisanController::class, 'deleteService'])->name('artisan-service-delete');

  Route::post('/artisan/products/store', [ArtisanController::class, 'storeProduct'])->name('artisan-product-store');
  Route::put('/artisan/products/{product}/update', [ArtisanController::class, 'updateProduct'])->name('artisan-product-update');
  Route::put('/artisan/products/{product}/stock', [ArtisanController::class, 'updateStock'])->name('artisan-product-stock');
  Route::delete('/artisan/products/{product}', [ArtisanController::class, 'deleteProduct'])->name('artisan-product-delete');

  // Order routes
  Route::get('/artisan/order/{order}/details', [ArtisanController::class, 'orderDetails'])->name('artisan-order-details');
  Route::post('/artisan/order/{order}/update-status', [ArtisanController::class, 'updateOrderStatus'])->name('artisan-order-update-status');
  Route::get('/artisan/order/{order}/invoice', [ArtisanController::class, 'downloadInvoice'])->name('artisan-order-invoice');

  // Profile routes
  Route::get('/artisan/profile', [ArtisanController::class, 'artisanProfile'])->name('artisan-profile');
  Route::post('/artisan/profile/photo', [ArtisanController::class, 'updateProfilePhoto'])->name('artisan-profile-photo');
  Route::put('/artisan/profile/business', [ArtisanController::class, 'updateBusinessProfile'])->name('artisan-profile-business');
  Route::put('/artisan/profile/personal', [ArtisanController::class, 'updatePersonalDetails'])->name('artisan-profile-personal');
  Route::put('/artisan/profile/bank', [ArtisanController::class, 'updateBankDetails'])->name('artisan-profile-bank');
  Route::put('/artisan/profile/social', [ArtisanController::class, 'updateSocialLinks'])->name('artisan-profile-social');
  Route::put('/artisan/profile', [ArtisanController::class, 'updateProfile'])->name('artisan-profile-update');
  Route::post('/artisan/profile/password', [ArtisanController::class, 'changePassword'])->name('artisan-profile-password');
});

// Paynow webhook (public endpoint - outside middleware groups)
Route::post('/paynow/webhook', [App\Http\Controllers\PaynowWebhookController::class, 'handle'])
    ->name('paynow.webhook')
    ->middleware('verify.paynow.webhook');
