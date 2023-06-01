<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'user-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'user-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'user-show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'user-update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'user-delete',
                'guard_name' => 'web',
            ],
            [
                'name' => 'ticket-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'ticket-edit-update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'ticket-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'ticket-index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'forwarded-ticket-index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'backwarded-ticket-index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'ticket-delete',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-team-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-team-edit-update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-team-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-team-index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-team-delete',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-complain-type-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-complain-type-edit-update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-complain-type-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-complain-type-index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-complain-type-delete',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-solution-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-solution-edit-update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-solution-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-solution-index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-solution-delete',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-complain-source-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-complain-source-edit-update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-complain-source-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-complain-source-index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-complain-source-delete',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-client-send-email',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-client-send-sms',
                'guard_name' => 'web',
            ],
            [
                'name' => 'client-link-search',
                'guard_name' => 'web',
            ],
            [
                'name' => 'user-search',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-ticket-remark-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-ticket-accept',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-ticket-reopen',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-ticket-close',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-ticket-super-close',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-ticket-handover',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-ticket-forward',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-ticket-backward',
                'guard_name' => 'web',
            ],
            [
                'name' => 'support-ticket-team-search',
                'guard_name' => 'web',
            ],
            [
                'name' => 'receive-email-when-ticket-forwarded',
                'guard_name' => 'web',
            ],
            [
                'name' => 'receive-email-when-ticket-handovered',
                'guard_name' => 'web',
            ],
            [
                'name' => 'receive-email-when-ticket-backwarded',
                'guard_name' => 'web',
            ],
            [
                'name' => 'receive-sms-when-ticket-forwarded',
                'guard_name' => 'web',
            ],
            [
                'name' => 'receive-sms-when-ticket-handovered',
                'guard_name' => 'web',
            ],
            [
                'name' => 'receive-sms-when-ticket-backwarded',
                'guard_name' => 'web',
            ],
            [
                'name' => 'receive-in-app-notification-when-ticket-forwarded',
                'guard_name' => 'web',
            ],
            [
                'name' => 'receive-in-app-notification-when-ticket-handovered',
                'guard_name' => 'web',
            ],
            [
                'name' => 'receive-in-app-notification-when-ticket-backwarded',
                'guard_name' => 'web',
            ],
            [
                'name' => 'receive-in-app-notification-when-ticket-forwarded-ticket-accepted',
                'guard_name' => 'web',
            ],
            [
                'name' => 'bulk-email-send',
                'guard_name' => 'web',
            ],
            [
                'name' => 'feedback-list',
                'guard_name' => 'web',
            ],
            [
                'name' => 'courier-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'courier-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'courier-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'courier-delete',
                'guard_name' => 'web',
            ], [
                'name' => 'scm-comparative-statement-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-comparative-statement-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-comparative-statement-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-comparative-statement-delete',
                'guard_name' => 'web',
            ], [
                'name' => 'scm-purchase-order-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-purchase-order-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-purchase-order-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-purchase-order-delete',
                'guard_name' => 'web',
            ], [
                'name' => 'scm-indent-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-indent-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-indent-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-indent-delete',
                'guard_name' => 'web',
            ], [
                'name' => 'scm-challan-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-challan-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-challan-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-challan-delete',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-err-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-err-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-err-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-err-delete',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-gate-pass-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-gate-pass-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-gate-pass-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-gate-pass-delete',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-mir-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-mir-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-mir-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-mir-delete',
                'guard_name' => 'web',
            ], [
                'name' => 'scm-mur-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-mur-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-mur-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-mur-delete',
                'guard_name' => 'web',
            ], [
                'name' => 'scm-prs-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-prs-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-prs-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-prs-delete',
                'guard_name' => 'web',
            ], [
                'name' => 'scm-requisition-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-requisition-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-requisition-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-requisition-delete',
                'guard_name' => 'web',
            ], [
                'name' => 'scm-wcr-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-wcr-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-wcr-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-wcr-delete',
                'guard_name' => 'web',
            ], [
                'name' => 'scm-wcrr-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-wcrr-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-wcrr-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'scm-wcrr-delete',
                'guard_name' => 'web',
            ], [
                'name' => 'supplier-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'supplier-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'supplier-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'supplier-delete',
                'guard_name' => 'web',
            ], [
                'name' => 'unit-view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'unit-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'unit-edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'unit-delete',
                'guard_name' => 'web',
            ],


        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission['name']);
        }
    }
}
