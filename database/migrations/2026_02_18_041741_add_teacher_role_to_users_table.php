<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Store existing roles
        $users = DB::table('users')->select('id', 'role')->get();
        
        // Drop the old column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        
        // Add the new column with teacher option
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'counselor', 'admin', 'teacher'])->default('user')->after('email');
        });
        
        // Restore roles
        foreach ($users as $user) {
            DB::table('users')->where('id', $user->id)->update(['role' => $user->role]);
        }
    }

    public function down(): void
    {
        // Store existing roles
        $users = DB::table('users')->select('id', 'role')->get();
        
        // Drop the column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        
        // Add back old column
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'counselor', 'admin'])->default('user')->after('email');
        });
        
        // Restore roles (teachers will become users)
        foreach ($users as $user) {
            $role = $user->role === 'teacher' ? 'user' : $user->role;
            DB::table('users')->where('id', $user->id)->update(['role' => $role]);
        }
    }
};
