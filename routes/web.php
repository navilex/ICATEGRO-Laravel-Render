<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/check-curp/{curp}', [StudentController::class, 'checkCurp'])->name('students.check-curp');

    // Companies Routes
    Route::get('/companies', [\App\Http\Controllers\CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [\App\Http\Controllers\CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies', [\App\Http\Controllers\CompanyController::class, 'store'])->name('companies.store');

    // Convenios Routes
    Route::get('/convenios', [\App\Http\Controllers\ConvenioController::class, 'index'])->name('convenios.index');
    Route::get('/convenios/create', [\App\Http\Controllers\ConvenioController::class, 'create'])->name('convenios.create');
    Route::post('/convenios', [\App\Http\Controllers\ConvenioController::class, 'store'])->name('convenios.store');
    Route::get('/api/convenios/search', [\App\Http\Controllers\ConvenioController::class, 'search'])->name('api.convenios.search');
    // Instructores Routes
    Route::get('/instructores', [\App\Http\Controllers\InstructorController::class, 'index'])->name('instructores.index');
    Route::get('/instructores/create', [\App\Http\Controllers\InstructorController::class, 'create'])->name('instructores.create');
    Route::post('/instructores', [\App\Http\Controllers\InstructorController::class, 'store'])->name('instructores.store');
    Route::get('/instructores/check-curp/{curp}', [\App\Http\Controllers\InstructorController::class, 'checkCurp'])->name('instructores.check-curp');
    Route::get('/instructores/{instructor}/download/{type}', [\App\Http\Controllers\InstructorController::class, 'download'])->name('instructores.download');
    Route::get('/api/instructores/search', [\App\Http\Controllers\InstructorController::class, 'search'])->name('api.instructores.search');

    // Users Routes
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('/users/search-curp/{curp}', [\App\Http\Controllers\UserController::class, 'searchCurp'])->name('users.search-curp');

    // Oferta Educativa Routes
    Route::get('/ofertas-educativas', [\App\Http\Controllers\OfertaEducativaController::class, 'index'])->name('ofertas-educativas.index');
    Route::post('/ofertas-educativas', [\App\Http\Controllers\OfertaEducativaController::class, 'store'])->name('ofertas-educativas.store');

    // Campos de Formación Profesional Routes
    Route::get('/campos-formacion', [\App\Http\Controllers\CampoFormacionController::class, 'index'])->name('campos-formacion.index');
    Route::post('/campos-formacion', [\App\Http\Controllers\CampoFormacionController::class, 'store'])->name('campos-formacion.store');

    // Especialidades Ocupacionales Routes
    Route::get('/especialidades-ocupacionales', [\App\Http\Controllers\EspecialidadOcupacionalController::class, 'index'])->name('especialidades-ocupacionales.index');
    Route::post('/especialidades-ocupacionales', [\App\Http\Controllers\EspecialidadOcupacionalController::class, 'store'])->name('especialidades-ocupacionales.store');
    Route::get('/api/campos-by-oferta/{ofertaId}', [\App\Http\Controllers\EspecialidadOcupacionalController::class, 'getCamposByOferta']);

    // Cursos Routes
    Route::get('/cursos', [\App\Http\Controllers\CursoController::class, 'index'])->name('cursos.index');
    Route::post('/cursos', [\App\Http\Controllers\CursoController::class, 'store'])->name('cursos.store');
    Route::get('/api/especialidades-by-campo/{campoId}', [\App\Http\Controllers\CursoController::class, 'getEspecialidadesByCampo']);

    // Cursos ICATEGRO Routes
    Route::get('/cursos-icategro', [\App\Http\Controllers\CursoIcategroController::class, 'index'])->name('cursos-icategro.index');
    Route::post('/cursos-icategro', [\App\Http\Controllers\CursoIcategroController::class, 'store'])->name('cursos-icategro.store');

    // Consultar Oferta Educativa Routes
    Route::get('/consulta-oferta', [\App\Http\Controllers\ConsultaOfertaController::class, 'index'])->name('consulta-oferta.index');
    Route::get('/api/consulta-oferta/{ofertaId}', [\App\Http\Controllers\ConsultaOfertaController::class, 'getCursosByOferta']);

    // Planteles Routes
    Route::get('/planteles', [\App\Http\Controllers\PlantelController::class, 'index'])->name('planteles.index');
    Route::post('/planteles', [\App\Http\Controllers\PlantelController::class, 'store'])->name('planteles.store');

    // Grupos Routes
    Route::get('/grupos/create', [\App\Http\Controllers\GrupoController::class, 'create'])->name('grupos.create');
    Route::post('/grupos', [\App\Http\Controllers\GrupoController::class, 'store'])->name('grupos.store');
    Route::get('/api/grupos/campos-formacion/{ofertaId}', [\App\Http\Controllers\GrupoController::class, 'getCamposFormacion']);
    Route::get('/api/grupos/especialidades/{campoId}', [\App\Http\Controllers\GrupoController::class, 'getEspecialidades']);
    Route::get('/api/grupos/cursos/{especialidadId}/{tipo}', [\App\Http\Controllers\GrupoController::class, 'getCursos']);

    // Consultar Planteles Routes
    Route::get('/consulta-planteles', [\App\Http\Controllers\ConsultaPlantelController::class, 'index'])->name('consulta-planteles.index');
});