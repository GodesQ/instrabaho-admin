<?php

namespace App\Http\Controllers\Web;

use App\Enum\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query();

            $users = $users->whereHas('roles', function ($query) {
                $query->whereIn('name', [RoleEnum::WORKER, RoleEnum::CLIENT]);
            });

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('name', function (User $user) {
                    return $user->first_name . " " . $user->last_name;
                })
                ->addColumn('roles', function (User $user) {
                    $output = "<div class='d-flex flex-wrap gap-1'>";

                    $userRoles = $user->getRoleNames();

                    if ($userRoles->count() > 0) {
                        foreach ($userRoles as $key => $userRole) {
                            $output .= '<div class="badge bg-secondary">' . ($userRole ?? '') . '</div>';
                        }
                    }


                    $output .= "</div>";

                    return $output;
                })
                ->editColumn("created_at", function ($user) {
                    return Carbon::parse($user->created_at)->format("M d, Y h:i A");
                })
                ->addColumn('action', function ($user) {
                    return $this->generateDropdown($user);
                })
                ->rawColumns(['action', 'roles'])
                ->make(true);
        }

        return view('pages.users.users');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function generateDropdown(User $user)
    {
        // Fetch user roles (eager loading for performance)
        // $roles = $user->roles()->with('role')->get()->pluck('role.name')->toArray();
        $roles = $user->getRoleNames()->toArray();

        // Initialize the dropdown menu content
        $dropdownContent = '<ul class="list-inline hstack mb-0">
                                <li class="list-inline-item edit" title="Edit">
                                    <div class="dropdown">
                                        <button class="btn btn-link text-muted text-decoration-none p-0 fs-15"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="ri-more-2-fill"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">';

        // Always show the "View" link
        $dropdownContent .= '<a class="dropdown-item" href="apps-projects-overview">
                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                             </a>';

        // Conditionally show "Edit as Worker" if the user has the "worker" role
        if (in_array('worker', $roles)) {
            $dropdownContent .= '<a class="dropdown-item" href="' . route('workers.edit', $user->id) . '">
                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit as Worker
                                 </a>';
        } else {
            $dropdownContent .= '<a class="dropdown-item" href="' . route('workers.create') . '">
                                    <i class="ri-add-circle-fill align-bottom me-2 text-muted"></i> Create as Worker
                                 </a>';
        }

        // Conditionally show "Edit as Customer" if the user has the "customer" role
        if (in_array('client', $roles)) {
            $dropdownContent .= '<a class="dropdown-item" href="' . route('customers.edit', $user->id) . '">
                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit as Customer
                                 </a>';
        } else {
            $dropdownContent .= '<a class="dropdown-item" href="' . route('customers.create') . "?user_id=" . $user->id . '">
                                    <i class="ri-add-circle-fill align-bottom me-2 text-muted"></i> Create as Customer
                                 </a>';
        }

        // Close the dropdown structure
        $dropdownContent .= '</div>
                            </div>
                        </li>
                        <li class="list-inline-item" title="Remove">
                            <a href="#" class="text-danger btn p-0 d-inline-block remove-item-btn" id="' . $user->id . '">
                                <i class="ri-delete-bin-5-fill fs-16"></i>
                            </a>
                        </li>
                    </ul>';

        return $dropdownContent;
    }
}
