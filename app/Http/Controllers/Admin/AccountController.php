<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function App\CPU\translate;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    public function account_list(Request $request)
    {
        $data['accounts'] = DB::table('accounts')->orderBy('id', 'DESC')->paginate(5);
        return view('admin-views.accounts.account_list', $data);
    }
    public function account_add(Request $request)
    {
        return view('admin-views.accounts.account_add');
    }
    public function account_store(Request $request)
    {
        // dd($request->all());
        try {
            $data = [
                "account_no" => $request->account_no,
                "name" => $request->name,
                "balance" => $request->balance,
                "note" => $request->note,
            ];
            DB::table('accounts')->insert($data);
            Toastr::success(translate('Account Add successfully'));
            return redirect()->route('admin.account.account_list');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function account_edit($id)
    {
        $data['account'] = DB::table('accounts')
            ->where('id', $id)
            ->first();
        return view('admin-views.accounts.account_edit', $data);
    }
    public function account_update(Request $request)
    {
        try {

            $data = [
                "account_no" => $request->account_no,
                "name" => $request->name,
                "balance" => $request->balance,
                "note" => $request->note,
                "updated_at" => NOW(),
            ];
            DB::table('accounts')->where('id', $request->account_id)->update($data);
            Toastr::success(translate('Account update successfully'));
            return redirect()->route('admin.account.account_list');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function account_delete($id)
    {
        DB::table('accounts')->where('id', $id)->delete();
        Toastr::success(translate('Account Delete successfully'));
        return redirect()->route('admin.account.account_list');
    }
    public function transaction_list(Request $request)
    {
        $data['transaction'] = DB::table('transaction_history')
            ->leftjoin('users', 'transaction_history.customer_id', 'users.id')
            ->leftjoin('accounts', 'accounts.id', 'transaction_history.account_id')
            ->select('transaction_history.*', 'users.*', 'transaction_history.id as txn_id', 'accounts.account_no as acc_num')
            ->orderBy('transaction_history.id', 'DESC')->paginate(5);
        return view('admin-views.accounts.transaction_list', $data);
    }
    public function transaction_add(Request $request)
    {
        $data['customer'] = DB::table('users')->get();
        $data['accounts'] = DB::table('accounts')->get();
        return view('admin-views.accounts.transaction_add', $data);
    }
    public function transaction_store(Request $request)
    {
        //dd($request->all());
        $accounts = DB::table('accounts')->where('id', $request->account_no)->first();
        $balance = 0;
        try {
            $data = [
                "customer_id" => $request->cust_id,
                "co" => $request->co,
                "account_id" => $accounts->id,
                "account_no" => $accounts->account_no,
                "date" => $request->txn_dt,
                "amount" => $request->amount,
                "type" => $request->type,
                "category" => $request->category,
                "method" => $request->method,
                "note" => $request->note,
            ];
            //income add
            if ($request->type == 'Income') {
                $balance = $accounts->balance + $request->amount;
            }
            //expense sub
            else {
                $balance = $accounts->balance - $request->amount;
            }
            DB::table('transaction_history')->insert($data);
            DB::table('accounts')
                ->where('id', $request->account_no)
                ->update(["balance" => $balance, "updated_at" => NOW()]);
            Toastr::success(translate('Transaction Add successfully'));
            return redirect()->route('admin.account.transaction_list');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function transaction_edit($id)
    {
        $data['txn_data'] = DB::table('transaction_history')
            ->where('id', $id)
            ->first();
        $data['customer'] = DB::table('users')->get();
        $data['accounts'] = DB::table('accounts')->get();
        return view('admin-views.accounts.transaction_edit', $data);
    }
    public function transaction_update(Request $request)
    {
        //dd($request->all());
        try {
            $accounts = DB::table('accounts')->where('id', $request->account_no)->first();
            $data = [
                "customer_id" => $request->cust_id,
                "co" => $request->co,
                "account_id" => $accounts->id,
                "account_no" => $request->account_no,
                "date" => $request->txn_dt,
                "amount" => $request->amount,
                "type" => $request->type,
                "category" => $request->category,
                "method" => $request->method,
                "note" => $request->note,
            ];
            DB::table('transaction_history')->where('id', $request->txn_id)->update($data);
            Toastr::success(translate('Transaction update successfully'));
            return redirect()->route('admin.account.transaction_list');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function transaction_delete($id)
    {
        DB::table('transaction_history')->where('id', $id)->delete();
        Toastr::success(translate('Transaction Delete successfully'));
        return redirect()->route('admin.account.transaction_list');
    }
    public function transfer_list(Request $request)
    {
        $data['transfer'] = DB::table('transfer_history')
            ->orderBy('id', 'DESC')->paginate(5);
        return view('admin-views.accounts.transfer_list', $data);
    }
    public function transfer_add(Request $request)
    {
        $data['accounts'] = DB::table('accounts')->get();
        return view('admin-views.accounts.transfer_add', $data);
    }
    public function transfer_store(Request $request)
    {
        //dd($request->all());
        try {
            if ($request->from_account == $request->to_account) {
                Toastr::error(translate('Same account for tansfer not allowed'));
                return redirect()->route('admin.account.transfer_add');
            }
            $accounts_from = DB::table('accounts')
                ->where('id', $request->from_account)
                ->select('account_no', 'name', 'balance')
                ->first();
            $accounts_to = DB::table('accounts')
                ->where('id', $request->to_account)
                ->select('account_no', 'name', 'balance')
                ->first();
            $new_balance = 0.00;
            if ($request->amount >= $accounts_from->balance) {
                Toastr::error(translate('Your Account have not enough balance'));
                return redirect()->route('admin.account.transfer_add');
            } else {
                $new_balance = $accounts_from->balance - $request->amount;
                $to_balance = $accounts_to->balance + $request->amount;
                $data = [
                    "from_account_id" => $request->from_account,
                    "from_account" => $accounts_from->account_no,
                    "to_account_id" => $request->to_account,
                    "to_account" => $accounts_to->account_no,
                    "amount" => $request->amount,
                ];
                DB::table('transfer_history')->insert($data);
                //from account
                DB::table('accounts')
                    ->where('id', $request->from_account)
                    ->update(['balance' => $new_balance]);
                //to account
                DB::table('accounts')
                    ->where('id', $request->to_account)
                    ->update(['balance' => $to_balance]);
                Toastr::success(translate('Transfer Add successfully'));
                return redirect()->route('admin.account.transfer_list');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function transfer_edit($id)
    {
        $data['transfer'] = DB::table('transfer_history')
            ->where('id', $id)
            ->first();
        $data['accounts'] = DB::table('accounts')->get();
        return view('admin-views.accounts.transfer_edit', $data);
    }
    public function transfer_update(Request $request)
    {
        try {
            if ($request->from_account == $request->to_account) {
                Toastr::error(translate('Same account for tansfer not allowed'));
                return redirect()->route('admin.account.transfer_list');
            }
            $accounts = DB::table('accounts')
                ->where('id', $request->from_account)
                ->select('account_no', 'name', 'balance')
                ->first();
            $accounts_to = DB::table('accounts')
                ->where('id', $request->to_account)
                ->select('account_no', 'name', 'balance')
                ->first();
            $new_balance = 0.00;
            if ($request->amount >= $accounts->balance) {
                Toastr::error(translate('Your Account have not enough balance'));
                return redirect()->route('admin.account.transfer_edit');
            } else {
                $new_balance = $accounts->balance - $request->amount;
                $to_balance = $accounts_to->balance + $request->amount;
                $data = [
                    "from_account_id" => $request->from_account,
                    "from_account" => $accounts->account_no,
                    "to_account_id" => $request->to_account,
                    "to_account" => $accounts_to->account_no,
                    "amount" => $request->amount,
                ];
                DB::table('transfer_history')->where('id', $request->transfer_id)->update($data);
                //from
                DB::table('accounts')
                    ->where('id', $request->from_account)
                    ->update(['balance' => $new_balance]);
                //to account
                DB::table('accounts')
                    ->where('id', $request->to_account)
                    ->update(['balance' => $to_balance]);
                Toastr::success(translate('Transfer Edit successfully'));
                return redirect()->route('admin.account.transfer_list');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function transfer_delete($id)
    {
        DB::table('transfer_history')->where('id', $id)->delete();
        Toastr::success(translate('Transer Delete successfully'));
        return redirect()->route('admin.account.transfer_list');
    }
}
