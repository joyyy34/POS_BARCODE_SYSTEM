<?php

include_once 'connectdb.php';
session_start();



include_once "header.php";
if(isset($_POST['btnsave'])){

  $supplier = $_POST['txtsupplier'];
  
  if(empty($supplier)){
  
      $_SESSION['status'] = "Supplier Field is Empty!";
      $_SESSION['status_code'] = "warning";
  
  
  }elseif(isset($_POST['txtsupplier'])){

     $select=$pdo->prepare("select * from tbl_supplier where supplier='$supplier'");
 $select->execute();

if($select->rowCount()>0){
 $_SESSION['status'] = "Supplier Already Exist!";
      $_SESSION['status_code'] = "warning";

}else{

      
  
  
  $insert=$pdo->prepare("insert into tbl_supplier (supplier) values (:sup)");
  
  $insert->bindParam(':sup', $supplier);
  
  if($insert->execute()){
    $_SESSION['status'] = "Supplier Added successfully";
    $_SESSION['status_code'] = "success";
  
  }else{
    $_SESSION['status'] = "Supplier Added Failed";
    $_SESSION['status_code'] = "warning";
  
  }
}  

  } 
}


if(isset($_POST['btnupdate'])){

  $supplier = $_POST['txtsupplier'];
  $id = $_POST['txtsupid'];

  if(empty($supplier)){
  
    $_SESSION['status'] = "Supplier Field is Empty";
    $_SESSION['status_code'] = "warning";
  
  
  
  }else{
  
  $update=$pdo->prepare("update tbl_supplier set supplier=:sup where supid=" .$id);
  
  $update->bindParam(':sup', $supplier);
  
  if($update->execute()){ 
    $_SESSION['status'] = "Supplier Update successfully";
    $_SESSION['status_code'] = "success";
  
  }else{
    $_SESSION['status'] = "Supplier Update Failed";
    $_SESSION['status_code'] = "warning";
  
  

  }
  
  }}


if(isset($_POST['btndelete'])){

$delete=$pdo->prepare("delete from tbl_supplier where supid=".$_POST['btndelete']);
if($delete->execute()){
  $_SESSION['status'] ="Deleted!";
  $_SESSION['status_code'] = "success";


}else{
  $_SESSION['status'] ="Deleted Failed!";
  $_SESSION['status_code'] = "warning";

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
            <h1 class="m-0">Supplier</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <!--<li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
       
      <div class="card card-warning card-outline">
              <div class="card-header">
                <h5 class="m-0">Supplier Form</h5>
              </div>
              <div class="card-body">

              <form action="" method="post">       
<div class="row">


<?php

if(isset($_POST['btnedit'])){

$select=$pdo->prepare("select * from tbl_supplier where supid =" .$_POST['btnedit']);

$select->execute();

if($select){
$row=$select->fetch(PDO::FETCH_OBJ);



echo '<div class="col-lg-4">

<div class="form-group">
  <label for="exampleInputEmail1">Category</label>

  <input type="hidden" class="form-control"  placeholder="Enter Category" value="'.$row->supid.'"name="txtsupid" >

  <input type="text" class="form-control"  placeholder="Enter Category"  value="'.$row->supplier.'"name="txtsupplier" >
</div>






<div class="card-footer">
<button type="submit" class="btn btn-info" name="btnupdate">Update</button>
</div>





</div>';








}








}else{

echo '<div class="col-lg-4">

<div class="form-group">
  <label for="exampleInputEmail1">Category</label>
  <input type="text" class="form-control"  placeholder="Enter Supplier" name="txtsupplier" >
</div>






<div class="card-footer">
<button type="submit" class="btn btn-warning" name="btnsave">Save</button>
</div>

</div>';


}

?>

<div class="col-lg-8">

<table id= "table_supplier" class="table table-striped table-hover">
<thead>
<tr>
<td>#</td>
<td>Supplier</td>
<td>Edit</td>
<td>Delete</td>

</tr>

</thead>

<?php

$select = $pdo->prepare("select * from tbl_supplier order by supid ASC");  
$select->execute();

while($row=$select->fetch(PDO::FETCH_OBJ)) 
{

echo'
<tr>
<td>'.$row->supid.'</td>
<td>'.$row->supplier.'</td>


<td>
 
<button type ="submit" class="btn btn-primary"  value="'.$row->supid.'" name="btnedit">Edit</button>

</td>

<td>
 
<button type ="submit" class="btn btn-danger"  value="'.$row->supid.'" name="btndelete">Delete</button>


</td>

</tr>';

}

?>

</tbody>

<tfooter>

<td>#</td>
<td>Category</td>
<td>Edit</td>
<td>Delete</td>

</tfooter>




</table>




</div>





                
               
              </div>
           
              </form>
         
              </div>
           </div>
      
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
  
  <?php

include_once "footer.php";

?>


<?php

if(isset($_SESSION['status']) &&  $_SESSION['status']!='')
 
{




?>
<script>
    


      Swal.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>',
      });


</script>

<?php
unset($_SESSION['status']);
}


?>


<script>
    $(document).ready( function () {
        $('#table_supplier').DataTable();
    });
</script>


