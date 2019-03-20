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

Route::namespace('Frontend')->group(function() {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::get('post/{slug}/{commentid?}', 'HomeController@showpost')->name('post');
    Route::get('category/{slug}', 'HomeController@showcategory')->name('category');
    Route::get('page/{slug}', 'HomeController@showpage')->name('page');
    Route::get('tag/{name}', 'HomeController@showtag')->name('tag');
    Route::get('aseries/{sslug}/{catslug?}/{pslug?}', 'HomeController@showseries')->name('aseries');
    Route::get('contact', 'HomeController@contact')->name('contact');
    Route::get('pdf/{type}/{slug}', 'HomeController@generatepdf')->name('pdf');
    Route::any('searchpost','HomeController@searchpost')->name('searchpost');
    Route::get('searchpost/{keyword}','HomeController@paginatesearchpost');
    
    Route::get('comments/{postSlug}', 'HomeController@getCommentsform')->name('comments');
    Route::post('getcomments/{postid}', 'HomeController@getComments')->name('getcomments');
    Route::post('saveComments/{postid}', 'HomeController@saveComments')->name('saveComments')->middleware(['auth:visitor,web']);
    Route::post('updateComment', 'HomeController@updateComment')->name('updateComment')->middleware(['auth:visitor,web']);
    Route::post('deleteComment', 'HomeController@deleteComment')->name('deleteComment')->middleware(['auth:visitor,web']);
    
    Route::name('visitors.')->group(function() {
        Route::group(['middleware' => ['guest']], function() {
            Route::get('visitors/loginform', 'VisitorController@showLoginForm')->name('loginform');
            Route::get('visitors/registrationform', 'VisitorController@showRegistrationForm')->name('registrationform');
            Route::post('visitors/registradb', 'VisitorController@registerVisitor')->name('registradb');
            Route::post('visitors/login', 'VisitorController@login')->name('login');
            Route::post('visitors/loginajax', 'VisitorController@loginajax')->name('loginajax');
            Route::get('visitors/verifymail/{visitorid}/{code}', 'VisitorController@verifyVisitor')->name('verifyVisitor');
        });
        Route::group(['middleware' => ['auth:visitor']], function() {
            Route::get('visitors/logout', 'VisitorController@logout')->name('logout');
            Route::get('visitors/profile', 'VisitorController@getVisitorProfile')->name('profile');
            Route::get('visitors/editname', 'VisitorController@showEditNameForm')->name('editname');
            Route::post('visitors/editnamedb', 'VisitorController@updatename')->name('editnamedb');
            Route::get('visitors/editpassword', 'VisitorController@showEditPasswordForm')->name('editpassword');
            Route::get('visitors/commentslist', 'VisitorController@getcommentslist')->name('commentslist');
            Route::post('visitors/editpassworddb', 'VisitorController@updatepassword')->name('editpassworddb');
            Route::get('visitors/questionlist', 'VisitorController@getQuestions')->name('questionlist');
        });
        
    });
    
    Route::name('question.')->group(function() {
        Route::get('question', 'QuestionController@index')->name('index');
        Route::get('questionstype/{type}', 'QuestionController@getQuestionTypes')->name('questiontype');
        Route::get('questiondetails/{id}', 'QuestionController@getQuestionDetails')->name('questiondetails');
        Route::any('searchquestion','QuestionController@searchquestion')->name('searchquestion');
        Route::get('searchquestion/{keyword}','QuestionController@paginatesearchquestion');
    
    
        Route::group(['middleware' => ['auth:visitor']], function() {
            Route::get('question/create', 'QuestionController@createQuestion')->name('create');
            Route::post('question/store', 'QuestionController@storeQuestion')->name('store');
        });
    });
    
    Route::get('error', function() {
        return view('frontend.error');
    })->name('frontend.error');
});


Route::name('backend.')->namespace('Backend')->group(function() {
    
    Route::get('login', 'UserController@index')->name('login');
    Route::post('login', 'UserController@login')->name('login');
    
    Route::group(['middleware' => ['auth:web']], function() {
    
        Route::get('logout', 'UserController@logout')->name('logout');
        Route::get('profile', 'UserController@getProfiledata')->name('profile');
        Route::post('profile/update', 'UserController@updateProfile')->name('updateProfile');
        Route::post('password/update', 'UserController@updatepassword')->name('updatepassword');
        Route::get('password/updateform', 'UserController@updatepasswordform')->name('updatepasswordform');
        
        Route::get('admin', 'HomeController@index')->name('home');
        Route::resource('categories', 'CategoryController');
        Route::resource('tags', 'TagController');
        Route::resource('posts', 'PostController');
        Route::resource('pages', 'PageController');
        Route::resource('menus', 'MenuController');
        Route::resource('series', 'SeriesController');
        Route::resource('extrafile', 'ExtraFileController');
        Route::resource('questiontype', 'QuestionTypeController');
        Route::resource('questions', 'QuestionsController');
        Route::resource('quizzes', 'QuizController');
        
        Route::post('storefile', 'PostController@storefile')->name('storefile');
        Route::post('deletefile', 'PostController@deletefile')->name('deletefile');
        Route::post('getMenyTypes', 'MenuController@getMenyTypes')->name('getMenyTypes');
        Route::get('serieslist/{id}', 'SeriesController@getSeriesList')->name('serieslist');

        
        Route::post('postedit', 'SeriesController@editpostorder')->name('postedit');
        Route::post('categoryedit', 'SeriesController@editcategororder')->name('categoryedit');
        Route::post('categoryadd', 'SeriesController@addCategorySeries')->name('categoryadd');
        Route::delete('deletecategoryseries/{id}', 'SeriesController@deletecategoryseries')->name('deletecategoryseries');
        

        Route::get('quizequestionlistlist/{id}', 'QuizController@getQuestionList')->name('quizequestionlistlist');
        Route::post('addquizequestion/{quizid}', 'QuizController@savequizequestion')->name('addquizequestion');
        Route::get('questionsection/{key}','QuizController@getquestionsection')->name('questionsection');
        Route::get("deletequestion/{questionid}","QuizController@deletequestion")->name('deletequestion');
    });
});
