<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class AccountController extends Controller
{
    public function index(): JsonResponse
    {
        Log::info('Fetching accounts list.');
        $accounts = Account::paginate(10);
        return response()->json($accounts);
    }

    public function store(AccountStoreRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            Log::info('Creating a new account.');

            // Check for duplicate login
            if (Account::where('login', $request->login)->exists()) {
                Log::warning('Duplicate login detected.', ['login' => $request->login]);
                return response()->json(['message' => 'Login already exists.'], 400);
            }

            // Check for duplicate phone
            if (Account::where('phone', $request->phone)->exists()) {
                Log::warning('Duplicate phone detected.', ['phone' => $request->phone]);
                return response()->json(['message' => 'Phone number already exists.'], 400);
            }

            $account = Account::create($request->validated());
            DB::commit();
            Log::info('Account created successfully.', ['account_id' => $account->id]);
            return response()->json(['message' => 'Account created successfully.'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create account.', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to create account.'], 500);
        }
    }

    public function show(Account $account): JsonResponse
    {
        Log::info('Displaying account details.', ['account_id' => $account->id]);
        return response()->json($account);
    }

    public function update(AccountUpdateRequest $request, Account $account)
    {
        DB::beginTransaction();
        try {
            Log::info('Updating account.', ['account_id' => $account->id]);
            $account->update($request->validated());
            DB::commit();
            Log::info('Account updated successfully.', ['account_id' => $account->id]);
            return response()->json(['message' => 'Account updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update account.', ['account_id' => $account->id, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to update account.'], 500);
        }
    }

    public function destroy(Account $account)
    {
        DB::beginTransaction();
        try {
            Log::info('Deleting account.', ['account_id' => $account->id]);
            $account->delete();
            DB::commit();
            Log::info('Account deleted successfully.', ['account_id' => $account->id]);
            return response()->json(['message' => 'Account deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete account.', ['account_id' => $account->id, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to delete account.'], 500);
        }
    }
}
