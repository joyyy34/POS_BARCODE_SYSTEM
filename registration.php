<?php
include_once 'connectdb.php';
session_start();

if ($_SESSION['useremail'] == "" OR $_SESSION['role'] == "User") {
    header('location:../index.php');
}

if ($_SESSION['role'] == "Admin") {
    include_once "header.php";
} else {
    include_once "headeruser.php";
}

error_reporting(0);

$id = $_GET['id'];

if (isset($id)) {
    $delete = $pdo->prepare("delete from tbl_user where userid=" . $id);

    if ($delete->execute()) {
        $_SESSION['status'] = "Account deleted successfully";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Something went wrong";
        $_SESSION['status_code'] = "warning";
    }
}

if (isset($_POST['btnsave'])) {
    $username = $_POST['txtname'];
    $useremail = $_POST['txtemail'];
    $userpassword = $_POST['txtpassword'];
    $userrole = $_POST['txtselect_option'];
    $useraddress = $_POST['txtaddress'];
    $userage = $_POST['txtage'];
    $usercontact = $_POST['txtcontact'];

    if ($userage < 18) { 
        $_SESSION['status'] = "NO MINORS ALLOWED TO CREATE AN ACCOUNT";
        $_SESSION['status_code'] = "warning";
    } else {
        $selectEmail = $pdo->prepare("SELECT useremail FROM tbl_user WHERE useremail = :useremail");
        $selectEmail->bindParam(':useremail', $useremail);
        $selectEmail->execute();

        if ($selectEmail->rowCount() > 0) {
            $_SESSION['status'] = "Email already exists. Please create a new email";
            $_SESSION['status_code'] = "warning";
        } else {
            $selectPassword = $pdo->prepare("SELECT userpassword FROM tbl_user WHERE userpassword = :userpassword");
            $selectPassword->bindParam(':userpassword', $userpassword);
            $selectPassword->execute();

            if ($selectPassword->rowCount() > 0) {
                $_SESSION['status'] = "Password already exists. Please create a new password";
                $_SESSION['status_code'] = "warning";
            } else {
                $insert = $pdo->prepare("INSERT INTO tbl_user (username, useremail, userpassword, role, address, age, contact) VALUES (:username, :useremail, :userpassword, :role, :address, :age, :contact)");

                $insert->bindParam(':username', $username);
                $insert->bindParam(':useremail', $useremail);
                $insert->bindParam(':userpassword', $userpassword);
                $insert->bindParam(':role', $userrole);
                $insert->bindParam(':address', $useraddress);
                $insert->bindParam(':age', $userage);
                $insert->bindParam(':contact', $usercontact);

                if ($insert->execute()) {
                    $_SESSION['status'] = "Insert successfully into the database";
                    $_SESSION['status_code'] = "success";
                } else {
                    $_SESSION['status'] = "Error inserting into the database";
                    $_SESSION['status_code'] = "error";
                }
            }
        }
    }
}

// Handle Edit Request
if(isset($_POST['btnedit'])) {
    $edit_id = $_POST['edit_id'];
    $edit_query = $pdo->prepare("SELECT * FROM tbl_user WHERE userid = :userid");
    $edit_query->bindParam(':userid', $edit_id);
    $edit_query->execute();
    $edit_data = $edit_query->fetch(PDO::FETCH_OBJ);
}


if(isset($_POST['btnupdate'])) {
    $edit_id = $_POST['edit_id'];
    $username = $_POST['txtname'];
    $useremail = $_POST['txtemail'];
    $userpassword = $_POST['txtpassword'];
    $userrole = $_POST['txtselect_option'];
    $useraddress = $_POST['txtaddress'];
    $userage = $_POST['txtage'];
    $usercontact = $_POST['txtcontact'];

    $update_query = $pdo->prepare("UPDATE tbl_user SET username = :username, useremail = :useremail, userpassword = :userpassword, role = :role, address = :address, age = :age, contact = :contact WHERE userid = :userid");
    $update_query->bindParam(':username', $username);
    $update_query->bindParam(':useremail', $useremail);
    $update_query->bindParam(':userpassword', $userpassword);
    $update_query->bindParam(':role', $userrole);
    $update_query->bindParam(':address', $useraddress);
    $update_query->bindParam(':age', $userage);
    $update_query->bindParam(':contact', $usercontact);
    $update_query->bindParam(':userid', $edit_id);

    if ($userage < 18) { 
      $_SESSION['status'] = "NO MINORS ALLOWED TO CREATE AN ACCOUNT";
      $_SESSION['status_code'] = "warning";
      } else {
          $selectPassword = $pdo->prepare("SELECT userpassword FROM tbl_user WHERE userpassword = :userpassword");
          $selectPassword->bindParam(':userpassword', $userpassword);
          $selectPassword->execute();

          if ($selectPassword->rowCount() > 0) {
              $_SESSION['status'] = "Password already exists. Please create a new password";
              $_SESSION['status_code'] = "warning";
          } else {
              $insert = $pdo->prepare("INSERT INTO tbl_user (username, useremail, userpassword, role, address, age, contact) VALUES (:username, :useremail, :userpassword, :role, :address, :age, :contact)");

              $insert->bindParam(':username', $username);
              $insert->bindParam(':useremail', $useremail);
              $insert->bindParam(':userpassword', $userpassword);
              $insert->bindParam(':role', $userrole);
              $insert->bindParam(':address', $useraddress);
              $insert->bindParam(':age', $userage);
              $insert->bindParam(':contact', $usercontact);


    if($update_query->execute()) {
        $_SESSION['status'] = "User updated successfully";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Error updating user";
        $_SESSION['status_code'] = "error";
    }
          }
        }
    }

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Registration</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">


        </div>
        <!-- /.col-md-6 -->
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Registration</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" name="txtname" value="<?= isset($edit_data) ? $edit_data->username : '' ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" placeholder="Enter email" name="txtemail" value="<?= isset($edit_data) ? $edit_data->useremail : '' ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Contact</label>
                                    <input type="text" class="form-control" placeholder="Enter Contact" name="txtcontact" value="<?= isset($edit_data) ? $edit_data->contact : '' ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Age</label>
                                    <input type="text" class="form-control" placeholder="Enter Age" name="txtage" value="<?= isset($edit_data) ? $edit_data->age : '' ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Address</label>
                                    <input type="text" class="form-control" placeholder="Enter Address" name="txtaddress" value="<?= isset($edit_data) ? $edit_data->address : '' ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="txtpassword" value="<?= isset($edit_data) ? $edit_data->userpassword : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name="txtselect_option" required>
                                        <option value="" disabled selected>Select Role</option>
                                        <option <?= (isset($edit_data) && $edit_data->role == "Admin") ? 'selected' : '' ?>>Admin</option>
                                        <option <?= (isset($edit_data) && $edit_data->role == "User") ? 'selected' : '' ?>>User</option>
                                    </select>
                                </div>
                                <?php if(isset($edit_data)) : ?>
                                <input type="hidden" name="edit_id" value="<?= $edit_data->userid ?>">
                                <button type="submit" class="btn btn-primary" name="btnupdate">Update</button>
                                <?php else : ?>
                                <button type="submit" class="btn btn-primary" name="btnsave">Save</button>
                                <?php endif; ?>
                            </form>
                        </div>

                        <div class="col-lg-8">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Name</td>
                                        <td>Email</td>
                                        <td>Password</td>
                                        <td>Role</td>
                                        <td>Address</td>
                                        <td>Age</td>
                                        <td>Contact</td>
                                        <td>Edit</td>
                                        <td>Delete</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $select = $pdo->prepare("select * from tbl_user order by userid ASC");
                                    $select->execute();
                                    while($row=$select->fetch(PDO::FETCH_OBJ)) {
                                        echo '
                                        <tr>
                                            <td>'.$row->userid.'</td>
                                            <td>'.$row->username.'</td>
                                            <td>'.$row->useremail.'</td>
                                            <td>'.$row->userpassword.'</td>
                                            <td>'.$row->role.'</td>
                                            <td>'.$row->address.'</td>
                                            <td>'.$row->age.'</td>
                                            <td>'.$row->contact.'</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="hidden" name="edit_id" value="'.$row->userid.'">
                                                    <button type="submit" class="btn btn-primary" name="btnedit">Edit</button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="registration.php?id='.$row->userid.'" class="btn btn-danger"><i class="fa fa-trash-alt"></i></a>
                                            </td>
                                        </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once "footer.php"; ?>

<?php if(isset($_SESSION['status']) && $_SESSION['status'] != '') : ?>
<script>
    Swal.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
    });
</script>
<?php unset($_SESSION['status']); ?>
<?php endif; ?>