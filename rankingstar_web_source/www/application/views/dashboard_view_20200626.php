<?php include "includes/header.php"?>
<title><?php echo lang('DASHBOARD'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('DASHBOARD'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('DASHBOARD'); ?></li>
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
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title"><?php echo lang('LBL_CONTEST_SUMMARY'); ?></h3>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-4">
                    <span class="lbl_dashboard openlabel"><?php echo lang('LBL_OPEN');?></span>
                    <div class="count">
                      <div class="circle open"><?php echo count($contestSummary['openContest'])?></div>
                    </div>
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                      <table class="table table-bordered">
                        <tbody>
                          <?php
                            $openContestList = $contestSummary['openContest'];
                            if(count($openContestList) > 0){
                              foreach($openContestList as $open){
                                echo "<tr>";
                                echo "<td>";
                                echo '<a href="' . BASE_URL . 'contestant?contestid=' . $open['contest_id'] . '">' .$open['contest_name'] . '</a>';
                                echo "</td>";
                                echo "<td style='text-align: center;'>";
                                echo $open['contestant_count'];
                                echo "</td>";
                                echo "</tr>";
                              }
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    
                  </div>
                  <hr>
                  <div class="col-lg-4">
                    <span class="lbl_dashboard preparinglabel"><?php echo lang('LBL_PREPARING');?></span>
                    <div class="count">
                      <div class="circle preparing"><?php echo count($contestSummary['preparingContest'])?></div>
                    </div>
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                      <table class="table table-bordered">
                        <tbody>
                          <?php
                            $preparingContestList = $contestSummary['preparingContest'];
                            if(count($preparingContestList) > 0){
                              foreach($preparingContestList as $preparing){
                                echo "<tr>";
                                echo "<td>";
                                echo '<a href="' . BASE_URL . 'contestant?contestid=' . $preparing['contest_id'] . '">' .$preparing['contest_name'] . '</a>';
                                echo "</td>";
                                echo "<td style='text-align: center;'>";
                                echo $preparing['contestant_count'];
                                echo "</td>";
                                echo "</tr>";
                              }
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <hr>
                  <div class="col-lg-4">
                    <span class="lbl_dashboard closelabel"><?php echo lang('LBL_CLOSE');?></span>
                    <div class="count">
                      <div class="circle closed"><?php echo count($contestSummary['closedContest'])?></div>
                    </div>
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                      <table class="table table-bordered">
                        <tbody>
                        <?php
                            $closedContestList = $contestSummary['closedContest'];
                            if(count($closedContestList) > 0){
                              foreach($closedContestList as $close){
                                echo "<tr>";
                                echo "<td>";
                                echo '<a href="' . BASE_URL . 'contestant?contestid=' . $close['contest_id'] . '">' .$close['contest_name'] . '</a>';
                                echo "</td>";
                                echo "<td style='text-align: center;'>";
                                echo $close['contestant_count'];
                                echo "</td>";
                                echo "</tr>";
                              }
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    
                  </div>
                  <hr>
                 
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title"><?php echo lang('LBL_SALES_SUMMARY'); ?></h3>
                </div>
              </div>
              <div class="card-body">
                <div class="row sales">
                  <div class="col-8"><?php echo lang('LBL_TOTAL_SALES');?></div>
                  <div class="col-4"><a href="<?php echo BASE_URL . "sales"; ?>"><button type="button" class="btn btn-block btn-primary"><?php echo  number_format($salesSummary['total_sales']['total_sales']); ?></button></a></div>
                </div>
                <div class="row sales">
                  <div class="col-8"><?php echo lang('LBL_MONTHLY_SALES');?></div>
                  <div class="col-4"><button type="button" class="btn btn-block btn-primary"><?php echo number_format($salesSummary['monthly_sales']['total_sales']); ?></button></div>
                </div>
                <div class="row sales">
                  <div class="col-8"><?php echo lang('LBL_DAILY_SALES');?></div>
                  <div class="col-4"><button type="button" class="btn btn-block btn-primary"><?php echo  number_format($salesSummary['daily_sales']['total_sales']); ?></button></div>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title"><?php echo lang('LBL_USER_SUMMARY') ?></h3>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-8"><?php echo lang('LBL_TOTAL_USER');?></div>
                  <div class="col-4"><a href="<?php echo BASE_URL . "user"; ?>"><button type="button" class="btn btn-block btn-primary"><?php echo $userSummary['user_count']; ?></button></a></div>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include "includes/footer.php"?>
<script type="text/javascript">
    $(document).ready(function(){

    });

</script>


