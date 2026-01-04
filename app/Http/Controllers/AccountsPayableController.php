<?php

namespace App\Http\Controllers;

use App\Models\AccountsPayable;

class AccountsPayableController extends Controller
{
  public function index()
  {
    $aps = AccountsPayable::with(['supplier', 'purchaseOrder'])
      ->latest()
      ->get();

    return view('accounts-payables.index', compact('aps'));
  }

  public function show($id)
  {
    $accountsPayable = AccountsPayable::with(['supplier', 'purchaseOrder', 'goodsReceipt'])
      ->findOrFail($id);

    return view('accounts-payables.show', compact('accountsPayable'));
  }
}
