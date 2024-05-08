<?php if($_SESSION['type'] == 1): ?>
<h3>Welcome to Simple Attendance System</h3>
<hr>
<?php endif; ?>
<?php if($_SESSION['type'] == 3): ?>
    <section class="bg-dark bg-gradient text-light">
        <div class="container py-3 d-flex flex-column">
            <div class="w-100 h-25 d-flex  align-items-center">
                <h2 class="text-center w-100 fs-1"><b>Simple Attendance System</b></h2>
            </div>
            <div class="w-100 row flex-grow-1 mt-5">
                <div class="col-md-6 d-flex flex-column align-items-center h-100">
                    <div class="w-100 h-25 d-flex align-items-center">
                        <div class="w-100">
                            <h2 class="text-center"><b><span id="time_display"><?php echo date("h:i A") ?></span></b></h2>
                            <h5 class="text-center"><b><span id="date_display"><?php echo date("M d,Y ") ?></span></b></h5>
                            <input type="hidden" id="date_time" value="">
                        </div>
                    </div>
                    <div class="w-100 h-75 d-flex align-items-center">
                        <div class="w-100">
                            <div class="card text-dark col-sm-10 offset-sm-1 align-middle h-auto">
                                <div class="card-body">
                                <?php 
                                ?>
                                    <!-- <center><small>Please Enter your Employee Code</small></center> -->
                                    <div class="form-group">
                                        <center><small id="msg"></small></center>
                                        <?php
                                            $user = $conn->query("SELECT * FROM employee_list where employee_id = $_SESSION[user_id]");
                                            while($data = $user->fetchArray()){?>
                                            <input type="text" autofocus class="form-control form-control-sm rounded-0" disabled value="<?php echo $data['employee_code']?>" id="employee_code">
                                        <?php }?>
                                    </div>
                                    <div class="form-group d-flex justify-content-between mt-3 mb-1">
                                        <?php 
                                        $qry = $conn->query("SELECT * FROM `att_type_list` order by att_type_id asc");
                                        while($row= $qry->fetchArray()):
                                            $bg = 'primary';
                                            if(in_array($row['att_type_id'],array(2,4)))
                                            $bg = 'danger';
                                        ?>
                                        <button class="att_btn btn btn-sm btn-<?php echo $bg ?> rounded-0 py-0" type="button" data-id="<?php echo $row['att_type_id'] ?>"><?php echo $row['name'] ?></button>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            </div>
                        <!-- <center><a href="./admin.php" class="mt-4">Go to Admin Side</a></center> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 h-100 d-flex align-items-center">
                    <div class="w-100">
                        <div class="col-sm-9 offset-sm-1">
                            <h4 class="text-light text-center"><b>Today's Record</b></h4>
                            <div class="overflow-auto" style="height:67vh">
                                <ul class="list-group">
                                    <?php

                                    $today = date("Y-m-d");
                                    // echo $today;
                                    $att_qry = $conn->query("SELECT a.*,t.name as tname,(e.firstname || ' ' || e.lastname || ' ' || e.middlename) as `fullname` FROM `attendance_list` a inner join employee_list e on a.employee_id = e.employee_id inner join att_type_list t on a.att_type_id = t.att_type_id where date(a.date_created) = '".$today."' ORDER BY strftime('%s', a.date_created) desc");
                                    while($row = $att_qry->fetchArray()):
                                        $bg = "primary";
                                        if(in_array($row['att_type_id'],array(2,4)))
                                        $bg = "danger";
                                    ?>
                                    <li class="list-group-item att-item" data-id="<?php echo $row['attendance_id'] ?>">
                                    <div class="row row-cols-2">
                                        <div class="col-auto d-flex align-items-center"><span class="fa border border-dark p-2 fa-user rounded-circle" style="width:50px !important;height:50px !important" ></span></div>
                                        <div class="col-auto flex-grow-1 d-flex flex-column">
                                            <div class="w-100">
                                                <?php echo $row['fullname'] ?>
                                            </div>
                                            <div class='w-100 d-flex justify-content-end'>
                                                <small><span class="badge bg-<?php echo $bg ?>"><?php echo $row['tname'] ?><i class="fa fa-clock mx-1"></i><?php echo date("h:i A",strtotime($row['date_created'])) ?></span></small>
                                            </div>
                                        </div>
                                    </div>
                                    </li>
                                    <?php endwhile; ?>
                                    <?php if(!$att_qry->fetchArray()): ?>
                                    <li class="list-group-item" id="noData">No data listed yet.</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
    function date_time(){
        var currentdate = new Date(); 
        var datetime = "Last Sync: " + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + " @ "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var _m = months[currentdate.getMonth()]
        var _Y = currentdate.getFullYear()
        var _d = currentdate.getDate()
        $('#date_display').text(_m + ' ' +_d+', '+_Y)
        var _h = currentdate.getHours() > 12 ? String(currentdate.getHours() - 12).padStart(2, '0') : String(currentdate.getHours()).padStart(2, '0');
        var _H = String(currentdate.getHours()).padStart(2, '0');
        var _mm = String(currentdate.getMinutes()).padStart(2, '0')
        var _a = currentdate.getHours() > 12 ? "PM" : "AM";
        var _s = String(currentdate.getSeconds()).padStart(2, '0');
        $('#time_display').text(_h + ':' +_mm+':'+_s+' '+_a);
        // $('#date_time').val(_Y+'-'+String(currentdate.getMonth()+1).padStart(2, '0')+'-'+_d+'')
        $('#date_time').val(_Y+'-'+String(currentdate.getMonth()+1).padStart(2, '0')+'-'+String(currentdate.getDate()).padStart(2,'0')+' '+_H+':'+_mm+':'+_s)
        // $('#date_time').val(_Y+'-'+String(currentdate.getMonth()+1).padStart(2, '0')+'-'+String(currentdate.getDate()).padStart(2, '0')+'-'+'');
    }
    $(function(){
        setInterval(() => {
            date_time()
        }, 100);
        $('.att_btn').click(function(){
            $('#msg').removeClass('text-danger text-success').text('')
            var eCode = $('#employee_code').val()
            $("#employee_code").removeClass('border-danger')
            if(eCode == ''){
                $("#employee_code").addClass('border-danger').focus()
                return false;
            }
            var dateTime = $('#date_time').val()
            var att_type_id = $(this).attr('data-id')
            var att_type = $(this).text()
            $('.att_btn').attr('disabled',true)
            $.ajax({
                url:'Actions.php?a=save_attendance',
                method:'POST',
                data:{employee_code:eCode,att_type_id:att_type_id,date_created:dateTime,att_type:att_type},
                dataType:'json',
                error:err=>{
                    console.log(err)
                $('.att_btn').attr('disabled',false)
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload()
                    }else if(resp.status =='failed' && resp.msg){
                        var msg_h= $('#msg')
                        msg_h.addClass('text-danger')
                        msg_h.text(resp.msg)
                    }
                    $('.att_btn').attr('disabled',false)
                }
            })
        })
    })
</script>
<?php endif; ?>
