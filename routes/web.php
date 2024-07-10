<?php

use Illuminate\Support\Facades\Artisan;


/*
Route::get('/dev', function() { return view('dev'); });
Route::get('/canabia', function() { return view('canabia'); });
*/
/**
 * Static pages
 */


Route::get('/', 'StaticPageController@index');
Route::get('/index.php', 'StaticPageController@index');
Route::get('/about', 'StaticPageController@about');
Route::get('/about.php', 'StaticPageController@about');
Route::get('/whats-new', 'StaticPageController@whatsNew');
Route::get('/contact', 'StaticPageController@contact');
Route::get('/contact.php', 'StaticPageController@contact');
Route::post('/contact', 'StaticPageController@handleContact');
Route::get('/books', 'StaticPageController@books');
Route::get('/forest.php', 'StaticPageController@books');
//Route::get('/portuguese/vocabulary/{letter?}', 'StaticPageController@vocabulary');
//Route::get('/vocabulary.php', 'StaticPageController@vocabulary');
Route::get('/portuguese/pronunciation', 'StaticPageController@pronunciation');
Route::get('/pronunciation.php', 'StaticPageController@pronunciation');
Route::get('/musicians', 'StaticPageController@musicians');
Route::get('/friends', 'StaticPageController@friends');
Route::get('/links.php', 'StaticPageController@friends');
Route::get('/donate', 'StaticPageController@donate');
Route::get('/subscribe', 'StaticPageController@subscribe');
Route::get('/privacy', 'StaticPageController@privacy');
Route::get('/tos', 'StaticPageController@tos');
Route::get('/search_old', 'SearchController@advanced');
Route::get('/search', 'SearchController@advanced_livewire');
Route::get('/faq', 'StaticPageController@faq');
Route::get('/portuguese/for-beginners', 'StaticPageController@forBeginners');
Route::get('/norms-and-rituals', 'StaticPageController@normsAndRituals');

Route::get('register-complete', 'StaticPageController@registerComplete');
Route::get('password/reset-confirm', 'StaticPageController@registerComplete');

/**
 * Languages
 */
Route::get('/language/{languageCode}', 'StaticPageController@language');

/**
 * Profile
 */

Route::group(['middleware' => ['auth']], function() {
    Route::get('/profile', 'ProfileController@show');
    Route::put('/profile', 'ProfileController@update');
});

/**
 * Person
 */

Route::get('/person/{personId}/{personName}', 'PersonController@show');

/**
 * Hinario Lists
 */

Route::get('/hinarios/individual', 'HinarioListController@individual');
Route::get('/hinarios/founders', 'HinarioListController@founders');
Route::get('/hinarios/iceflu', 'HinarioListController@iceflu');
Route::get('/hinarios/cefli', 'HinarioListController@cefli');
Route::get('/hinarios/other', 'HinarioListController@other');
Route::get('/hinarios/official_hinarios.php', 'HinarioListController@individual');
Route::get('/hinarios/other_hinarios.php', 'HinarioListController@individual');
Route::get('/hinarios/compilations', 'HinarioListController@compilations');
Route::get('/hinarios/compilation_hinarios.php', 'HinarioListController@compilations');
Route::get('/hinarios/local', 'HinarioListController@local');
Route::get('/hinarios/local_hinarios.php', 'HinarioListController@local');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/hinarios/personal', 'HinarioListController@personal');
    Route::get('/favorites.php', 'HinarioListController@favorites');

    // Ajax
    Route::get('/submit-feedback', 'AjaxController@submitFeedback');

    Route::get('/submit-upvote', 'AjaxController@submitUpVote');
    Route::get('/submit-downvote', 'AjaxController@submitDownVote');

    Route::get('/add-hymn-to-user-hinario', 'AjaxController@addHymnToUserHinario');

    Route::get('/delete-personal-hinario/{hinarioId}', 'UserHinarioController@deleteUserHinario');
    Route::post('/create-personal-hinario/', 'UserHinarioController@createUserHinario');
    Route::get('/edit-personal-hinario/{hinarioId}', 'UserHinarioController@editUserHinario');
    Route::post('/edit-personal-hinario/{hinarioId}', 'UserHinarioController@saveUserHinario');
});

/**
 * Hinarios
 */

Route::get('/hinario/{hinarioId}/{hinarioName?}', 'HinarioController@showPreloaded');
Route::get('/hinario.php?hid={hinarioId}', 'HinarioController@show');

Route::get('/hinario/{hinarioId}/{hinarioName?}/pdf', 'HinarioController@showPdf');

Route::get('/raw_hinario.php?hid={hinarioId}', 'HinarioController@plainText');

Route::get('/user-hinario/{code}', 'HinarioController@userHinario');
Route::get('/user-hinario/{code}/pdf', 'UserHinarioController@showPdf');

Route::get('/edit-hinario/{hinarioId}', 'Admin\HinarioController@loadHinario');
Route::post('/edit-hinario/{hinarioId}', 'Admin\HinarioController@saveHinario');

Route::get('/edit-person/{personId}', 'Admin\PersonController@loadPerson');
Route::post('/edit-person/{personId}', 'Admin\PersonController@savePerson');

/**
 * Hymns
 */

Route::get('/hymn/{hymnId}/{hymnName?}', 'HymnController@show');
Route::get('/hymn.php?hid={hymnId}', 'HymnController@show');

Route::get('/edit-hymn/{hymnId}', 'Admin\HymnController@loadHymn');
Route::post('/edit-hymn/{hymnId}', 'Admin\HymnController@saveHymn');

Route::get('/sample-pattern/{patternId}', 'Admin\PatternController@samplePattern');
Route::get('/all-sample-patterns', 'Admin\PatternController@allPatterns');

Auth::routes(['verify' => true]);

/**
 * Admin
 */

Route::group(['middleware' => ['admin'], 'prefix' => 'admin'], function() {

    Route::get('/clear-route',function(){
        // clear cache of routes
        Artisan::call("route:cache");
    });

    Route::get('/execute-hinario-id/{id}', function ($id) {
        // execute hinario:preload id command
        Artisan::call('hinario:preload'.' '.$id);
        $output = Artisan::output();
        return $output;
    });

    // user management start

    // users start
    Route::get('/view-users','Admin\UserController@index')->name('users.index');

    // roles
    Route::get('/view-roles','Admin\RoleController@index')->name('roles.index');
    Route::post('/add-roles','Admin\RoleController@store')->name('roles.store');
    Route::post('/update-roles','Admin\RoleController@update')->name('roles.update');
    Route::post('/delete-role','Admin\RoleController@delete')->name('role.delete');

    // Permissions
    Route::get('/view-hinario-permissions','Admin\PermissionController@indexHinarios')->name('permissions.indexHinarios');
    Route::get('/view-person-permissions','Admin\PermissionController@indexPersons')->name('permissions.indexPersons');
    Route::post('/add-permissions','Admin\PermissionController@store')->name('permissions.store');
    Route::post('/update-permissions','Admin\PermissionController@update')->name('permissions.update');
    Route::post('/delete-permission','Admin\PermissionController@delete')->name('permission.delete');
    Route::match(['get' , 'post'],'/view-assign-hinario-permissions','Admin\PermissionController@assignHinarioPermissionsToUser')->name('permission.assignHinarioPermissionsToUser');
    Route::match(['get' , 'post'],'/view-assign-person-permissions','Admin\PermissionController@assignPersonPermissionsToUser')->name('permission.assignPersonPermissionsToUser');
    Route::match(['get' , 'post'],'/assign-hinario-permissions','Admin\PermissionController@assignHinarioPermissions')->name('permission.assignHinarioPermissions');
    Route::match(['get' , 'post'],'/assign-person-permissions','Admin\PermissionController@assignPersonPermissions')->name('permission.assignPersonPermissions');






    // user management end

    Route::get('/enter-hymn', 'Admin\HymnController@show');
    Route::post('/enter-hymn', 'Admin\HymnController@save');
    Route::get('/load-hymn', 'Admin\HymnController@load');
    //Route::post('/edit-hymn', 'Admin\HymnController@save');

    Route::get('/edit-person', 'Admin\PersonController@show');
    Route::post('/edit-person', 'Admin\PersonController@save');

    Route::get('/move-hymn-files', 'Admin\MediaImportController@showMoveHymns');
    Route::post('/move-hymn-files', 'Admin\MediaImportController@moveHymns');
    Route::get('/import-people-audio-files', 'Admin\ImportMediaController@showImportPeopleAudioForm');
    Route::post('/import-people-audio-files', 'Admin\ImportMediaController@importPeople');

    Route::get('/generate-hinario-zip-files', 'Admin\ImportMediaController@showGenerateHinarioRecordingsZipsForm');
    Route::post('/generate-hinario-zip-files', 'Admin\ImportMediaController@generateHinarioRecordingsZips');

    Route::post('/add-media', 'Admin\MediaImportController@addMedia');

    Route::get('/view-pattern/{id?}', 'Admin\PatternController@view');

    Route::get('/edit-musician-files', 'Admin\MusicianResourceController@show');
    Route::post('/edit-musician-files', 'Admin\MusicianResourceController@save');

});

