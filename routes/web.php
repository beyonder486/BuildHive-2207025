<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\Client\DashboardController as ClientDashboard;
use App\Http\Controllers\Client\ProjectController as ClientProject;
use App\Http\Controllers\Freelancer\DashboardController as FreelancerDashboard;
use App\Http\Controllers\Freelancer\ProfileController;
use App\Http\Controllers\Freelancer\ProposalController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Async\AsyncController;
use App\Http\Controllers\AI\AiController;

// ── Public ──
Route::get('/', function () { return view('pages.home'); })->name('home');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/freelancers', [FreelancerController::class, 'index'])->name('freelancers.index');
Route::get('/freelancers/{user}', [FreelancerController::class, 'show'])->name('freelancers.show');

// ── Auth ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Client ──
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboard::class, 'index'])->name('dashboard');
    Route::get('/projects/create', [ClientProject::class, 'create'])->name('projects.create');
    Route::post('/projects', [ClientProject::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ClientProject::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ClientProject::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ClientProject::class, 'destroy'])->name('projects.destroy');
    Route::get('/projects/{project}/manage', [ClientProject::class, 'manage'])->name('projects.manage');
    Route::get('/projects/{project}/proposals', [ClientProject::class, 'proposals'])->name('projects.proposals');
});

// ── Freelancer ──
Route::middleware(['auth', 'role:freelancer'])->prefix('freelancer')->name('freelancer.')->group(function () {
    Route::get('/dashboard', [FreelancerDashboard::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/proposals', [ProposalController::class, 'index'])->name('proposals');
    Route::delete('/proposals/{proposal}', [ProposalController::class, 'destroy'])->name('proposals.destroy');
});
Route::middleware(['auth', 'role:freelancer', 'profile.complete'])->group(function () {
    Route::post('/projects/{project}/proposals', [ProposalController::class, 'store'])->name('proposals.store');
});

// ── Admin ──
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
    Route::delete('/projects/{project}', [AdminController::class, 'destroyProject'])->name('projects.destroy');
});

// ── Async (AJAX) ──
Route::middleware('auth')->prefix('async')->group(function () {
    Route::patch('/tasks/{task}/status', [AsyncController::class, 'updateTaskStatus']);
    Route::patch('/proposals/{proposal}/status', [AsyncController::class, 'updateProposalStatus']);
    Route::patch('/team-members/{member}/status', [AsyncController::class, 'updateTeamMemberStatus']);
    Route::get('/notifications/unread', [AsyncController::class, 'unreadNotifications']);
    Route::patch('/notifications/{notification}/read', [AsyncController::class, 'markNotificationRead']);
    Route::post('/reviews', [AsyncController::class, 'storeReview']);
    Route::post('/tasks', [AsyncController::class, 'storeTask']);
    Route::patch('/tasks/{task}/assign', [AsyncController::class, 'assignTask']);
    Route::delete('/tasks/{task}', [AsyncController::class, 'destroyTask']);
    Route::get('/search/projects', [AsyncController::class, 'searchProjects']);
    Route::patch('/projects/{project}/status', [AsyncController::class, 'updateProjectStatus']);
});

// ── AI (Gemini) ──
Route::middleware(['auth', 'role:client'])->prefix('ai')->name('ai.')->group(function () {
    Route::post('/improve-description', [AiController::class, 'improveDescription'])->name('improve-description');
    Route::post('/generate-tasks',      [AiController::class, 'generateTasks'])->name('generate-tasks');
    Route::post('/recommend-roles',     [AiController::class, 'recommendRoles'])->name('recommend-roles');
});

Route::middleware(['auth', 'role:freelancer'])->prefix('ai')->name('ai.')->group(function () {
    Route::post('/generate-proposal',   [AiController::class, 'generateProposal'])->name('generate-proposal');
});
