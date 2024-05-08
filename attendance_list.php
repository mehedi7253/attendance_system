
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Attendance Records</h3>
        <!-- <div class="card-tools align-middle">
            <button class="btn btn-success btn-sm py-1 rounded-0" type="button" id="print"><i class="fa fa-print"></i> Print</button>
        </div> -->
    </div>
    <div class="card-body">

    <div class="border-1">
        <div class="row">
            <?php
                if (isset($_POST['search'])) {
                    $searchKey = $_POST['src'];
                    $search = $conn->query("SELECT * FROM attendance_list WHERE strftime('%m', date_created) = '$searchKey' LIMIT 1")->fetchArray();
                }
            ?>

            <div class="col-md-6">
                <form action="" method="POST">
                    <div class="form-group input-group col-md-5">
                        <select name="src" class="form-control">
                            <option>----------Select Month---------</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <input type="submit" class="btn btn-info ml-2" name="search" value="Submit">
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <?php
                    if (isset($_POST['search'])== true)
                    if($search > 0){?>
                        <a href="delete.php?attendance_data=<?php echo date('m', strtotime($search['date_created']));?>" class="btn btn-danger" onclick="return confirm('Are You Sure To Delete..!! Once you delete, you cant recover data again..')"><i class="fa fa-trash"></i> Delete</a>
                    <?php }else{
                        echo "<p class='text-danger'>No Data Found!</p>";
                    }
                ?>
           
            </div>
        </div>
        
    </div>



        <div class="table-responsive mt-5">
            <table class="table table-bordered table-hover table-striped" id="example">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Attendance Date</th>
                        <th>Attendance Time</th>
                        <th>Attendance Type</th>
                    </tr>
                </thead>
                    <?php 
                        $today = @date("m");
                        $att_qry = $conn->query("SELECT attendance_list.att_type_id as Type, attendance_list.date_created as attendanceDate, employee_list.firstname as FirstName, employee_list.lastname as LastName, employee_list.email as Email, employee_list.employee_code as EmployeeCode,  att_type_list.name FROM attendance_list, employee_list, att_type_list WHERE attendance_list.employee_id = employee_list.employee_id AND attendance_list.att_type_id = att_type_list.att_type_id AND strftime('%m', attendance_list.date_created) = '$today' order By attendance_list.date_created ASC");
                    ?>
                <tbody>
              
                    <?php $i = 1;
                    while($row = $att_qry->fetchArray()) {?>
                    <tr class="text-center">
                       <td><?php echo $i++; ?></td>
                       <td>
                            <p class="m-0">
                                <small><b>Employee Code:</b> <?php echo $row['EmployeeCode'] ?></small><br>
                                <small><b>Name:</b> <?php echo $row['FirstName'] ?> <?php echo $row['LastName'] ?></small>
                            </p>
                       <td><?php echo date("Y M d",strtotime($row['attendanceDate'])) ?></td>
                       <td><?php echo date("h:i A",strtotime($row['attendanceDate'])) ?></td>
                       <td>
                            <?php 
                                if($row['Type'] == '1')
                                    echo "<button class='btn btn-sm btn-success'>Time In</button>";
                                elseif($row['Type'] == '2')
                                    echo "<button class='btn btn-sm btn-danger'>Time Out</button>";
                                elseif($row['Type'] == '3')
                                    echo "<button class='btn btn-sm btn-success'>OT In</button>";
                                elseif($row['Type'] == '4')
                                    echo "<button class='btn btn-sm btn-danger'>Ot Out</button>";
                            ?>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div> 
    </div>
</div>
<script>
    // $(function(){
    //     $('#print').click(function(){
    //         var _h = $("head").clone()
    //         var _table = $('#att-list').clone()
    //         var _el = $("<div>")
    //         _el.append(_h)
    //         _el.append("<h2 class='text-center'>Attendance List</h2>")
    //         _el.append("<hr/>")
    //         _el.append(_table)

    //         var nw = window.open("","_blank","width=1200,height=900")
    //                  nw.document.write(_el.html())
    //                  nw.document.close()
    //                  setTimeout(() => {
    //                      nw.print()
    //                      setTimeout(() => {
    //                      nw.close()
    //                      }, 200);
    //                  }, 200);
    //     })
    // })
</script>