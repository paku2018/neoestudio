
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
Route::post('/subscription/purchase', 'SubscriptionController@purchase')->name('subscription.purchase');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/plans', 'PlanController@index')->name('plans.index');
    Route::get('/plan/{plan}', 'PlanController@show')->name('plans.show');
    Route::post('/subscription', 'SubscriptionController@create')->name('subscription.create');

    //Routes for create Plan
    Route::get('create/plan', 'SubscriptionController@createPlan')->name('create.plan');
    Route::post('store/plan', 'SubscriptionController@storePlan')->name('store.plan');
});

Route::get('/','PagesController@page');
/*Route::get('/', function () {

    if(\Request::secure()){
        return view('neoestudio/inicio');
    }
    else{
        return view('neoestudio/inicio');
        //return \Redirect::to("https://neoestudioguardiaciviloposiciones.es/");
    }
});*/
Route::get('/formacion','PagesController@page');
Route::get('/oposicion','PagesController@page');
Route::get('/comienza','PagesController@page');
Route::get('/comienza-new','PagesController@page');
Route::get('/equipo','PagesController@page');
/*Route::get('/oposicion', function () {
    return view('neoestudio/oposicion');
});*/
/*Route::get('/formacion', function () {
    return view('neoestudio/formacion');
});
Route::get('/equipo', function () {
    return view('neoestudio/equipo');
});*/
Route::get('/contacto', function () {
    return view('neoestudio/contacto');
});
Route::get('/registerate', function () {
    return view('neoestudio/registerate');
});
Route::get('regístrate',function () {
    return view('neoestudio/registerate');
});
Route::get('/registerate/{reason}', function ($reason) {

    return view('registers/registerate',compact('reason'));
});
Route::get('/aviso-legal-y-términos-de-uso', function () {
    return view('neoestudio/aviso');
});
Route::get('/política-de-privacidad-y-protección-de-datos', function () {
    return view('neoestudio/priva');
});
Route::get('/política-de-cookies', function () {
    return view('neoestudio/cookies');
});
Route::get('purchaseCo/{userId}/{reason}', function ($userId,$reason) {
    if($reason=="books"){
        return view('payments/books',compact('userId','payId'));
    }
    if($reason=="alumno"){
        return view('payments/alumno',compact('userId'));
    }
    if($reason=="alumnoConvocado"){
        return view('payments/alumnoConvocado',compact('userId'));
    }

});

/*Route::get('/comienza', function () {
    return view('neoestudio/comienza');
});*/
Route::get('admin-panel', function () {
    return view('home');
});
Route::post('/subscription', 'SubscriptionController@create')->name('subscription.create');
//Route::get('paymentCallBackSuccess/{userId}/{amount}/{type}/{payId}','PaymentController@paymentCallBackSuccess');
Route::post('paymentCallBackSuccessN/{userId}/{amount}/{type}/{payId}','PaymentController@paymentCallBackSuccess');
Route::get('pay/{userId}/{amount}/{type}/{payId}','PaymentController@pay');
Route::get('payment/{userId}/{reason}','PaymentController@index');
Route::get('paymentHistory/{userId}','PaymentController@indexH');

Route::get('pays/{type}','PaymentController@showPaysI');
Route::get('showAll/{type}/{userId}','PaymentController@showAll');
Route::get('temario','PaymentController@temario');
Route::post('temario','PaymentController@temario');
Route::get('coursePay','PaymentController@coursePay');
Route::post('coursePay','PaymentController@coursePay');
Route::post('temario2','PaymentController@temario2');
Route::get('paymentFailure/{userId}','PaymentController@paymentFailure');
Route::get('che',function(){
	$num="-0.6400000000000003";
	dd(round($num,2));

	$course=new \App\Course;
	$course->name=\Request::ip();
	$course->save();
return Redirect::away("http://www.google.com");
});
Route::post('submitDoc','TestController@submitDoc');
Route::post('contactMail','AdminController@contactMail');
Route::get('ts','TestController@ts');
Route::get('ts3','TestController@ts3');
Route::get('tep','AdminController@checkNotifications');
Route::get('idenManual/{id}','TestController@idenManual');

Route::get('courses','CourseController@index');
Route::get('courses/create','CourseController@create');
Route::post('courses/store','CourseController@store');
Route::get('courses/edit/{id}','CourseController@edit');
Route::post('courses/update/{id}','CourseController@update');
Route::get('courses/delete/{id}','CourseController@delete');

Route::get('comments','CommentController@index');
Route::get('comments/create','CommentController@create');
Route::post('comments/store','CommentController@store');
Route::get('comments/edit/{id}','CommentController@edit');
Route::post('comments/update/{id}','CommentController@update');
Route::get('comments/delete/{id}','CommentController@delete');

Route::get('calenders/{studentType}','CalenderController@index');
Route::get('calenders/create/{studentType}','CalenderController@create');
Route::post('calenders/store','CalenderController@store');
Route::get('calenders/edit/{id}','CalenderController@edit');
Route::post('calenders/update/{id}','CalenderController@update');
Route::get('calenders/delete/{id}','CalenderController@delete');

Route::get('examsFolders/{studentType}','ExamController@indexFolder');
Route::get('examsFoldersCreate/{studentType}','ExamController@createFolder');
Route::get('examsFoldersEdit/{folderId}','ExamController@editFolder');
Route::get('examsFoldersDelete/{folderId}','ExamController@deleteFolder');
Route::post('examsFoldersStore','ExamController@storeFolder');
Route::post('examsFoldersUpdate/{id}','ExamController@updateFolder');
Route::get('examsFoldersStatusChange/{folderId}','ExamController@examsFoldersStatusChange');

Route::get('insideExamsFolders/{studentType}/{folderId}','ExamController@insideExamsFolders');
Route::get('insideExamsFoldersCreate/{studentType}/{folderId}','ExamController@insideExamsFoldersCreate');
Route::post('insideExamsFoldersStore','ExamController@insideExamsFoldersStore');
Route::get('insideExamsFoldersEdit/{id}','ExamController@insideExamsFoldersEdit');
Route::post('insideExamsFoldersUpdate/{id}','ExamController@insideExamsFoldersUpdate');
Route::get('insideExamsFoldersDelete/{id}','ExamController@insideExamsFoldersDelete');
Route::get('insideExamsFoldersStatusChange/{id}','ExamController@insideExamsFoldersStatusChange');

Route::get('insideMaterialFolders/{type}/{topicId}','MaterialController@index');
Route::get('materialFolders/{type}/{studentType}','MaterialController@index2');
Route::get('insideFolderMaterialsCreate/{type}/{topicId}','MaterialController@create');
Route::post('insideFolderMaterialsStore','MaterialController@store');
Route::get('insideFolderMaterialsEdit/{id}','MaterialController@edit');
Route::post('insideFolderMaterialsUpdate/{id}','MaterialController@update');
Route::get('insideFolderMaterialsDelete/{id}','MaterialController@delete');
Route::get('materialDownload/{id}','MaterialController@download');


Route::get('news','NewsController@index');
Route::get('news/create','NewsController@create');
Route::post('news/store','NewsController@store');
Route::get('news/edit/{id}','NewsController@edit');
Route::post('news/update/{id}','NewsController@update');
Route::get('news/delete/{id}','NewsController@delete');

Route::get('teachers','TeacherController@index');
Route::get('teachers/create','TeacherController@create');
Route::post('teachers/store','TeacherController@store');
Route::get('teachers/edit/{id}','TeacherController@edit');
Route::post('teachers/update/{id}','TeacherController@update');
Route::get('teachers/delete/{id}','TeacherController@delete');

Route::get('students','StudentController@index');
Route::get('studentsBlock/{id}','StudentController@block');
Route::get('prueba','StudentController@prueba');
Route::get('alumno','StudentController@alumno');
Route::get('alumnoConvocado','StudentController@alumnoConvocado');
Route::get('students/create','StudentController@create');
Route::post('students/store','StudentController@store');
Route::get('students/edit/{id}','StudentController@edit');
Route::post('students/update/{id}','StudentController@update');
Route::get('students/delete/{id}','StudentController@delete');
Route::get('studentExamsById/{id}','StudentController@studentExamsById');
Route::get('studentExamsAttempted/{id}','StudentController@studentExamsAttempted');
Route::get('rescheduleExamEnable/{id}','StudentController@rescheduleExamEnable');
Route::get('rescheduleExamDisable/{id}','StudentController@rescheduleExamDisable');

Route::get('payments','PaymentController@index');
Route::get('payments/create','PaymentController@create');
Route::post('payments/store','PaymentController@store');
Route::get('payments/edit/{id}','PaymentController@edit');
Route::post('payments/update/{id}','PaymentController@update');
Route::get('payments/delete/{id}','PaymentController@delete');

Route::get('questions/{examId}','QuestionAnswerController@index');
Route::get('questions/create/{examId}','QuestionAnswerController@create');
Route::post('questions/store','QuestionAnswerController@store');
Route::get('questions/edit/{id}','QuestionAnswerController@edit');
Route::post('questions/update/{id}','QuestionAnswerController@update');
Route::get('questions/delete/{id}','QuestionAnswerController@delete');
Route::get('qas/{id}','QuestionAnswerController@qas');
Route::post('insertExamImages','QuestionAnswerController@insertExamImages');

Route::get('locale/{locale}',function($locale){
	Session::put('locale',$locale);
	return redirect()->back();
});
Route::post('loginUser','TestController@LoginUser');
Route::get('logoutUser','TestController@logoutUser');
Route::get('logout','PagesController@logout');

Route::get('admins','AdminController@index');
Route::get('admins/create','AdminController@create');
Route::post('admins/store','AdminController@store');
Route::get('admins/edit/{id}','AdminController@edit');
Route::post('admins/update/{id}','AdminController@update');
Route::get('admins/delete/{id}','AdminController@delete');

Route::get('topics','TopicController@index');
Route::get('topics/create','TopicController@create');
Route::post('topics/store','TopicController@store');
Route::get('topics/edit/{id}','TopicController@edit');
Route::post('topics/update/{id}','TopicController@update');
Route::get('topics/delete/{id}','TopicController@delete');

Route::get('topicChangeStatus/{id}','TopicController@changeStatus');
Route::get('materialChangeStatus/{id}','MaterialController@changeStatus');

Route::get('faqs/folders','FaqController@indexFolder');
Route::get('faqs/folders/create','FaqController@createFolder');
Route::post('faqs/folders/store','FaqController@storeFolder');
Route::get('faqs/folders/edit/{id}','FaqController@editFolder');
Route::post('faqs/folders/update/{id}','FaqController@updateFolder');
Route::get('faqs/folders/delete/{id}','FaqController@deleteFolder');

Route::get('faqs/{id}','FaqController@indexFaq');
Route::get('faqs/create/{id}','FaqController@createFaq');
Route::post('faqs/store','FaqController@storeFaq');
Route::get('faqs/edit/{id}','FaqController@editFaq');
Route::post('faqs/update/{id}','FaqController@updateFaq');
Route::get('faqs/delete/{id}','FaqController@deleteFaq');

Route::get('downloadsUploadsFolders/{option}/{studentType}','DownloadUploadController@indexFolder');
Route::get('downloadsUploadsFoldersCreate/{option}/{studentType}','DownloadUploadController@createFolder');
Route::post('downloadsUploadsFoldersStore','DownloadUploadController@storeFolder');
Route::get('downloadsUploadsFoldersEdit/{id}','DownloadUploadController@editFolder');
Route::post('downloadsUploadsFoldersUpdate/{id}','DownloadUploadController@updateFolder');
Route::get('downloadsUploadsFoldersDelete/{id}','DownloadUploadController@deleteFolder');
Route::get('downloadsUploadsFolderStatusChange/{id}','DownloadUploadController@downloadsUploadsFolderStatusChange');
Route::get('downloadsUploadsOnlyFiles/{option}/{studentType}','DownloadUploadController@downloadsUploadsOnlyFiles');

Route::get('downloadsUploadsInsideFolderIndex/{option}/{folderId}/{studentType}','DownloadUploadController@index');
Route::get('downloadsUploadsInsideFolderCreate/{option}/{folderId}/{studentType}','DownloadUploadController@create');
Route::post('downloadsUploadsInsideFolderStore','DownloadUploadController@store');
Route::get('downloadsUploadsInsideFolderEdit/{id}/{studentType}','DownloadUploadController@edit');
Route::post('downloadsUploadsInsideFolderUpdate/{id}','DownloadUploadController@update');
Route::get('downloadsUploadsInsideFolderDelete/{id}','DownloadUploadController@delete');
Route::get('downloadsUploadsChangeStatus/{id}','DownloadUploadController@changeStatus');
Route::get('downloadsUploadsChangeStatusFolder/{id}','DownloadUploadController@changeStatusFolder');
Route::get('downloadsUploadsDownload/{id}','DownloadUploadController@download');

Route::get('reviewsFolders/{studentType}','ReviewController@indexFolder');
Route::get('reviewsFoldersCreate/{studentType}','ReviewController@createFolder');
Route::get('reviewsFoldersEdit/{folderId}','ReviewController@editFolder');
Route::post('reviewsFoldersStore','ReviewController@storeFolder');
Route::post('reviewsFoldersUpdate/{id}','ReviewController@updateFolder');
Route::get('reviewsFoldersStatusChange/{folderId}','ReviewController@reviewsFoldersStatusChange');
Route::get('reviewsFoldersDelete/{id}','ReviewController@deleteFolder');

Route::get('insideReviewsFolders/{studentType}/{folderId}','ReviewController@insideReviewsFolders');
Route::get('insideReviewsFoldersCreate/{studentType}/{folderId}','ReviewController@insideReviewsFoldersCreate');
Route::post('insideReviewsFoldersStore','ReviewController@insideReviewsFoldersStore');
Route::get('insideReviewsFoldersEdit/{id}','ReviewController@insideReviewsFoldersEdit');
Route::post('insideReviewsFoldersUpdate/{id}','ReviewController@insideReviewsFoldersUpdate');
Route::get('insideReviewsFoldersDelete/{id}','ReviewController@insideReviewsFoldersDelete');


Route::get('personalitiesFolders/{studentType}','PersonalityController@indexFolder');
Route::get('personalitiesFoldersCreate/{studentType}','PersonalityController@createFolder');
Route::get('personalitiesFoldersEdit/{folderId}','PersonalityController@editFolder');
Route::post('personalitiesFoldersStore','PersonalityController@storeFolder');
Route::post('personalitiesFoldersUpdate/{id}','PersonalityController@updateFolder');
Route::get('personalitiesFoldersStatusChange/{folderId}','PersonalityController@personalitiesFoldersStatusChange');

Route::get('insidePersonalitiesFolders/{studentType}/{folderId}','PersonalityController@insidePersonalitiesFolders');
Route::get('insidePersonalitiesFoldersCreate/{studentType}/{folderId}','PersonalityController@insidePersonalitiesFoldersCreate');
Route::post('insidePersonalitiesFoldersStore','PersonalityController@insidePersonalitiesFoldersStore');
Route::get('insidePersonalitiesFoldersEdit/{id}','PersonalityController@insidePersonalitiesFoldersEdit');
Route::post('insidePersonalitiesFoldersUpdate/{id}','PersonalityController@insidePersonalitiesFoldersUpdate');
Route::get('insidePersonalitiesFoldersDelete/{id}','PersonalityController@insidePersonalitiesFoldersDelete');

Route::get('surveysFolders/{studentType}','SurveyController@indexFolder');
Route::get('surveysFoldersCreate/{studentType}','SurveyController@createFolder');
Route::get('surveysFoldersEdit/{folderId}','SurveyController@editFolder');
Route::post('surveysFoldersStore','SurveyController@storeFolder');
Route::post('surveysFoldersUpdate/{id}','SurveyController@updateFolder');
Route::get('surveysFoldersStatusChange/{folderId}','SurveyController@surveysFoldersStatusChange');

Route::get('insideSurveysFolders/{studentType}/{folderId}','SurveyController@insideSurveysFolders');
Route::get('insideSurveysFoldersCreate/{studentType}/{folderId}','SurveyController@insideSurveysFoldersCreate');
Route::post('insideSurveysFoldersStore','SurveyController@insideSurveysFoldersStore');
Route::get('insideSurveysFoldersEdit/{id}','SurveyController@insideSurveysFoldersEdit');
Route::post('insideSurveysFoldersUpdate/{id}','SurveyController@insideSurveysFoldersUpdate');
Route::get('insideSurveysFoldersDelete/{id}','SurveyController@insideSurveysFoldersDelete');
Route::get('insideSurveysFoldersStatusChange/{id}','SurveyController@insideSurveysFoldersStatusChange');

Route::get('surveyquestions/{examId}','QuestionController@index');
Route::get('surveyquestions/create/{examId}','QuestionController@create');
Route::post('surveyquestions/store','QuestionController@store');
Route::get('surveyquestions/edit/{id}','QuestionController@edit');
Route::post('surveyquestions/update/{id}','QuestionController@update');
Route::get('surveyquestions/delete/{id}','QuestionController@delete');
Route::get('surveyqas/{id}','QuestionController@qas');

Route::get('studentSurveysById/{id}','SurveyController@studentSurveysById');
Route::get('studentSurveysAttempted/{id}','SurveyController@studentSurveysAttempted');

Route::get('threadStatusChange/{id}','ChatController@threadStatusChange');
Route::get('threads','ChatController@threads');
Route::get('chats/{studentId}','ChatController@chats');
Route::post('storeChatTeacher','ChatController@storeChatTeacher');

Route::get('downloadChat/{id}','ChatController@downloadChat');

Route::get('getTopicCourseVerticalRanking','API\RankingController@getTopicCourseVerticalRanking');
Route::get('getCourseVerticalRanking','API\RankingController@getCourseVerticalRanking');

Route::get('googleChart','API\RankingController@getTopicCourseHorizontalRanking3');

Route::get('commulative','AdminController@commulative');
Route::get('studentRankingsById/{id}','AdminController@studentRankingsById');

Route::get('studentRankingsById/{id}','AdminController@studentRankingsById');

Route::get('studentRankings2ById/{id}','AdminController@studentRankings2ById');

Route::get('audios','API\ObjectiveController@audios');
Route::get('videos','API\ObjectiveController@videos');
Route::get('estudioTemario','API\ObjectiveController@estudioTemario');
Route::get('repasoTemario','API\ObjectiveController@repasoTemario');
Route::get('getObjectives','API\ObjectiveController@getObjectives');

Route::get('objectiveRanking','API\ObjectiveController@objectiveRanking');

Route::post('submitRegisterate','AdminController@submitRegisterate');

Route::post('submitLoginInfo','AdminController@submitLoginInfo');

Route::get('prices/{studentType}','PriceController@index');
Route::get('prices/create/{studentType}','PriceController@create');
Route::post('prices/store','PriceController@store');
Route::get('prices/edit/{id}','PriceController@edit');
Route::post('prices/update/{id}','PriceController@update');
Route::get('prices/delete/{id}','PriceController@delete');

Route::get('pages/{pageType}','PagesController@index');
Route::get('pages/create/{pageType}','PagesController@create');
Route::get('pages/create/{pageType}/{id}','PagesController@createContent');
Route::get('pages/video/{pageType}/{id}','PagesController@createTopVideoContent');
Route::post('pages/update_video/{id}','PagesController@updateTopVideo');
Route::post('pages/store','PagesController@store');
Route::get('pages/edit/{pageType}/{id}','PagesController@edit');
Route::get('pages/edit/{pageType}/section/{id}','PagesController@editContentSection');
Route::post('pages/update/{id}','PagesController@update');
Route::post('pages/updateVideo/{id}','PagesController@updateVideo');
Route::get('pages/delete/{id}','PagesController@delete');

Route::resource('products', 'ProductsController');
Route::post('products/update/{id}', 'ProductsController@update');
Route::get('cart', 'ProductsController@cart');
Route::get('add-to-cart/{id}', 'ProductsController@addToCart');
Route::patch('update-cart', 'ProductsController@update');
Route::delete('remove-from-cart', 'ProductsController@remove');
Route::get('products/delete/{id}/', 'ProductsController@destroy');

Route::resource('shippings', 'ShippingController');
Route::post('shippings/update/{id}', 'ShippingController@update');
Route::resource('services', 'ServicesController');
Route::get('create_type', 'ServicesController@create_type');
Route::post('services/store_type', 'ServicesController@store_type');
Route::get('service_packages', 'ServicesController@packages');
Route::get('create_package', 'ServicesController@create_package');
Route::get('packages_text', 'ServicesController@packages_text');
Route::post('store_package_texts', 'ServicesController@store_texts');
Route::post('services/store_package', 'ServicesController@store_package');
Route::get('service_packages/edit/{id}', 'ServicesController@edit_package');
Route::post('services/update_package/{id}', 'ServicesController@update_package');
Route::post('get_package_data', 'ServicesController@get_package_data');
Route::post('set_package_data', 'ServicesController@set_package_data');
Route::post('set_product_data', 'ServicesController@set_product_data');
Route::post('get_package_text', 'ServicesController@get_package_text');
Route::get('service_packages/delete/{id}', 'ServicesController@delete_package');


Route::get('courseprice','PriceController@courseindex');
Route::get('courseprice/create/{type}','PriceController@coursecreate');
Route::post('courseprice/store','PriceController@coursestore');
Route::get('courseprice/edit/{id}','PriceController@courseedit');
Route::post('courseprice/update/{id}','PriceController@courseupdate');
Route::get('courseprice/delete/{id}','PriceController@coursedelete');

Route::get('getFigures','TestController@getFiguresS');

Route::get('get-backups','AdminController@backups');
Route::get('take-backup','AdminController@takeBackup');
Route::get('download-backups/{name}','AdminController@backupsDownload');
Route::get('import-backups/{name}','AdminController@backupsImport');

Route::post('upload-backup','AdminController@backupsUpload');

//manually
Route::get('manually/{examId}','QuestionAnswerController@manually');
Route::post('manuallyStore','QuestionAnswerController@manuallyStore');
Route::get('iden','TestController@iden')->name('idd');
Route::get('ide','TestController@ide');
Route::get('deletepaysp/{id}','TestController@deletepaysp');
Route::get('cancelRecurring/{id}','AdminController@cancelRecurring');
Route::get('reactivateRecurring/{id}','AdminController@reactivateRecurring');
Route::get('/redSysPayment',['as'=>'redsys','uses'=>'RedsysController@index']);
Route::get('/response',['as'=>'redsys','uses'=>'RedsysController@response']);
Route::post('/response',['as'=>'redsys','uses'=>'RedsysController@response']);

//Route::post("/paymentfinal", [PaymentController::class,'getData']);

Route::post('paymentfinal','PaymentController@getData');
Route::get('paymentfinal','PaymentController@getData');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@postSubscription')->name('home');
Route::get('/manual', 'HomeController@manualCheck')->name('manual');
Route::get('/paymentPays/{id}', 'HomeController@paymentPays')->name('paymentPays');

Route::get('/paymentCallBackSuccess','PaymentController@paymentCallBackSuccess');
Route::post('stripe/webhook', 'WebhookController@handleWebhook');