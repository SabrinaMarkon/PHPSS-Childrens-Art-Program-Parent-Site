<?php
if (isset($showupdate))
{
    echo $showupdate;
}
$alltransactions = new Money();
$transactions = $alltransactions->getAllTransactions();
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h1 class="ja-bottompadding">Add New Transaction Record</h1>

            <form action="/admin/money" method="post" accept-charset="utf-8" class="form" role="form">

                <label class="sr-only" for="username">Username</label>
                <input type="text" name="username" value="" class="form-control input-lg" placeholder="Username">

                <label class="sr-only" for="transaction">Transaction</label>
                <input type="text" name="transaction" value="" class="form-control input-lg" placeholder="Transaction ID">

                <label class="sr-only" for="description">Description</label>
                <input type="text" name="description" value="" class="form-control input-lg" placeholder="Description">

                <label class="sr-only" for="amount">Amount</label>
                <input type="number" name="amount" value="" class="form-control input-lg" placeholder="Amount" step="0.01">

                <div class="form-group pull-left">
                    <label class="sr-only" for="datepaid">Date</label>
                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="datepaid" data-link-format="yyyy-mm-dd" placeholder="Date of Transaction (YYYY-MM-DD)">
                        <input class="form-control input-lg datepicker" size="16" type="text" value="" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                    <div class="col-md-7"></div>
                    <input type="hidden" name="datepaid" id="datepaid" value="" />
                </div>

                <div class="ja-bottompadding"></div>

                <button class="btn btn-lg btn-primary" type="submit" name="addtransaction">Create Transaction Record</button>

            </form>

            <div class="ja-bottompadding2"></div>

            <h1 class="ja-bottompadding">Transaction Records</h1>

            <div class="table-responsive">
                <table class="table table-condensed table-bordered text-center">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">UserID</th>
                        <th class="text-center">Transaction</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Date Paid</th>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Delete</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($transactions as $transaction) {

                    $date = new DateTime($transaction['datepaid']);
                    $datepaid = $date->format('Y-m-d');
                    ?>
                    <tr>
                        <form action="/admin/money/<?php echo $transaction['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
                        <td><?php echo $transaction['id']; ?>
                        </td>
                        <td>
                            <label class="sr-only" for="username">Username:</label>
                            <input type="text" name="username" value="<?php echo $transaction['username']; ?>" class="form-control input-md" size="40" placeholder="Username">
                        </td>
                        <td>
                            <label class="sr-only" for="transaction">Transaction ID:</label>
                            <input type="text" name="transaction" value="<?php echo $transaction['transaction']; ?>" class="form-control input-md" size="60" placeholder="Transaction ID">
                        </td>
                        <td>
                            <label class="sr-only" for="description">Description:</label>
                            <input type="text" name="description" value="<?php echo $transaction['description']; ?>" class="form-control input-md" size="60" placeholder="Description">
                        </td>
                        <td>
                            <label class="sr-only" for="amount">Amount:</label>
                            <input type="number" name="amount" value="<?php echo $transaction['amount']; ?>" class="form-control input-md" placeholder="Amount" step="0.01">
                        </td>
                        <td>
                            <div class="form-group">
                                <div class="input-group date form_date_existing_edit" data-date="" data-date-format="yyyy-mm-dd" data-link-field="datepaid<?php echo $transaction['id']; ?>" data-link-format="yyyy-mm-dd" placeholder="Date of Transaction (YYYY-MM-DD)">
                                    <input class="form-control input-md datepicker" size="16" type="text" placeholder="<?php echo $datepaid ?>" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <input type="hidden" name="datepaid<?php echo $transaction['id']; ?>" id="datepaid<?php echo $transaction['id']; ?>" value="<?php echo $transaction['datepaid']; ?>" />
                            </div>
                        </td>
                        <td>
                            <input type="hidden" name="_method" value="PATCH">
                            <button class="btn btn-md btn-primary" type="submit" name="savetransaction">SAVE</button>
                        </td>
                        </form>
                        <td>
                            <form action="/admin/money/<?php echo $transaction['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-md btn-primary" type="submit" name="deletetransaction">DELETE</button>
                            </form>
                        </form>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>

                    </tbody>
                </table>
            </div>

            <div class="ja-bottompadding"></div>

        </div>
    </div>
</div>