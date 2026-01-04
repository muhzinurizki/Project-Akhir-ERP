<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseRequest;

class PurchaseRequestApprovalSeeder extends Seeder
{
    public function run(): void
    {
        $pr = PurchaseRequest::where('status', 'DRAFT')->first();

        if (!$pr) {
            throw new \RuntimeException('PR Approval Seeder: Tidak ada PR DRAFT.');
        }

        $pr->update([
            'status' => 'APPROVED',
        ]);
    }
}
