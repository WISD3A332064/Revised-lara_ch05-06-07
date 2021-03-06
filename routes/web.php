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
/*
Route::get('/', function () {
    return view('welcome');
});
//基礎路由參數
Route::get('student/{student_no}',function($student_no){
    return "學號：".$student_no;
});
Route::get('student/{srudent_no}/score',function($student_no){
    return "學號：".$student_no."的所有成績";
});

//複數個路由參數
Route::get('student/{student_no}/score/{subject}',function($student_no,$subject){
    return "學號：".$student_no."的".$subject."成績";
});

//選擇性路由參數
Route::get('student/{student_no}/score/{subject?}',function($student_no,$subject=null){
    return "學號：".$student_no."的".((is_null($subject))?"所有科目":$subject)."成績";
});

//正規表達式限制參數
Route::get('student/{student_no}',function($student_no){
    return "學號：".$student_no;
})->where(['student_no'=>'s[0-9]{10}']);
Route::get('student/{student_no}/score/{subject?}',function($student_no,$subject=null){
    return "學號：".$student_no."的".((is_null($subject))?"所有科目":$subject)."成績";
})->where(['subject'=>'(chinese|english|math)']);

//路由群組
Route::pattern('student_no','s[0-9]{10}');
Route::get('student/{student_no}',function ($student_no){
    return '學號：'.$student_no;
});
Route::get('student/{student_no}/score/{subject?}', function ($student_no,$subject=null){
    return '學號：'.$student_no.'的'.((is_null($subject))?'所有科目':$subject).'成績';
}) -> where(['subject' => '(chinese|english|math)']);
*/
//路由命名
Route::pattern('student_no','s[0-9]{10}');
Route::group(['prefix' => 'student'],function(){
    Route::get('{student_no}',['as' => 'student', 'uses' => function ($student_no) {
        return '學號：' . $student_no;
    }]);
    Route::get('{student_no}/score/{subject?}',['as' => 'student.score',
        'uses' => function ($student_no, $subject = null) {
            return '學號：' . $student_no . '的' . ((is_null($subject)) ? '所有科目' : $subject) . '成績';
        }])->where(['subject' => '(chinese|english|math)']);
});

//路由與controller的綁定
Route::get('/',['as' => 'Laravel',
    'uses'=> 'HomeController@index']);

Route::pattern('student_no','s[0-9]{10}');
Route::group(['prefix' => 'student'],function(){
    Route::get('{student_no}',['as' => 'student',
        'uses'=>'StudentController@getStudentData'
    ]);
    Route::get('{student_no}/score/{subject?}',['as' => 'student.score',
        'uses'=>'StudentController@getStudentScore'
    ])->where(['subject' => '(chinese|english|math)']);
});
Route::group(['namespace'=>'Cool'],function (){
    Route::get('cool','TestController@index');
});

//Board
Route::get('/board',['as' => 'board',
    'uses'=>'BoardController@getIndex']);
//Score
Route::get('/score',['as' => 'score',
    'uses'=>'StudentController@getStudentScore']);