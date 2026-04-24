<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set role_id = 0 for users who are not the main Super Admin (id=1) and have NULL role_id
        // This targets users who registered before the role_id = 0 logic was implemented.
        \App\Models\User::whereNull('role_id')
            ->where('id', '!=', 1)
            ->update(['role_id' => 0]);

        // Also, if any 'customer' role existed in the roles table, update users assigned to it
        $customerRole = \App\Models\Role::where('name', 'customer')->orWhere('slug', 'customer')->first();
        if ($customerRole) {
            \App\Models\User::where('role_id', $customerRole->id)
                ->update(['role_id' => 0]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
