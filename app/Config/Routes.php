<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override('App\Controllers\Home::notFound');
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/manual', 'Home::manual', ['filter' => 'auth']);
$routes->get('/tools', 'Home::tools', ['filter' => 'auth']);
$routes->get('/sitemap.xml', 'Home::sitemap');

$routes->get('exam/(:num)', 'Exam::subject/$1');
$routes->get('exam/new', 'Exam::new', ['filter' => 'canAdd']);
$routes->get('exam/delete/(:num)', 'Exam::delete/$1', ['filter' => 'canDelete']);
$routes->get('exam/edit/(:num)', 'Exam::edit/$1', ['filter' => 'canEdit']);
$routes->get('exam/save_exam/(:num)', 'Exam::saveExam/$1', ['filter' => 'auth']);
$routes->get('exam/unlock/(:num)', 'Exam::unlock/$1', ['filter' => 'auth']);
$routes->get('exam/tex/(:num)', 'Exam::tex/$1', ['filter' => 'auth']);
$routes->post('exam/generate', 'Exam::generatePost', ['filter' => 'auth']);
$routes->get('exam/generate/(:num)', 'Exam::generate/$1', ['filter' => 'auth']);

$routes->get('user/(:num)/exams', 'User::userExams/$1', ['filter' => 'auth']);
$routes->get('user/(:num)', 'User::index/$1', ['filter' => 'auth']);
$routes->post('user/(:num)', 'User::changePermissions/$1', ['filter' => 'canManageUsers']);
$routes->get('user/login', 'User::login', ['filter' => 'noauth']);
$routes->post('user/login', 'User::loginPost', ['filter' => 'noauth']);
$routes->get('user/register', 'User::register', ['filter' => 'noauth']);
$routes->post('user/register', 'User::registerPost', ['filter' => 'noauth']);
$routes->get('user/resetPassword', 'User::resetPassword', ['filter' => 'noauth']);
$routes->post('user/resetPassword', 'User::resetPasswordPost', ['filter' => 'noauth']);

$routes->get('cp/', 'ControlPanel::settings', ['filter' => 'auth']);
$routes->get('cp/settings', 'ControlPanel::settings', ['filter' => 'auth']);
$routes->post('cp/settings', 'ControlPanel::settingsPost', ['filter' => 'auth']);
$routes->get('cp/savedExams', 'ControlPanel::savedExams', ['filter' => 'auth']);
$routes->get('cp/all', 'ControlPanel::all', ['filter' => 'canManageUsers']);
$routes->get('cp/log', 'ControlPanel::loginLog', ['filter' => 'canManageUsers']);
$routes->get('cp/statistics', 'ControlPanel::statistics', ['filter' => 'canManageUsers']);
$routes->get('cp/getStatistics/(:num)-(:num)-(:num)', 'ControlPanel::getStatisticsForDay/$1/$2/$3', ['filter' => 'canManageUsers']);
$routes->get('cp/getStatistics', 'ControlPanel::getStatistics', ['filter' => 'canManageUsers']);

$routes->get('subject/new', 'Subject::new', ['filter' => 'canManageSubjects']);
$routes->post('subject/new', 'Subject::newPost', ['filter' => 'canManageSubjects']);
$routes->get('subject/delete/(:num)', 'Subject::delete/$1', ['filter' => 'canManageSubjects']);
$routes->get('subject/(:num)', 'Subject::subject/$1', ['filter' => 'canManageSubjects']);
$routes->post('subject/(:num)', 'Subject::subjectPost/$1', ['filter' => 'canManageSubjects']);
$routes->get('subject/', 'Subject::all', ['filter' => 'canManageSubjects']);

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
