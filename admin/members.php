<?php
include "control.php";
if (isset($showupdate))
{
    echo $showupdate;
}
$allmembers = new Member();
$members = $allmembers->getAllMembers();
$countrylist = new Countries();
$referidlist = new Referid();
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">

            <h1 class="ja-bottompadding">Add New Member</h1>

            <form action="/admin/members" method="post" accept-charset="utf-8" class="form" role="form">

                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <label class="sr-only" for="firstname">First Name</label>
                        <input type="text" name="firstname" value="" class="form-control input-lg" placeholder="First Name">
                    </div>
                    <div class="col-xs-6 col-md-6">
                        <label class="sr-only" for="lastname">Last Name</label>
                        <input type="text" name="lastname" value="" class="form-control input-lg" placeholder="Last Name">
                    </div>
                </div>

                <label class="sr-only" for="email">Email</label>
                <input type="text" name="email" value="" class="form-control input-lg" placeholder="Your Email">

                <label class="sr-only" for="username">Username</label>
                <input type="text" name="username" value="" class="form-control input-lg" placeholder="Username">

                <label class="sr-only" for="password">Password</label>
                <input type="password" name="password" value="" class="form-control input-lg" placeholder="Password">

                <label class="sr-only" for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" value="" class="form-control input-lg" placeholder="Confirm Password">

                <label class="sr-only" for="country">Country</label>
                <select name="country" class="form-control input-lg">
                    <option value="United States">United States</option>
                    <option value="Canada">Canada</option>
                    <?php
                    $country = '';
                    echo $countrylist->showCountries($country);
                    ?>
                </select>

                <label class="sr-only" for="referid">Sponsor</label>
                <select name="referid" class="form-control input-lg">
                    <option value="">None</option>
                    <?php
                    $referid = '';
                    echo $referidlist->showReferids($referid);
                    ?>
                </select>

                <div class="ja-bottompadding"></div>

                <button class="btn btn-lg btn-primary" type="submit" name="addmember">Create Account</button>

            </form>

            <div class="ja-bottompadding2"></div>

            <h1 class="ja-bottompadding">Website Members</h1>

            <div class="table-responsive">
                <table class="table table-condensed table-bordered text-center small">
                    <thead>
                    <tr>
                        <th class="text-center small"></th>
                        <th class="text-center small">#</th>
                        <th class="text-center small">Username</th>
                        <th class="text-center small">Password</th>
                        <th class="text-center small">First Name</th>
                        <th class="text-center small">Last Name</th>
                        <th class="text-center small">Email</th>
                        <th class="text-center small">Verified</th>
                        <th class="text-center small">Date Verified</th>
                        <th class="text-center small">Country</th>
                        <th class="text-center small">Signup Date</th>
                        <th class="text-center small">Signup IP</th>
                        <th class="text-center small">Last Login</th>
                        <th class="text-center small">Commission</th>
                        <th class="text-center small">Sponsor</th>
                        <th class="text-center small">Edit</th>
                        <th class="text-center small">Delete</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($members as $member) {

                        $signupdate = new DateTime($member['signupdate']);
                        $datesignedup = $signupdate->format('Y-m-d');

                        $verifieddate = new DateTime($member['verifieddate']);
                        if($member['verifieddate'] === NULL){ $dateverified = 'Not Yet'; } else { $dateverified = $verifieddate->format('Y-m-d'); }

                        $lastlogin = new DateTime($member['lastlogin']);
                        if($member['lastlogin'] === NULL){ $datelastlogin = 'Not Yet'; } else { $datelastlogin = $lastlogin->format('Y-m-d'); }
                        ?>
                        <tr>
                            <form action="/admin/members/<?php echo $member['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
                            <td class="small">
                                <div class="text-center">
                                    <?php
                                    echo $allmembers->getGravatar($member['username'], $member['email']);
                                    ?>
                                </div>
                            </td>
                            <td class="small"><?php echo $member['id']; ?>
                            </td>
                            <td>
                                <label class="sr-only" for="username">Username:</label>
                                <input type="text" name="username" value="<?php echo $member['username']; ?>" class="form-control input-sm small" size="40" placeholder="Username">
                            </td>
                            <td>
                                <label class="sr-only" for="password">Password:</label>
                                <input type="text" name="password" value="<?php echo $member['password']; ?>" class="form-control input-sm small" size="40" placeholder="Password">
                            </td>
                            <td>
                                <label class="sr-only" for="firstname">First Name:</label>
                                <input type="text" name="firstname" value="<?php echo $member['firstname']; ?>" class="form-control input-sm small" size="40" placeholder="First Name">
                            </td>
                            <td>
                                <label class="sr-only" for="lastname">Last Name:</label>
                                <input type="text" name="lastname" value="<?php echo $member['lastname']; ?>" class="form-control input-sm small" size="40" placeholder="Last Name">
                            </td>
                            <td>
                                <label class="sr-only" for="email">Email:</label>
                                <input type="text" name="email" value="<?php echo $member['email']; ?>" class="form-control input-sm small" size="60" placeholder="Email">
                            </td>
                            <td>
                                <label class="sr-only" for="verified">Verified:</label>
                                <select name="verified" class="form-control input-md">
                                    <option value="yes"<?php if ($member['verified'] === 'yes') { echo " selected"; } ?>>yes</option>
                                    <option value="no"<?php if ($member['verified'] !== 'yes') { echo " selected"; } ?>>no</option>
                                </select>
                            </td>
                            <td class="small">
                                <?php echo $dateverified ?>
                            </td>
                            <td>
                                <label class="sr-only" for="country">Country:</label>
                                <select name="country" class="form-control input-md">
                                    <option value="United States"<?php if ($member['country'] == "United States") { echo " selected"; } ?> >United States</option>
                                    <option value="Canada"<?php if ($member['country'] === "Canada") { echo " selected"; } ?>>Canada</option>
                                    <?php
                                    echo $countrylist->showCountries($member['country']);
                                    ?>
                                </select>
                            </td>
                            <td class="small">
                                <?php echo $datesignedup ?>
                            </td>
                            <td>
                                <label class="sr-only" for="signupip">IP:</label>
                                <input type="text" name="signupip" value="<?php echo $member['signupip']; ?>" class="form-control input-sm small" size="60" placeholder="IP">
                            </td>
                            <td class="small">
                                <?php echo $datelastlogin ?>
                            </td>
                            <td>
                                <label class="sr-only" for="commission">Commission:</label>
                                <input type="number" name="commission" value="<?php echo $member['commission']; ?>" class="form-control input-sm small" size="12" placeholder="Commission" min="0.00" step="0.01">
                            </td>
                            <td>
                                <label class="sr-only" for="referid">Sponsor:</label>
                                <select name="referid" class="form-control input-sm">
                                    <option value="">None</option>
                                    <?php
                                    $referid = '';
                                    echo $referidlist->showReferids($member['referid']);
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="_method" value="PATCH">
                                <button class="btn btn-sm btn-primary" type="submit" name="savemember">SAVE</button>
                            </td>
                            </form>
                            <td>
                                <form action="/admin/members/<?php echo $member['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="username" value="<?php echo $member['username']; ?>">
                                    <button class="btn btn-sm btn-primary" type="submit" name="deletemember">DELETE</button>
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