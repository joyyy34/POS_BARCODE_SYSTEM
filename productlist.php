
<?php
include_once 'connectdb.php';
session_start();

include_once "header.php";

?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
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
        <div class="row">
          <div class="col-lg-12">
           
             

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Product List :</h5>
              </div>
              <div class="card-body">
                


           <table class="table table-striped table-hover" id="table_product">


<thead>

<tr>
<td>Barcode</td>
<td>Product</td>
<td>Category</td>
<td>Description</td>
<td>Stock</td>
<td>PurchasePrice</td>
<td>SalePrice</td>
<td>Supplier</td>
<td>Image</td>
<td>ActionIcons</td>



</tr>

</thead>

<?php

$select = $pdo->prepare("select * from tbl_product order by pid ASC");  
$select->execute();

while($row=$select->fetch(PDO::FETCH_OBJ)) 
{

echo'
<tr>
<td>'.$row->barcode.'</td>
<td>'.$row->product.'</td>
<td>'.$row->category.'</td>
<td>'.$row->description.'</td>
<td>'.$row->stock.'</td>
<td>'.$row->purchaseprice.'</td>
<td>'.$row->saleprice.'</td>
<td>'.$row->supplier.'</td>

<td><image src="productimage/'.$row->image.'" class="img-rounded" width="40px" height="40px/"></td>

<td>

<div class="btn-group">

<a href=printbarcode.php?id='.$row->pid.'" class="btn btn-dark btn-xs" role="button"><span class="fa fa-barcode" style="color:#ffffff" data-toggle="tooltip" tittle="PrintBarcode"></span></a>

<a href=viewproduct.php?id='.$row->pid.'" class="btn btn-warning btn-xs" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" tittle="View Product"></span></a>

<a href=editproduct.php?id='.$row->pid.'" class="btn btn-success btn-xs" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" tittle="Edit Product"></span></a>


<button id='.$row->pid.' class="btn btn-danger btn-xs btndelete"><span class="fa fa-trash" style=color:#ffffff" data-toggle="tooltip" tittle="Delete Product"</span></button>

</div>

</td>



</tr>';

}

?>


<tbody>





</tbody>



</table>

              </div>
            </div>
           

       

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <?php

include_once "footer.php";

?>

<script>
    $(document).ready( function () {
        $('#table_product').DataTable();
    });
</script>

<script>
    $(document).ready( function () {
    $('[data-toggle="tooltip"]').tooltip();
    });

</script>


<script>
  $(document).ready(function () {
  $('.btndelete').click(function () {
  var tdt = $(this);
  var id = $(this).attr("id");



         Swal.fire({
  title: "Do you want to delete?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes, delete it!"
}).then((result) => {
  if (result.isConfirmed) {

    $.ajax({

          url: 'productdelete.php',
          type: 'post',
          data: {
          pidd: id
          },
           success: function(data) {
          tdh.parents('tr').hide();
          }

          });
    
    Swal.fire({
      title: "Deleted!",
      text: "Your product has been deleted.",
      icon: "success"
    })
  }
})



  });

});
</script>
</script>