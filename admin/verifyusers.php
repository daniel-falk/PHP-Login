<?php
/**
* Page that allows admins to verify or delete new (unverified) users
**/
$pagetype = 'adminpage';
$title = 'Admin Verification';
require '../login/partials/pagehead.php';

$auth = new AuthorizationHandler;

$new_users = UserData::userVerifyList();
$active_users = UserData::userActiveList();

$x = 0;
?>
    <div class="container-fluid">

        <h3>Verify/Delete User Requests</h3>
<?php
if (!empty($new_users)) {
?>
        <table id="userlist" class="table table-sm">
            <thead class="headrow">
                <th>Username</th>
                <th>Email</th>
                <th>Timestamp</th>
                <th>
                    <button class="btn btn-info btn-sm pull-right">Select All</button>
                    <input type="checkbox" id="selectAll" hidden></input>
                </th>
            </thead>
<?php 
    foreach($new_users as $user){
        $x++;
        $ver_user = 'verifyUser(\''.$user['id'].'\',\''.$user['email'].'\',\''.$user['username'].'\',\''.$x.'\');';
        $del_user = 'deleteUser(\''.$user['id'].'\',\''.$user['email'].'\',\''.$user['username'].'\',\''.$x.'\');';
?>
            <tr class="datarow" scope="row" id="row<?=$x?>">
                <td><?=$user['username']?></td>
                <td><?=$user['email']?></td>
                <td><?=$user['timestamp']?></td>
                <td>
                    <button id="verbutton<?=$x?>" class="btn btn-success btn-sm btn-fixed pull-right" onclick="<?=$ver_user?>">Verify</button>
                    <button id="delbutton<?=$x?>" class="btn btn-danger btn-sm btn-fixed pull-right" onclick="<?=$del_user?>">Delete</button>
                    <input class="newuser" type="checkbox" value="<?=$user['id']?>" id="<?=$x?>" hidden></input>
                </td>
            </tr>
<?php
    }
?>
        </table>
        <button id="verAll" class="btn btn-success" onclick="verifyAll();">Verify Selected</button>
<?php
} else {
?>
        <p class="message">No new user requests!</p>
<?php
}
?>
        <br />
        <br />
        <h3>Active Users</h3>
<?php
if (!empty($active_users)) {
?>
        <table id="alluserlist" class="table table-sm">
            <thead class="headrow">
                <th>Username</th>
                <th>Email</th>
                <th>Timestamp</th>
                <th>Admin</th>
                <th>
                </th>
            </thead>
<?php
        foreach($active_users as $user){
            $x++;
            $del_user = 'deleteUser(\''.$user['id'].'\',\''.$user['email'].'\',\''.$user['username'].'\',\''.$x.'\');';
?>
            <tr class="datarow" scope="row" id="row<?=$x?>">
                <td><?=$user['username']?></td>
                <td><?=$user['email']?></td>
                <td><?=$user['timestamp']?></td>
                <td><?= $user['admin'] ? ($user['superadmin'] ? "Super Admin" : "Admin") : "" ?></td>
                <td>
                    <?php if ($user['id'] != $_SESSION['uid'] && (!$user['superadmin'] || $auth->isSuperAdmin())) { ?>
                    <button id="delbutton<?=$x?>" class="btn btn-danger btn-sm btn-fixed pull-right" onclick="<?=$del_user?>">Delete</button>
                    <?php } ?>
                </td>
            </tr>
<?php
        }
?>
        </table>
<?php
} else {
?>
        <p class="message">No users!</p>
<?php
}
?>

    </div>
    </body>
</html>
