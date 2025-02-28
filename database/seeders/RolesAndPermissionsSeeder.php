<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            RoleEnum::GUEST,
            RoleEnum::CLIENT,
            RoleEnum::WORKER,
            RoleEnum::DEVELOPER,
            RoleEnum::DATA_ANALYST,
            RoleEnum::CUSTOMER_SUPPORT,
            RoleEnum::ADMIN,
            RoleEnum::SUPER_ADMIN
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        $permissions = [
            'worker_permissions' => [
                'create-worker',
                'edit-worker',
                'delete-worker',
                'view-worker',
            ],
            'client_permissions' => [
                'create-client',
                'edit-client',
                'delete-client',
                'view-client',
            ],
            'worker_personal_document_permissions' => [
                'upload-worker-personal-document',
                'edit-worker-personal-document',
                'delete-worker-personal-document',
                'view-worker-personal-document',
            ],
            'worker_certificate_permissions' => [
                'upload-worker-certificate',
                'edit-worker-certificate',
                'delete-worker-certificate',
                'view-worker-certificate',
            ],
            'service_category_permissions' => [
                'create-service-category',
                'edit-service-category',
                'delete-service-category',
                'view-service-category',
            ],
            'service_permissions' => [
                'create-service',
                'edit-service',
                'delete-service',
                'view-service',
            ],
            'job_post_permissions' => [
                'create-job-post',
                'edit-job-post',
                'delete-job-post',
                'view-job-post',
            ],
            'job_proposal_permissions' => [
                'create-job-proposal',
                'edit-job-proposal',
                'delete-job-proposal',
                'view-job-proposal',
            ],
            'user_wallet_permissions' => [
                'create-user-wallet',
                'edit-user-wallet',
                'delete-user-wallet',
                'view-user-wallet',
            ],
            'job_contract_permissions' => [
                'create-job-contract',
                'edit-job-contract',
                'delete-job-contract',
                'view-job-contract',
            ],
            'client_review_permissions' => [
                'create-client-review',
                'edit-client-review',
                'delete-client-review',
                'view-client-review',
            ],
            'worker_review_permissions' => [
                'create-worker-review',
                'edit-worker-review',
                'delete-worker-review',
                'view-worker-review',
            ],
            'notification_permissions' => [
                'create-notification',
                'edit-notification',
                'delete-notification',
                'view-notification',
            ],
        ];
    }
}
