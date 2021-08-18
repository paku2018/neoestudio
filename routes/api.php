<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::post('user','TestController@us');
Route::post('user','API\StudentController@user');
Route::post('getFiles','API\MaterialController@getFiles');
Route::post('registerStudent','API\StudentController@registerStudent');
Route::post('loginStudent','API\StudentController@loginStudent');
Route::post('logoutStudent','API\StudentController@logoutStudent');
Route::get('getAudios','API\MaterialController@getAudios');
Route::get('getPdfs','API\MaterialController@getPdfs');
Route::post('emailSubscription','API\StudentController@emailSubscription');

//download and uploads
Route::post('getUploadFolders','API\DownloadUploadController@getUploadFolders');
Route::post('getDownloadFolders','API\DownloadUploadController@getDownloadFolders');
Route::post('getDownloadFiles','API\DownloadUploadController@getDownloadFiles');
Route::post('uploadFile','API\DownloadUploadController@uploadFile');

//download and upload for pfd
Route::post('getUploadPdfFolders','API\DownloadUploadController@getUploadPdfFolders');
Route::post('getDownloadPdfFolders','API\DownloadUploadController@getDownloadPdfFolders');
Route::post('getDownloadPdfFiles','API\DownloadUploadController@getDownloadPdfFiles');
Route::post('uploadPdfFile','API\DownloadUploadController@uploadPdfFile');

//For audio / video / pdf
Route::post('getTopics','API\MaterialController@getTopics');
Route::post('getAudioFiles','API\MaterialController@getAudioFiles');
Route::post('getVideoFiles','API\MaterialController@getVideoFiles');
Route::post('getPdfFiles','API\MaterialController@getPdfFiles');

Route::get('uploadSpinner','API\MaterialController@uploadSpinner');

Route::post('getAllExamFolders','API\ExamController@getAllExamFolders');
Route::post('getAllExamsOfFolder','API\ExamController@getAllExamsOfFolder');
Route::post('getAllExams','API\ExamController@getAllExams');
Route::post('getAllExam','API\ExamController@getAllExam');

Route::post('startExam','API\ExamController@startExam');

Route::post('storeAnswer','API\ExamController@storeAnswer');
Route::post('pauseAnswer','API\ExamController@pauseAnswer');
Route::post('endExam','API\ExamController@endExam');
Route::post('reviewExam','API\ExamController@reviewExam');
Route::post('endReview','API\ExamController@endReview');

Route::get('timeTest','API\ExamController@timeTest');
Route::get('getRecords','API\ExamController@getRecords');

Route::get('getStudents','API\ExamController@getStudents');
Route::get('getExams','API\ExamController@getExams');
Route::get('getFolders','API\ExamController@getFolders');

Route::post('getFaqFolders','API\FaqController@getFaqFolders');
Route::post('getFolderFaqs','API\FaqController@getFolderFaqs');

Route::post('faqSearch','API\FaqController@faqSearch');


Route::post('getAllPersonalityExams','API\PersonalityController@getAllPersonalityExams');
Route::post('getAllReviewExams','API\ReviewController@getAllReviewExams');

Route::post('getAllReviewFolders','API\ReviewController@getAllReviewFolders');
Route::post('getReviewFolderExams','API\ReviewController@getreviewFolderExams');

//Api to anble rapaso exam status
Route::post('reviewStatus','API\ReviewController@updateStatus');

Route::post('newsUnseenCount','API\AlertController@newsUnseenCount');
Route::post('allNews','API\AlertController@allNews');

Route::post('surveyList','API\SurveyController@surveyList');
Route::post('getSurveyQuestions','API\SurveyController@getSurveyQuestions');

Route::post('getSurveyTest','API\SurveyController@getSurveyTest');

Route::post('storeChatStudent','API\ChatController@storeChatStudent');
Route::post('storeChatTeacher','API\ChatController@storeChatTeacher');
Route::post('getChat','API\ChatController@getChat');

Route::post('chatCount','API\ChatController@chatCount');
Route::post('getTopicCourseVerticalRanking','API\RankingController@getTopicCourseVerticalRanking');
Route::post('getTopicCourseHorizontalRanking','API\RankingController@getTopicCourseHorizontalRanking');
Route::post('getTopicCourseHorizontalRanking2','API\RankingController@getTopicCourseHorizontalRanking2');

Route::post('getCourseVerticalRanking','API\RankingController@getCourseVerticalRanking');

Route::post('audios','API\ObjectiveController@audios');
Route::post('videos','API\ObjectiveController@videos');
Route::post('estudioTemario','API\ObjectiveController@estudioTemario');
Route::post('repasoTemario','API\ObjectiveController@repasoTemario');
Route::post('getObjectives','API\ObjectiveController@getObjectives');

Route::post('getObjectivesDb','API\ObjectiveController@getObjectivesDb');
Route::post('deleteObjectivesDb','API\ObjectiveController@deleteObjectivesDb');
Route::post('objectiveRanking','API\ObjectiveController@objectiveRanking');

Route::post('reviewDrawr','API\ExamController@reviewDrawr');

Route::post('checkNotifications','AdminController@checkNotifications');

Route::post('checkNotif','AdminController@checkNotif');

Route::post('onExam','AdminController@onExam');
Route::post('getDates','AdminController@getDates');
Route::post('getCourseVerticalRankingTest','AdminController@getCourseVerticalRanking');

Route::post('pdfCounter','API\ObjectiveController@pdfCounter');
